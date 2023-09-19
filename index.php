<?php
if (isset($_GET['tahun']) && $_GET['tahun'] != "") {
    // Mendapatkan data menu dari API
    $menu = json_decode(file_get_contents("http://tes-web.landa.id/intermediate/menu"), true);
    // Mendapatkan data transaksi berdasarkan tahun dari API
    $transaksi = json_decode(file_get_contents("http://tes-web.landa.id/intermediate/transaksi?tahun=" . $_GET['tahun']), true);
    $values = array();
    for ($i = 1; $i <= 12; $i++) {
        $values[] = 0;
    }
    // Menambahkan kolom "value" dan "totalHarga" ke data menu
    for ($key = 0; $key < count($menu); $key++) {
        $menu[$key]['value'] = $values;
        $menu[$key]['totalHarga'] = 0;
    }

    // Variabel total harga makanan dan minuman per bulan
    $totalHargaMakanan = array_fill(0, 12, 0);
    $totalHargaMinuman = array_fill(0, 12, 0);

    // Menggunakan for loop untuk mengiterasi transaksi
    for ($keyTrans = 0; $keyTrans < count($transaksi); $keyTrans++) {
        $valueTrans = $transaksi[$keyTrans];
        $harga = $valueTrans['total'];
        $dateFormat = DateTime::createFromFormat("Y-m-d", $valueTrans['tanggal']);
        $bulan = $dateFormat->format("n");

        // Menggunakan for loop untuk mengiterasi menu
        for ($keyMenu = 0; $keyMenu < count($menu); $keyMenu++) {
            $valueMenu = $menu[$keyMenu];
            $totalSemua = 0;
            // Memeriksa apakah menu dari transaksi cocok dengan menu dari data menu
            if ($valueMenu['menu'] === $valueTrans['menu']) {
                // Menambahkan nilai harga ke bulan yang sesuai
                $menu[$keyMenu]['value'][$bulan - 1] += $harga;
                $totalSemua += $harga;

                // Pisahkan perhitungan total harga makanan dan minuman
                if ($valueMenu['kategori'] === "makanan") {
                    $totalHargaMakanan[$bulan - 1] += $harga;
                } elseif ($valueMenu['kategori'] === "minuman") {
                    $totalHargaMinuman[$bulan - 1] += $harga;
                }
            }
            // Menambahkan total harga dari semua transaksi ke dalam data menu
            $menu[$keyMenu]['totalHarga'] += $totalSemua;
        }
    }

    // Menghitung total harga semua item
    $totalSemuaItem = 0;
    for ($key = 0; $key < count($menu); $key++) {
        $totalSemuaItem += $menu[$key]['totalHarga'];
    }

    // Fungsi untuk menghitung total vertikal
    function sumVertical($array, $column)
    {
        $sum = 0;
        for ($row = 0; $row < count($array); $row++) {
            $sum += $array[$row][$column];
        }
        return $sum;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        td,
        th {
            font-size: 11px;
        }
    </style>
    <title>TES - Venturo Camp Tahap 2</title>
</head>

<body>
    <div class="container-fluid">
        <div class="card" style="margin: 2rem 0rem;">
            <div class="card-header">
                Venturo - Laporan penjualan tahunan per menu
            </div>
            <div class="card-body">
                <!-- Mengirim data ke server menggunakan metode HTTP-->
                <form action="" method="get">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <select id="my-select" class="form-control" name="tahun">
                                    <option value="">Pilih Tahun</option>
                                    <?php
                                    $tahunOptions = ['2021', '2022']; // Daftar tahun yang tersedia
                                    foreach ($tahunOptions as $tahunOption) {
                                        $selected = (isset($_GET['tahun']) && $_GET['tahun'] == $tahunOption) ? 'selected' : '';
                                        echo '<option value="' . $tahunOption . '" ' . $selected . '>' . $tahunOption . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary">
                                Tampilkan
                            </button>
                            <a href="http://tes-web.landa.id/intermediate/menu" target="_blank" rel="Array Menu" class="btn btn-secondary">
                                Json Menu
                            </a>
                            <a href="http://tes-web.landa.id/intermediate/transaksi?tahun=2021" target="_blank" rel="Array Transaksi" class="btn btn-secondary">
                                Json Transaksi
                            </a>
                        </div>
                    </div>
                </form>
                <hr>
                <!-- Kondisi berikut untuk menampilkan tabel hanya jika tahun telah dipilih -->
                <?php if (isset($_GET['tahun']) && $_GET['tahun'] != "") : ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" style="margin: 0;">
                            <thead>
                                <tr class="table-dark">
                                    <th rowspan="2" style="text-align:center;vertical-align: middle;width: 250px;">Menu</th>
                                    <th colspan="12" style="text-align: center;">Periode Pada <?= $_GET['tahun'] ?></th>
                                    <th rowspan="2" style="text-align:center;vertical-align: middle;width:75px">Total</th>
                                </tr>
                                <tr class="table-dark">
                                    <?php
                                    // Menampilkan header bulan secara otomatis
                                    for ($bulan = 1; $bulan <= 12; $bulan++) {
                                        $namaBulan = date("M", strtotime($_GET['tahun'] . "-" . $bulan . "-01"));
                                        echo '<th style="text-align: center;width: 75px;">' . $namaBulan . '</th>';
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($_GET['tahun']) && $_GET['tahun'] != "") : ?>
                                    <!-- Kode untuk menampilkan total harga makanan perbulan -->
                                    <tr>
                                        <td class="table-secondary"><b>Makanan</b></td>
                                        <?php
                                        for ($total = 0; $total < count($totalHargaMakanan); $total++) {
                                            $totalFormatted = ($totalHargaMakanan[$total] != 0) ? ' ' . number_format($totalHargaMakanan[$total], 0, ',', '.') : '';
                                            echo '<td class="table-secondary" style="text-align: right;"><b>' . $totalFormatted . '</b></td>';
                                        }
                                        $totalMakananFormatted = array_sum($totalHargaMakanan);
                                        $totalMakananFormatted = ($totalMakananFormatted != 0) ? ' ' . number_format($totalMakananFormatted, 0, ',', '.') : '-';
                                        echo '<td class="table-secondary" style="text-align: right;"><b>' . $totalMakananFormatted . '</b></td>';
                                        ?>
                                    </tr>
                                    <!-- Kode untuk menampilkan data makanan -->
                                    <?php
                                    for ($key = 0; $key < count($menu); $key++) {
                                        if ($menu[$key]['kategori'] === "makanan") {
                                            echo '<tr>';
                                            echo '<td style="text-align: left;">' . $menu[$key]['menu'] . '</td>';
                                            // Kode untuk menampilkan nilai makanan per bulan
                                            for ($kunci = 0; $kunci < count($menu[$key]['value']); $kunci++) {
                                                $nilaiFormatted = ($menu[$key]['value'][$kunci] != 0) ? ' ' . number_format($menu[$key]['value'][$kunci], 0, ',', '.') : '';
                                                echo '<td style="text-align: right;">' . $nilaiFormatted . '</td>';
                                            }
                                            $totalHargaFormatted = ($menu[$key]['totalHarga'] != 0) ? ' ' . number_format($menu[$key]['totalHarga'], 0, ',', '.') : '';
                                            echo '<td style="text-align: right;"><b>' . $totalHargaFormatted . '</b></td>';
                                            echo '</tr>';
                                        }
                                    }
                                    ?>
                                    <!-- Kode untuk menampilkan total harga minuman perbulan -->
                                    <tr>
                                        <td class="table-secondary"><b>Minuman</b></td>
                                        <?php
                                        for ($total = 0; $total < count($totalHargaMinuman); $total++) {
                                            $totalFormatted = ($totalHargaMinuman[$total] != 0) ? ' ' . number_format($totalHargaMinuman[$total], 0, ',', '.') : '';
                                            echo '<td class="table-secondary" style="text-align: right;"><b>' . $totalFormatted . '</b></td>';
                                        }
                                        $totalMinumanFormatted = array_sum($totalHargaMinuman);
                                        $totalMinumanFormatted = ($totalMinumanFormatted != 0) ? ' ' . number_format($totalMinumanFormatted, 0, ',', '.') : '';
                                        echo '<td class="table-secondary" style="text-align: right;"><b>' . $totalMinumanFormatted . '</b></td>';
                                        ?>
                                    </tr>
                                    <!-- Kode untuk menampilkan data minuman -->
                                    <?php
                                    for ($key = 0; $key < count($menu); $key++) {
                                        if ($menu[$key]['kategori'] === "minuman") {
                                            echo '<tr>';
                                            echo '<td style="text-align: left;">' . $menu[$key]['menu'] . '</td>';
                                            // Kode untuk menampilkan nilai minuman per bulan
                                            for ($kunci = 0; $kunci < count($menu[$key]['value']); $kunci++) {
                                                $nilaiFormatted = ($menu[$key]['value'][$kunci] != 0) ? ' ' . number_format($menu[$key]['value'][$kunci], 0, ',', '.') : '';
                                                echo '<td style="text-align: right;">' . $nilaiFormatted . '</td>';
                                            }
                                            $totalHargaFormatted = ($menu[$key]['totalHarga'] != 0) ? ' ' . number_format($menu[$key]['totalHarga'], 0, ',', '.') : '';
                                            echo '<td style="text-align: right;"><b>' . $totalHargaFormatted . '</b></td>';
                                            echo '</tr>';
                                        }
                                    }
                                    ?>
                                    <tr>
                                    <tr>
                                        <td class="table-dark" colspan="1"><b>Total Harga</b></td>
                                        <?php
                                        $totalBulan = array_fill(0, 12, 0); // Inisialisasi array totalBulan
                                        for ($key = 0; $key < count($menu); $key++) {
                                            for ($i = 0; $i < 12; $i++) {
                                                $totalBulan[$i] += $menu[$key]['value'][$i];
                                            }
                                        }
                                        for ($index = 0; $index < count($totalBulan); $index++) {
                                            $totalFormatted = ($totalBulan[$index] != 0) ? ' ' . number_format($totalBulan[$index], 0, ',', '.') : ''; // Format total dengan koma
                                            echo '<td class="table-dark" style="text-align: right;"><b>' . $totalFormatted . '</b></td>';
                                            if ($index == 11) {
                                                $totalSumFormatted = ($totalSemuaItem != 0) ? ' ' . number_format($totalSemuaItem, 0, ',', '.') : '';
                                                echo '<td class="table-dark" style="text-align: right;"><b>' . $totalSumFormatted . '</b></td>';
                                            }
                                        }
                                        ?>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>
