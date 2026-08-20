<?php

namespace App\Libraries;

final class IuranPeriodSummary
{
    private const MONTHS = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    public static function resolvePeriod(array $filters, int $defaultMonth, int $defaultYear, ?array $bounds = null): array
    {
        $jenis = $filters['jenis_periode'] ?? 'bulanan';
        if (!in_array($jenis, ['bulanan', 'tahunan', 'rentang'], true)) {
            $jenis = 'bulanan';
        }

        $defaultMonth = self::normalizeMonth($defaultMonth, (int) date('n'));
        $defaultYear = self::normalizeYear($defaultYear, (int) date('Y'));
        $bounds = self::normalizeBounds($bounds);

        $startMonth = self::normalizeMonth($filters['bulan_awal'] ?? $filters['bulan'] ?? $defaultMonth, $defaultMonth);
        $startYear = self::normalizeYear($filters['tahun_awal'] ?? $filters['tahun'] ?? $defaultYear, $defaultYear);
        $endMonth = self::normalizeMonth($filters['bulan_akhir'] ?? $startMonth, $startMonth);
        $endYear = self::normalizeYear($filters['tahun_akhir'] ?? $startYear, $startYear);

        if ($jenis === 'bulanan') {
            $endMonth = $startMonth;
            $endYear = $startYear;
        }

        if ($jenis === 'tahunan') {
            $startMonth = 1;
            $endMonth = 12;
            $startYear = self::normalizeYear($filters['tahun_tahunan'] ?? $filters['tahun'] ?? $startYear, $startYear);
            $endYear = $startYear;
        }

        if ($bounds !== null) {
            $boundStart = self::serial($bounds['start']['tahun'], $bounds['start']['bulan']);
            $boundEnd = self::serial($bounds['end']['tahun'], $bounds['end']['bulan']);
            $startSerial = self::clampSerial(self::serial($startYear, $startMonth), $boundStart, $boundEnd);
            $endSerial = self::clampSerial(self::serial($endYear, $endMonth), $boundStart, $boundEnd);
            [$startYear, $startMonth] = self::periodFromSerial($startSerial);
            [$endYear, $endMonth] = self::periodFromSerial($endSerial);
        }

        if (self::serial($startYear, $startMonth) > self::serial($endYear, $endMonth)) {
            [$startMonth, $endMonth] = [$endMonth, $startMonth];
            [$startYear, $endYear] = [$endYear, $startYear];
        }

        $keys = [];
        $month = $startMonth;
        $year = $startYear;

        while (self::serial($year, $month) <= self::serial($endYear, $endMonth)) {
            $keys[] = sprintf('%04d-%02d', $year, $month);
            $month++;

            if ($month === 13) {
                $month = 1;
                $year++;
            }
        }

        return [
            'jenis' => $jenis,
            'start' => ['bulan' => $startMonth, 'tahun' => $startYear],
            'end'   => ['bulan' => $endMonth, 'tahun' => $endYear],
            'keys'  => $keys,
            'label' => self::formatLabel($jenis, $startMonth, $startYear, $endMonth, $endYear),
        ];
    }

    public static function resolveBounds(?string $startDate, int $endMonth, int $endYear): array
    {
        $endMonth = self::normalizeMonth($endMonth, (int) date('n'));
        $endYear = self::normalizeYear($endYear, (int) date('Y'));
        $startTimestamp = $startDate ? strtotime($startDate) : false;
        $startYear = $startTimestamp === false ? $endYear : (int) date('Y', $startTimestamp);
        $startMonth = $startTimestamp === false ? 1 : (int) date('n', $startTimestamp);
        $startYear = self::normalizeYear($startYear, $endYear);
        $startMonth = self::normalizeMonth($startMonth, 1);

        if (self::serial($startYear, $startMonth) > self::serial($endYear, $endMonth)) {
            $startYear = $endYear;
            $startMonth = $endMonth;
        }

        return [
            'start' => ['bulan' => $startMonth, 'tahun' => $startYear],
            'end'   => ['bulan' => $endMonth, 'tahun' => $endYear],
        ];
    }

    public static function availableYears(array $bounds): array
    {
        $normalized = self::normalizeBounds($bounds);
        if ($normalized === null) {
            return [];
        }

        return range($normalized['start']['tahun'], $normalized['end']['tahun']);
    }

    /**
     * Ambil kebijakan terakhir yang sudah mulai berlaku pada tanggal tertentu.
     * Kebijakan terjadwal tidak boleh memengaruhi tagihan sebelum tanggalnya.
     */
    public static function effectiveSetting(array $settings, ?string $date = null): ?array
    {
        $today = $date ? date('Y-m-d', strtotime($date)) : date('Y-m-d');
        $effective = null;

        foreach ($settings as $setting) {
            $berlakuDari = (string) ($setting['berlaku_dari'] ?? '');
            if ($berlakuDari === '' || $berlakuDari > $today) {
                continue;
            }

            if ($effective === null
                || $berlakuDari > (string) ($effective['berlaku_dari'] ?? '')
                || ($berlakuDari === ($effective['berlaku_dari'] ?? '')
                    && (int) ($setting['id'] ?? 0) > (int) ($effective['id'] ?? 0))) {
                $effective = $setting;
            }
        }

        return $effective;
    }

    public static function normalizePhone(?string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone ?? '') ?? '';
        if ($digits === '') {
            return '';
        }

        if (str_starts_with($digits, '00')) {
            $digits = substr($digits, 2);
        }
        if (str_starts_with($digits, '62')) {
            return $digits;
        }
        if (str_starts_with($digits, '0')) {
            return '62' . substr($digits, 1);
        }
        if (str_starts_with($digits, '8')) {
            return '62' . $digits;
        }

        return '';
    }
    public static function residentBilling(
        array $warga,
        array $pembayaran,
        array $period,
        int $nominalIuran
    ): array {
        $userId = (int) ($warga['id'] ?? 0);
        $paymentsByPeriod = [];

        foreach ($pembayaran as $payment) {
            if ((int) ($payment['user_id'] ?? 0) !== $userId) {
                continue;
            }

            $key = self::paymentKey($payment);
            if ($key !== null) {
                $paymentsByPeriod[$key] = $payment;
            }
        }

        $eligibleKeys = self::eligibleKeys($period['keys'] ?? [], $warga['created_at'] ?? null);
        $latestKey = $period['keys'][count($period['keys'] ?? []) - 1] ?? null;
        $tagihan = [];

        foreach ($eligibleKeys as $key) {
            $payment = $paymentsByPeriod[$key] ?? null;
            $status = self::normalizeStatus($payment['status'] ?? '');
            if ($status === 'terverifikasi' || $status === 'pending') {
                continue;
            }

            [$year, $month] = array_map('intval', explode('-', $key));
            $tarif = (int) ($payment['nominal'] ?? $nominalIuran);
            if ($tarif < 1) {
                $tarif = $nominalIuran;
            }
            $tagihan[] = [
                'bulan'  => $month,
                'tahun'  => $year,
                'label'   => self::formatLabel('bulanan', $month, $year, $month, $year),
                'tarif'   => $tarif,
                'status'  => $key === $latestKey ? 'Bulan Berjalan' : 'Tunggakan',
            ];
        }

        return [
            'tagihan'        => $tagihan,
            'total_tagihan'  => array_sum(array_column($tagihan, 'tarif')),
            'jumlah_periode' => count($eligibleKeys),
        ];
    }
    public static function summarize(
        array $warga,
        array $pembayaran,
        array $period,
        int $nominalIuran,
        int $toleransiMacet,
        ?array $statusPeriod = null
    ): array {
        $paymentsByUserPeriod = [];

        foreach ($pembayaran as $payment) {
            $key = self::paymentKey($payment);
            if ($key === null || !isset($payment['user_id'])) {
                continue;
            }

            $paymentsByUserPeriod[(int) $payment['user_id']][$key] = $payment;
        }

        $statistik = [
            'total_warga'         => 0,
            'menunggu_verifikasi' => 0,
            'total_pending'       => 0,
            'lunas'               => 0,
            'total_terverifikasi' => 0,
            'belum_bayar'         => 0,
            'macet'               => 0,
            'total_tunggakan'     => 0,
            'total_target'        => 0,
        ];
        $rekapWarga = [];
        $toleransiMacet = max(1, $toleransiMacet);
        $nominalIuran = max(0, $nominalIuran);

        foreach ($warga as $wargaItem) {
            $eligibleKeys = self::eligibleKeys($period['keys'] ?? [], $wargaItem['created_at'] ?? null);

            if ($eligibleKeys === []) {
                continue;
            }

            $userId = (int) ($wargaItem['id'] ?? 0);
            $summary = [
                'id'                    => $userId,
                'nama'                  => $wargaItem['nama'] ?? '',
                'blok_rumah'            => $wargaItem['blok_rumah'] ?? '',
                'no_rumah'              => $wargaItem['no_rumah'] ?? '',
                'no_telepon'            => $wargaItem['no_telepon'] ?? '',
                'periode_label'         => $period['label'] ?? '',
                'jumlah_periode'        => count($eligibleKeys),
                'total_tagihan'         => count($eligibleKeys) * $nominalIuran,
                'total_terverifikasi'   => 0,
                'total_pending'         => 0,
                'total_sisa'            => 0,
                'bulan_belum_bayar'     => 0,
                'jumlah_pending'        => 0,
                'pembayaran_pending'    => [],
                'pembayaran_terverifikasi' => [],
            ];

            foreach ($eligibleKeys as $key) {
                $payment = $paymentsByUserPeriod[$userId][$key] ?? null;
                $status = self::normalizeStatus($payment['status'] ?? '');
                $nominalBayar = (int) ($payment['nominal'] ?? $nominalIuran);

                if ($status === 'terverifikasi') {
                    $summary['total_terverifikasi'] += $nominalBayar;
                    $summary['pembayaran_terverifikasi'][] = $payment;
                    continue;
                }

                if ($status === 'pending') {
                    $summary['total_pending'] += $nominalBayar;
                    $summary['jumlah_pending']++;
                    $summary['pembayaran_pending'][] = $payment;
                    continue;
                }

                $summary['bulan_belum_bayar']++;
                $summary['total_sisa'] += $nominalIuran;
            }

            $summary['periode_bulan_belum_bayar'] = $summary['bulan_belum_bayar'];
            $summary['periode_total_sisa'] = $summary['total_sisa'];

            if ($statusPeriod !== null) {
                $statusKeys = self::eligibleKeys($statusPeriod['keys'] ?? [], $wargaItem['created_at'] ?? null);
                $statusBulanBelumBayar = 0;
                $statusTotalSisa = 0;

                foreach ($statusKeys as $statusKey) {
                    $statusPayment = $paymentsByUserPeriod[$userId][$statusKey] ?? null;
                    $status = self::normalizeStatus($statusPayment['status'] ?? '');
                    if ($status === 'terverifikasi' || $status === 'pending') {
                        continue;
                    }

                    $statusBulanBelumBayar++;
                    $statusTotalSisa += $nominalIuran;
                }

                $summary['bulan_belum_bayar'] = $statusBulanBelumBayar;
                $summary['total_sisa'] = $statusTotalSisa;
            }

            $summary['butuh_verifikasi'] = $summary['jumlah_pending'] > 0;
            $summary['punya_tunggakan'] = $summary['bulan_belum_bayar'] > 0;
            $summary['macet'] = $summary['bulan_belum_bayar'] >= $toleransiMacet;
            $summary['lunas'] = $summary['total_sisa'] === 0
                && $summary['jumlah_pending'] === 0
                && $summary['total_terverifikasi'] >= $summary['total_tagihan'];

            if ($summary['lunas']) {
                $summary['status'] = 'terverifikasi';
                $summary['keterangan'] = 'Lunas untuk ' . $summary['jumlah_periode'] . ' bulan';
            } elseif ($summary['macet']) {
                $summary['status'] = 'tunggakan';
                $summary['keterangan'] = 'Macet ' . $summary['bulan_belum_bayar'] . ' bulan';
            } elseif ($summary['punya_tunggakan']) {
                $summary['status'] = 'belum_bayar';
                $summary['keterangan'] = 'Belum bayar ' . $summary['bulan_belum_bayar'] . ' bulan';
            } else {
                $summary['status'] = 'pending';
                $summary['keterangan'] = $summary['jumlah_pending'] . ' pembayaran menunggu verifikasi';
            }

            if ($summary['butuh_verifikasi']) {
                $statistik['menunggu_verifikasi']++;
                $statistik['total_pending'] += $summary['total_pending'];
            }

            if ($summary['lunas']) {
                $statistik['lunas']++;
            }

            if ($summary['punya_tunggakan'] && !$summary['macet']) {
                $statistik['belum_bayar']++;
            }

            if ($summary['macet']) {
                $statistik['macet']++;
                $statistik['total_tunggakan'] += $summary['total_sisa'];
            }

            $statistik['total_warga']++;
            $statistik['total_target'] += $summary['total_tagihan'];
            $statistik['total_terverifikasi'] += $summary['total_terverifikasi'];
            $rekapWarga[] = $summary;
        }

        return [
            'warga'     => $rekapWarga,
            'statistik' => $statistik,
        ];
    }

    private static function normalizeBounds(?array $bounds): ?array
    {
        if ($bounds === null || !isset($bounds['start'], $bounds['end'])) {
            return null;
        }

        $startMonth = self::normalizeMonth($bounds['start']['bulan'] ?? 1, 1);
        $startYear = self::normalizeYear($bounds['start']['tahun'] ?? (int) date('Y'), (int) date('Y'));
        $endMonth = self::normalizeMonth($bounds['end']['bulan'] ?? 12, 12);
        $endYear = self::normalizeYear($bounds['end']['tahun'] ?? $startYear, $startYear);

        if (self::serial($startYear, $startMonth) > self::serial($endYear, $endMonth)) {
            [$startMonth, $endMonth] = [$endMonth, $startMonth];
            [$startYear, $endYear] = [$endYear, $startYear];
        }

        return [
            'start' => ['bulan' => $startMonth, 'tahun' => $startYear],
            'end'   => ['bulan' => $endMonth, 'tahun' => $endYear],
        ];
    }

    private static function clampSerial(int $serial, int $minimum, int $maximum): int
    {
        return max($minimum, min($serial, $maximum));
    }

    private static function periodFromSerial(int $serial): array
    {
        $year = intdiv($serial - 1, 12);
        $month = $serial - ($year * 12);

        return [$year, $month];
    }
    private static function normalizeMonth(mixed $value, int $fallback): int
    {
        $month = (int) $value;

        return $month >= 1 && $month <= 12 ? $month : $fallback;
    }

    private static function normalizeYear(mixed $value, int $fallback): int
    {
        $year = (int) $value;

        return $year >= 2000 && $year <= 2100 ? $year : $fallback;
    }

    private static function serial(int $year, int $month): int
    {
        return ($year * 12) + $month;
    }

    private static function formatLabel(
        string $jenis,
        int $startMonth,
        int $startYear,
        int $endMonth,
        int $endYear
    ): string {
        if ($jenis === 'tahunan') {
            return 'Tahun ' . $startYear;
        }

        if ($startMonth === $endMonth && $startYear === $endYear) {
            return self::MONTHS[$startMonth] . ' ' . $startYear;
        }

        if ($startYear === $endYear) {
            return self::MONTHS[$startMonth] . ' - ' . self::MONTHS[$endMonth] . ' ' . $startYear;
        }

        return self::MONTHS[$startMonth] . ' ' . $startYear
            . ' - '
            . self::MONTHS[$endMonth] . ' ' . $endYear;
    }

    private static function paymentKey(array $payment): ?string
    {
        $month = (int) ($payment['periode_bulan'] ?? 0);
        $year = (int) ($payment['periode_tahun'] ?? 0);

        if ($month < 1 || $month > 12 || $year < 2000 || $year > 2100) {
            return null;
        }

        return sprintf('%04d-%02d', $year, $month);
    }

    private static function eligibleKeys(array $keys, mixed $createdAt): array
    {
        $joinedAt = is_string($createdAt) ? strtotime($createdAt) : false;

        if ($joinedAt === false) {
            return $keys;
        }

        $joinedYear = (int) date('Y', $joinedAt);
        $joinedMonth = (int) date('n', $joinedAt);
        $joinedSerial = self::serial($joinedYear, $joinedMonth);

        return array_values(array_filter(
            $keys,
            static function (string $key) use ($joinedSerial): bool {
                [$year, $month] = array_map('intval', explode('-', $key));

                return self::serial($year, $month) >= $joinedSerial;
            }
        ));
    }

    private static function normalizeStatus(mixed $status): string
    {
        return $status === 'lunas' ? 'terverifikasi' : (string) $status;
    }
}
