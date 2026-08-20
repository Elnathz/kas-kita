<?php

use App\Libraries\IuranPeriodSummary;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class IuranPeriodSummaryTest extends CIUnitTestCase
{
    public function testResolvePeriodBuildsInclusiveMonthlyRange(): void
    {
        $period = IuranPeriodSummary::resolvePeriod([
            'jenis_periode' => 'rentang',
            'bulan_awal'    => 7,
            'tahun_awal'    => 2026,
            'bulan_akhir'   => 8,
            'tahun_akhir'   => 2026,
        ], 8, 2026);

        $this->assertSame('rentang', $period['jenis']);
        $this->assertSame(['2026-07', '2026-08'], $period['keys']);
        $this->assertSame('Juli - Agustus 2026', $period['label']);
    }

    public function testResolvePeriodBuildsWholeYear(): void
    {
        $period = IuranPeriodSummary::resolvePeriod([
            'jenis_periode' => 'tahunan',
            'tahun_tahunan' => 2025,
        ], 8, 2026);

        $this->assertSame('tahunan', $period['jenis']);
        $this->assertCount(12, $period['keys']);
        $this->assertSame('2025-01', $period['keys'][0]);
        $this->assertSame('2025-12', $period['keys'][11]);
        $this->assertSame('Tahun 2025', $period['label']);
    }

    public function testSummarizeSeparatesVerifiedPendingAndOutstandingAmounts(): void
    {
        $period = [
            'keys'  => ['2026-07', '2026-08'],
            'label' => 'Juli - Agustus 2026',
        ];

        $summary = IuranPeriodSummary::summarize(
            [[
                'id'         => 10,
                'nama'       => 'Siti Aminah',
                'blok_rumah' => 'Blok A',
                'no_rumah'   => '01',
                'no_telepon' => '081234567890',
                'created_at' => '2026-01-10 08:00:00',
            ]],
            [
                [
                    'id'            => 1,
                    'user_id'       => 10,
                    'periode_bulan' => 7,
                    'periode_tahun' => 2026,
                    'nominal'       => 50000,
                    'status'        => 'terverifikasi',
                ],
                [
                    'id'            => 2,
                    'user_id'       => 10,
                    'periode_bulan' => 8,
                    'periode_tahun' => 2026,
                    'nominal'       => 50000,
                    'status'        => 'pending',
                ],
            ],
            $period,
            50000,
            2,
        );

        $warga = $summary['warga'][0];

        $this->assertSame(2, $warga['jumlah_periode']);
        $this->assertSame(100000, $warga['total_tagihan']);
        $this->assertSame(50000, $warga['total_terverifikasi']);
        $this->assertSame(50000, $warga['total_pending']);
        $this->assertSame(0, $warga['total_sisa']);
        $this->assertTrue($warga['butuh_verifikasi']);
        $this->assertFalse($warga['lunas']);
        $this->assertSame(1, $summary['statistik']['menunggu_verifikasi']);
        $this->assertSame(50000, $summary['statistik']['total_pending']);
    }

    public function testSummarizeBillsOnlyMonthsAfterResidentJoined(): void
    {
        $period = [
            'keys'  => ['2026-07', '2026-08'],
            'label' => 'Juli - Agustus 2026',
        ];

        $summary = IuranPeriodSummary::summarize(
            [[
                'id'         => 11,
                'nama'       => 'Budi Santoso',
                'blok_rumah' => 'Blok B',
                'no_rumah'   => '02',
                'no_telepon' => '081298765432',
                'created_at' => '2026-08-01 09:00:00',
            ]],
            [],
            $period,
            50000,
            2,
        );

        $warga = $summary['warga'][0];

        $this->assertSame(1, $warga['jumlah_periode']);
        $this->assertSame(50000, $warga['total_tagihan']);
        $this->assertSame(50000, $warga['total_sisa']);
        $this->assertSame(1, $summary['statistik']['belum_bayar']);
        $this->assertSame(0, $summary['statistik']['macet']);
    }

    public function testSummarizeMarksResidentMacetWithinSelectedPeriod(): void
    {
        $period = [
            'keys'  => ['2026-07', '2026-08'],
            'label' => 'Juli - Agustus 2026',
        ];

        $summary = IuranPeriodSummary::summarize(
            [[
                'id'         => 12,
                'nama'       => 'Dewi Lestari',
                'blok_rumah' => 'Blok C',
                'no_rumah'   => '03',
                'no_telepon' => '081277788899',
                'created_at' => '2026-01-01 09:00:00',
            ]],
            [],
            $period,
            50000,
            2,
        );

        $warga = $summary['warga'][0];

        $this->assertTrue($warga['punya_tunggakan']);
        $this->assertTrue($warga['macet']);
        $this->assertSame(100000, $warga['total_sisa']);
        $this->assertSame(1, $summary['statistik']['macet']);
        $this->assertSame(100000, $summary['statistik']['total_tunggakan']);
    }

    public function testMonthlyViewCanUseCumulativePeriodForMacetStatus(): void
    {
        $summary = IuranPeriodSummary::summarize(
            [[
                'id' => 14,
                'nama' => 'Rudi Hartono',
                'blok_rumah' => 'Blok R',
                'no_rumah' => '04',
                'created_at' => '2026-01-01 09:00:00',
            ]],
            [],
            [
                'keys' => ['2026-08'],
                'label' => 'Agustus 2026',
            ],
            50000,
            3,
            [
                'keys' => ['2026-01', '2026-02', '2026-03', '2026-04', '2026-05', '2026-06', '2026-07', '2026-08'],
                'label' => 'Januari - Agustus 2026',
            ],
        );

        $warga = $summary['warga'][0];

        $this->assertSame(8, $warga['bulan_belum_bayar']);
        $this->assertSame(400000, $warga['total_sisa']);
        $this->assertTrue($warga['macet']);
        $this->assertSame(1, $summary['statistik']['macet']);
    }
    public function testResolvePeriodClampsSelectionToConfiguredBounds(): void
    {
        $bounds = [
            'start' => ['bulan' => 1, 'tahun' => 2026],
            'end'   => ['bulan' => 8, 'tahun' => 2026],
        ];

        $period = IuranPeriodSummary::resolvePeriod([
            'jenis_periode' => 'rentang',
            'bulan_awal'    => 1,
            'tahun_awal'    => 2025,
            'bulan_akhir'   => 12,
            'tahun_akhir'   => 2027,
        ], 8, 2026, $bounds);

        $this->assertSame('2026-01', $period['keys'][0]);
        $this->assertSame('2026-08', $period['keys'][7]);
        $this->assertCount(8, $period['keys']);
        $annual = IuranPeriodSummary::resolvePeriod([
            'jenis_periode' => 'tahunan',
            'tahun_tahunan' => 2026,
        ], 8, 2026, $bounds);

        $this->assertCount(8, $annual['keys']);
        $this->assertSame('2026-08', $annual['keys'][7]);
    }

    public function testResidentBillingUsesEligiblePeriodsAndTreatsRejectedPaymentAsUnpaid(): void
    {
        $period = [
            'keys'  => ['2026-01', '2026-02', '2026-03', '2026-04'],
            'label' => 'Januari - April 2026',
        ];

        $billing = IuranPeriodSummary::residentBilling([
            'id'         => 13,
            'nama'       => 'Rina Wijaya',
            'created_at' => '2026-02-15 08:00:00',
        ], [
            [
                'user_id'       => 13,
                'periode_bulan' => 2,
                'periode_tahun' => 2026,
                'nominal'       => 50000,
                'status'        => 'terverifikasi',
            ],
            [
                'user_id'       => 13,
                'periode_bulan' => 3,
                'periode_tahun' => 2026,
                'nominal'       => 50000,
                'status'        => 'ditolak',
            ],
        ], $period, 50000);

        $this->assertSame(['Maret 2026', 'April 2026'], array_column($billing['tagihan'], 'label'));
        $this->assertSame(100000, $billing['total_tagihan']);
        $this->assertSame(3, $billing['jumlah_periode']);
    }

    public function testResidentBillingUsesRejectedPaymentNominalWhenRetryingPayment(): void
    {
        $billing = IuranPeriodSummary::residentBilling([
            'id' => 15,
            'created_at' => '2026-08-01 09:00:00',
        ], [[
            'user_id' => 15,
            'periode_bulan' => 8,
            'periode_tahun' => 2026,
            'nominal' => 50000,
            'status' => 'ditolak',
        ]], [
            'keys' => ['2026-08'],
            'label' => 'Agustus 2026',
        ], 5000);

        $this->assertSame(50000, $billing['total_tagihan']);
        $this->assertSame(50000, $billing['tagihan'][0]['tarif']);
    }

    public function testAvailableYearsFollowConfiguredPeriod(): void
    {
        $years = IuranPeriodSummary::availableYears([
            'start' => ['bulan' => 7, 'tahun' => 2024],
            'end'   => ['bulan' => 8, 'tahun' => 2026],
        ]);

        $this->assertSame([2024, 2025, 2026], $years);
    }

    public function testEffectiveSettingIgnoresFuturePolicy(): void
    {
        $setting = IuranPeriodSummary::effectiveSetting([
            ['id' => 1, 'nominal' => 50000, 'berlaku_dari' => '2026-01-01'],
            ['id' => 2, 'nominal' => 5000000, 'berlaku_dari' => '2026-08-22'],
        ], '2026-08-20');

        $this->assertSame(1, $setting['id']);
        $this->assertSame(50000, $setting['nominal']);
    }

    public function testEffectiveSettingUsesLatestPolicyOnEffectiveDate(): void
    {
        $setting = IuranPeriodSummary::effectiveSetting([
            ['id' => 1, 'nominal' => 50000, 'berlaku_dari' => '2026-01-01'],
            ['id' => 2, 'nominal' => 5000000, 'berlaku_dari' => '2026-08-22'],
        ], '2026-08-22');

        $this->assertSame(2, $setting['id']);
        $this->assertSame(5000000, $setting['nominal']);
    }

    public function testNormalizePhoneCreatesWaMeCompatibleNumber(): void
    {
        $this->assertSame('628123456789', IuranPeriodSummary::normalizePhone('08123456789'));
        $this->assertSame('628123456789', IuranPeriodSummary::normalizePhone('+62 812-3456-789'));
        $this->assertSame('628123456789', IuranPeriodSummary::normalizePhone('8123456789'));
        $this->assertSame('', IuranPeriodSummary::normalizePhone('Nomor tidak tersedia'));
    }
}
