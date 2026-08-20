<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->
<?php
$wilayahFooter = [];
if (class_exists('App\\Models\\PengaturanSistemModel')) {
    foreach ((new \App\Models\PengaturanSistemModel())->where('kategori', 'wilayah')->findAll() as $row) {
        $wilayahFooter[$row['kunci']] = $row['nilai'];
    }
}
$formatWilayahFooter = static function (string $prefix, $nilai): string {
    $nilai = trim((string) $nilai);
    if ($nilai === '') return $prefix;
    $nilai = preg_replace('/^' . preg_quote($prefix, '/') . '\\s*/i', '', $nilai);
    return $prefix . ' ' . trim($nilai);
};
$identitasFooter = $formatWilayahFooter('RT', $wilayahFooter['rt'] ?? '') . ' / ' . $formatWilayahFooter('RW', $wilayahFooter['rw'] ?? '');
?>
<footer class="footer text-center text-muted font-12 py-3">
    &copy; <?= date('Y') ?> <strong>Kas-Kita</strong> &bull; Sistem Pengelolaan Kas <?= esc($identitasFooter) ?>. Transparan, Akuntabel, &amp; Gotong Royong.
</footer>
<!-- ============================================================== -->
<!-- End footer -->
<!-- ============================================================== -->
