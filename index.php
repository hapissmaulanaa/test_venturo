<?php
if (isset($_GET['tahun']) && $_GET['tahun'] != "") {
    $menu = json_decode(file_get_contents("http://tes-web.landa.id/intermediate/menu"), true);
    $transaksi = json_decode(file_get_contents("http://tes-web.landa.id/intermediate/transaksi?tahun=" . $_GET['tahun']), true);
    $values = array();
    for ($i = 1; $i <= 12; $i++) {
        $values[] = 0;
    }
    foreach ($menu as $key => $value) {
        $menu[$key]['value'] = $values;
        $menu[$key]['totalHarga'] = 0;
    }

    // Variabel total harga makanan dan minuman
    $totalHargaMakanan = array_fill(0, 12, 0);
    $totalHargaMinuman = array_fill(0, 12, 0);

    foreach ($transaksi as $key => $valueTrans) {
        $harga = $valueTrans['total'];
        $dateFormat = DateTime::createFromFormat("Y-m-d", $valueTrans['tanggal']);
        $bulan = $dateFormat->format("n");

        foreach ($menu as $keyMenu => $valueMenu) {
            $totalSemua = 0;
            if ($valueMenu['menu'] === $valueTrans['menu']) {
                $menu[$keyMenu]['value'][$bulan - 1] += $harga;
                $totalSemua += $harga;

                // Pisahkan perhitungan total harga makanan dan minuman
                if ($valueMenu['kategori'] === "makanan") {
                    $totalHargaMakanan[$bulan - 1] += $harga;
                } elseif ($valueMenu['kategori'] === "minuman") {
                    $totalHargaMinuman[$bulan - 1] += $harga;
                }
            }
            $menu[$keyMenu]['totalHarga'] += $totalSemua;
        }
    }

    $totalSemuaItem = 0;
    foreach ($menu as $key => $value) {
        $totalSemuaItem += $menu[$key]['totalHarga'];
    }

    function sumVertical($array, $column)
    {
        $sum = 0;
        foreach ($array as $row) {
            $sum += $row[$column];
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
                                    <th style="text-align: center;width: 75px;">Jan</th>
                                    <th style="text-align: center;width: 75px;">Feb</th>
                                    <th style="text-align: center;width: 75px;">Mar</th>
                                    <th style="text-align: center;width: 75px;">Apr</th>
                                    <th style="text-align: center;width: 75px;">Mei</th>
                                    <th style="text-align: center;width: 75px;">Jun</th>
                                    <th style="text-align: center;width: 75px;">Jul</th>
                                    <th style="text-align: center;width: 75px;">Ags</th>
                                    <th style="text-align: center;width: 75px;">Sep</th>
                                    <th style="text-align: center;width: 75px;">Okt</th>
                                    <th style="text-align: center;width: 75px;">Nov</th>
                                    <th style="text-align: center;width: 75px;">Des</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($_GET['tahun']) && $_GET['tahun'] != "") : ?>
                                    <!-- Kode untuk menampilkan total harga makanan per bulan -->
                                    <tr>
                                        <td class="table-secondary"><b>Makanan</b></td>
                                        <?php
                                        foreach ($totalHargaMakanan as $total) {
                                            $totalFormatted = ($total != 0) ? '' . number_format($total, 0, ',', '.') : '-';
                                            echo '<td class="table-secondary" style="text-align: right;"><b>' . $totalFormatted . '</b></td>';
                                        }
                                        $totalMakananFormatted = array_sum($totalHargaMakanan);
                                        $totalMakananFormatted = ($totalMakananFormatted != 0) ? '' . number_format($totalMakananFormatted, 0, ',', '.') : '-';
                                        echo '<td class="table-secondary" style="text-align: right;"><b>' . $totalMakananFormatted . '</b></td>';
                                        ?>
                                    </tr>
                                    <!-- Kode untuk menampilkan data makanan -->
                                    <?php
                                    foreach ($menu as $key => $value) :
                                        if ($value['kategori'] === "makanan") :
                                    ?>
                                            <tr>
                                                <td style="text-align: left;"><?= $menu[$key]['menu'] ?></td>
                                                <!-- Kode untuk menampilkan nilai makanan per bulan -->
                                                <?php
                                                foreach ($value['value'] as $kunci => $nilai) :
                                                    $nilaiFormatted = ($nilai != 0) ? number_format($nilai) : ''; // Format nilai dengan koma ribuan
                                                ?>
                                                    <td style="text-align: right;"><?= $nilaiFormatted ?></td>
                                                <?php
                                                endforeach;
                                                $totalHargaFormatted = number_format($value['totalHarga']); // Format total harga dengan koma ribuan
                                                ?>
                                                <td style="text-align: right;"><b><?= $totalHargaFormatted ?></b></td>
                                            </tr>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>

                                    <!-- Kode untuk menampilkan data minuman -->
                                    <!-- Kode untuk menampilkan total harga minuman per bulan -->
                                    <tr>
                                        <td class="table-secondary"><b>Minuman</b></td>
                                        <?php
                                        foreach ($totalHargaMinuman as $total) {
                                            $totalFormatted = ($total != 0) ? '' . number_format($total, 0, ',', '.') : '-';
                                            echo '<td class="table-secondary" style="text-align: right;"><b>' . $totalFormatted . '</b></td>';
                                        }
                                        $totalMinumanFormatted = array_sum($totalHargaMinuman);
                                        $totalMinumanFormatted = ($totalMinumanFormatted != 0) ? '' . number_format($totalMinumanFormatted, 0, ',', '.') : '-';
                                        echo '<td class="table-secondary" style="text-align: right;"><b>' . $totalMinumanFormatted . '</b></td>';
                                        ?>
                                    </tr>
                                    <?php
                                    foreach ($menu as $key => $value) :
                                        if ($value['kategori'] === "minuman") :
                                    ?>
                                            <tr>
                                                <td style="text-align: left;"><?= $menu[$key]['menu'] ?></td>
                                                <?php
                                                foreach ($value['value'] as $kunci => $nilai) :
                                                    $nilaiFormatted = ($nilai != 0) ? number_format($nilai) : ''; // Format nilai dengan koma ribuan
                                                ?>
                                                    <td style="text-align: right;"><?= $nilaiFormatted ?></td>
                                                <?php
                                                endforeach;
                                                $totalHargaFormatted = number_format($value['totalHarga']); // Format total harga dengan koma ribuan
                                                ?>
                                                <td style="text-align: right;"><b><?= $totalHargaFormatted ?></b></td>
                                            </tr>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>
                                    <tr>
                                    <tr>
                                        <td class="table-dark" colspan="1"><b>Total Harga</b></td>
                                        <?php
                                        $totalBulan = array_fill(0, 12, 0); // Inisialisasi array totalBulan
                                        foreach ($menu as $key => $value) {
                                            for ($i = 0; $i < 12; $i++) {
                                                $totalBulan[$i] += $value['value'][$i];
                                            }
                                        }
                                        foreach ($totalBulan as $index => $total) {
                                            $totalFormatted = ($total != 0) ? number_format($total) : ''; // Format total dengan koma
                                            echo '<td class="table-dark" style="text-align: right;"><b>' . $totalFormatted . '</b></td>';
                                            if ($index == 11) {
                                                $totalSumFormatted = number_format(array_sum($totalBulan)); // Format total keseluruhan dengan koma
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
