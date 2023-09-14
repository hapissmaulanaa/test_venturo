<!DOCTYPE html>
<html>
<head>
    <title>Venturo - Test</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js">
    </script>
</head>
<body>
    <div class="container">
    <div class="card my-2">
        <div>
    <h1 class="my-auto">Venturo - Laporan penjualan tahunan per menu</h1>
        </div>
    </div>
    <label for="year-filter">Filter Tahun:</label>
    <select id="year-filter" class="form-select mx-2 my-3" style="width: 200px;">
        <?php
        $endYear = 2022;
        echo '<option value="Pilih Tahun" disabled >Pilih Tahun</option>';
        for ($year = 2021; $year <= $endYear; $year++) {
            echo '<option value="' . $year . '">' . $year . '</option>';
        }
        ?>
    </select>
    
    <table id="menuTable" class="display">
        <thead>
            <tr>
                <th>Menu</th>
                <th>Jan</th>
                <th>Feb</th>
                <th>Mar</th>
                <th>Apr</th>
                <th>Mei</th>
                <th>Jun</th>
                <th>Jul</th>
                <th>Agu</th>
                <th>Sep</th>
                <th>Okt</th>
                <th>Nov</th>
                <th>Des</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            var menuData = [
                {"menu":"Nasi Goreng","kategori":"makanan"},
                {"menu":"Mie Freno","kategori":"makanan"},
                {"menu":"Nasi Teriyaki","kategori":"makanan"},
                {"menu":"Nasi Ayam Katsu","kategori":"makanan"},
                {"menu":"Nasi Goreng Mawut","kategori":"makanan"},
                {"menu":"Teh Hijau","kategori":"minuman"},
                {"menu":"Teh Lemon","kategori":"minuman"},
                {"menu":"Teh","kategori":"minuman"},
                {"menu":"Kopi Hitam","kategori":"minuman"},
                {"menu":"Kopi Susu","kategori":"minuman"}
            ];

            var transaksiData =  [
                {"tanggal":"2021-01-01","menu":"Nasi Goreng","total":50000},{"tanggal":"2021-01-01","menu":"Teh Lemon","total":15000},{"tanggal":"2021-01-01","menu":"Teh Hijau","total":20000},{"tanggal":"2021-01-01","menu":"Mie Freno","total":10000},{"tanggal":"2021-01-01","menu":"Nasi Ayam Katsu","total":10000},{"tanggal":"2021-01-01","menu":"Teh","total":3000},{"tanggal":"2021-01-01","menu":"Mie Freno","total":30000},{"tanggal":"2021-01-01","menu":"Kopi Susu","total":3000},{"tanggal":"2021-01-01","menu":"Kopi Hitam","total":12000},{"tanggal":"2021-01-01","menu":"Nasi Goreng Mawut","total":26000},{"tanggal":"2021-01-15","menu":"Nasi Goreng","total":10000},{"tanggal":"2021-01-15","menu":"Teh Lemon","total":5000},{"tanggal":"2021-01-15","menu":"Teh Hijau","total":40000},{"tanggal":"2021-01-15","menu":"Teh","total":3000},{"tanggal":"2021-01-15","menu":"Nasi Ayam Katsu","total":40000},{"tanggal":"2021-01-15","menu":"Nasi Goreng","total":30000},{"tanggal":"2021-01-15","menu":"Kopi Susu","total":9000},{"tanggal":"2021-01-15","menu":"Nasi Goreng Mawut","total":13000},{"tanggal":"2021-01-15","menu":"Nasi Teriyaki","total":13000},{"tanggal":"2021-01-15","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-01-31","menu":"Nasi Ayam Katsu","total":20000},{"tanggal":"2021-01-31","menu":"Teh Lemon","total":15000},{"tanggal":"2021-01-31","menu":"Nasi Goreng Mawut","total":13000},{"tanggal":"2021-01-31","menu":"Teh Lemon","total":15000},{"tanggal":"2021-01-31","menu":"Nasi Goreng","total":30000},{"tanggal":"2021-01-31","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-01-31","menu":"Kopi Susu","total":18000},{"tanggal":"2021-01-31","menu":"Nasi Goreng","total":10000},{"tanggal":"2021-02-01","menu":"Nasi Goreng","total":10000},{"tanggal":"2021-02-01","menu":"Teh","total":30000},{"tanggal":"2021-02-01","menu":"Nasi Teriyaki","total":13000},{"tanggal":"2021-02-01","menu":"Mie Freno","total":20000},{"tanggal":"2021-02-01","menu":"Kopi Susu","total":21000},{"tanggal":"2021-02-01","menu":"Nasi Goreng","total":100000},{"tanggal":"2021-02-01","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-02-01","menu":"Teh Lemon","total":5000},{"tanggal":"2021-02-01","menu":"Nasi Goreng Mawut","total":39000},{"tanggal":"2021-02-01","menu":"Teh Lemon","total":10000},{"tanggal":"2021-02-01","menu":"Teh","total":6000},{"tanggal":"2021-02-15","menu":"Teh Hijau","total":50000},{"tanggal":"2021-02-15","menu":"Mie Freno","total":40000},{"tanggal":"2021-02-15","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-02-15","menu":"Teh Lemon","total":5000},{"tanggal":"2021-02-15","menu":"Nasi Ayam Katsu","total":10000},{"tanggal":"2021-02-15","menu":"Kopi Susu","total":9000},{"tanggal":"2021-02-15","menu":"Nasi Teriyaki","total":26000},{"tanggal":"2021-02-15","menu":"Kopi Hitam","total":30000},{"tanggal":"2021-02-15","menu":"Nasi Goreng","total":10000},{"tanggal":"2021-02-15","menu":"Kopi Hitam","total":12000},{"tanggal":"2021-02-28","menu":"Kopi Susu","total":3000},{"tanggal":"2021-02-28","menu":"Teh Lemon","total":25000},{"tanggal":"2021-02-28","menu":"Nasi Teriyaki","total":26000},{"tanggal":"2021-02-28","menu":"Kopi Susu","total":9000},{"tanggal":"2021-02-28","menu":"Teh Hijau","total":20000},{"tanggal":"2021-02-28","menu":"Teh","total":12000},{"tanggal":"2021-02-28","menu":"Teh","total":3000},{"tanggal":"2021-02-28","menu":"Nasi Goreng","total":10000},{"tanggal":"2021-02-28","menu":"Teh Lemon","total":5000},{"tanggal":"2021-02-28","menu":"Nasi Goreng","total":40000},{"tanggal":"2021-03-01","menu":"Teh Lemon","total":10000},{"tanggal":"2021-03-01","menu":"Nasi Goreng","total":10000},{"tanggal":"2021-03-01","menu":"Teh","total":9000},{"tanggal":"2021-03-01","menu":"Nasi Goreng","total":10000},{"tanggal":"2021-03-01","menu":"Nasi Ayam Katsu","total":13000},{"tanggal":"2021-03-01","menu":"Nasi Ayam Katsu","total":10000},{"tanggal":"2021-03-01","menu":"Teh Hijau","total":40000},{"tanggal":"2021-03-01","menu":"Teh","total":3000},{"tanggal":"2021-03-01","menu":"Nasi Teriyaki","total":26000},{"tanggal":"2021-03-01","menu":"Mie Freno","total":10000},{"tanggal":"2021-03-15","menu":"Kopi Hitam","total":9000},{"tanggal":"2021-03-15","menu":"Nasi Goreng","total":20000},{"tanggal":"2021-03-15","menu":"Teh","total":3000},{"tanggal":"2021-03-15","menu":"Nasi Ayam Katsu","total":10000},{"tanggal":"2021-03-15","menu":"Nasi Teriyaki","total":13000},{"tanggal":"2021-03-31","menu":"Nasi Goreng","total":10000},{"tanggal":"2021-03-31","menu":"Mie Freno","total":40000},{"tanggal":"2021-03-31","menu":"Teh Hijau","total":50000},{"tanggal":"2021-03-31","menu":"Teh","total":3000},{"tanggal":"2021-03-31","menu":"Kopi Susu","total":9000},{"tanggal":"2021-03-31","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-03-31","menu":"Nasi Goreng Mawut","total":39000},{"tanggal":"2021-04-01","menu":"Nasi Goreng Mawut","total":13000},{"tanggal":"2021-04-01","menu":"Teh","total":3000},{"tanggal":"2021-04-01","menu":"Mie Freno","total":10000},{"tanggal":"2021-04-01","menu":"Nasi Teriyaki","total":13000},{"tanggal":"2021-04-01","menu":"Teh Hijau","total":10000},{"tanggal":"2021-04-01","menu":"Nasi Goreng","total":30000},{"tanggal":"2021-04-01","menu":"Teh Hijau","total":10000},{"tanggal":"2021-04-01","menu":"Mie Freno","total":10000},{"tanggal":"2021-04-01","menu":"Kopi Hitam","total":9000},{"tanggal":"2021-04-01","menu":"Nasi Goreng","total":20000},{"tanggal":"2021-04-01","menu":"Nasi Ayam Katsu","total":40000},{"tanggal":"2021-04-01","menu":"Kopi Susu","total":3000},{"tanggal":"2021-04-01","menu":"Nasi Ayam Katsu","total":30000},{"tanggal":"2021-04-15","menu":"Teh","total":9000},{"tanggal":"2021-04-15","menu":"Teh Lemon","total":5000},{"tanggal":"2021-04-15","menu":"Nasi Ayam Katsu","total":20000},{"tanggal":"2021-04-15","menu":"Nasi Goreng","total":10000},{"tanggal":"2021-04-15","menu":"Teh","total":3000},{"tanggal":"2021-04-15","menu":"Kopi Susu","total":9000},{"tanggal":"2021-04-15","menu":"Kopi Hitam","total":12000},{"tanggal":"2021-04-15","menu":"Teh Hijau","total":50000},{"tanggal":"2021-04-15","menu":"Teh Hijau","total":20000},{"tanggal":"2021-04-15","menu":"Nasi Goreng","total":40000},{"tanggal":"2021-04-30","menu":"Teh","total":3000},{"tanggal":"2021-04-30","menu":"Mie Freno","total":50000},{"tanggal":"2021-04-30","menu":"Nasi Goreng Mawut","total":26000},{"tanggal":"2021-04-30","menu":"Teh Hijau","total":10000},{"tanggal":"2021-04-30","menu":"Teh Hijau","total":10000},{"tanggal":"2021-04-30","menu":"Teh Hijau","total":80000},{"tanggal":"2021-04-30","menu":"Kopi Hitam","total":12000},{"tanggal":"2021-04-30","menu":"Nasi Goreng Mawut","total":13000},{"tanggal":"2021-04-30","menu":"Kopi Hitam","total":9000},{"tanggal":"2021-04-30","menu":"Kopi Hitam","total":6000},{"tanggal":"2021-04-30","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-04-30","menu":"Teh","total":3000},{"tanggal":"2021-05-01","menu":"Nasi Ayam Katsu","total":10000},{"tanggal":"2021-05-01","menu":"Mie Freno","total":30000},{"tanggal":"2021-05-01","menu":"Teh","total":3000},{"tanggal":"2021-05-01","menu":"Nasi Teriyaki","total":13000},{"tanggal":"2021-05-01","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-05-01","menu":"Teh Lemon","total":10000},{"tanggal":"2021-05-15","menu":"Teh","total":3000},{"tanggal":"2021-05-15","menu":"Mie Freno","total":10000},{"tanggal":"2021-05-15","menu":"Nasi Goreng Mawut","total":13000},{"tanggal":"2021-05-15","menu":"Teh","total":3000},{"tanggal":"2021-05-15","menu":"Teh Lemon","total":25000},{"tanggal":"2021-05-15","menu":"Nasi Teriyaki","total":30000},{"tanggal":"2021-05-15","menu":"Kopi Susu","total":3000},{"tanggal":"2021-05-15","menu":"Nasi Goreng Mawut","total":13000},{"tanggal":"2021-05-15","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-05-15","menu":"Kopi Hitam","total":6000},{"tanggal":"2021-05-15","menu":"Kopi Susu","total":15000},{"tanggal":"2021-05-31","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-05-31","menu":"Teh Lemon","total":10000},{"tanggal":"2021-05-31","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-05-31","menu":"Teh Hijau","total":10000},{"tanggal":"2021-05-31","menu":"Kopi Susu","total":6000},{"tanggal":"2021-05-31","menu":"Teh","total":3000},{"tanggal":"2021-05-31","menu":"Nasi Goreng Mawut","total":26000},{"tanggal":"2021-05-31","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-06-01","menu":"Teh Lemon","total":50000},{"tanggal":"2021-06-01","menu":"Kopi Hitam","total":1000},{"tanggal":"2021-06-01","menu":"Nasi Teriyaki","total":13000},{"tanggal":"2021-06-01","menu":"Mie Freno","total":50000},{"tanggal":"2021-06-01","menu":"Teh Hijau","total":10000},{"tanggal":"2021-06-01","menu":"Kopi Susu","total":3000},{"tanggal":"2021-06-01","menu":"Nasi Goreng","total":5000},{"tanggal":"2021-06-01","menu":"Nasi Goreng Mawut","total":13000},{"tanggal":"2021-06-01","menu":"Teh","total":3000},{"tanggal":"2021-06-15","menu":"Teh Hijau","total":10000},{"tanggal":"2021-06-15","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-06-15","menu":"Teh","total":30000},{"tanggal":"2021-06-15","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-06-15","menu":"Teh","total":3000},{"tanggal":"2021-06-15","menu":"Nasi Goreng","total":10000},{"tanggal":"2021-06-15","menu":"Nasi Goreng","total":10000},{"tanggal":"2021-06-15","menu":"Mie Freno","total":10000},{"tanggal":"2021-06-15","menu":"Teh Hijau","total":100000},{"tanggal":"2021-06-30","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-06-30","menu":"Nasi Ayam Katsu","total":10000},{"tanggal":"2021-06-30","menu":"Kopi Susu","total":6000},{"tanggal":"2021-06-30","menu":"Nasi Goreng","total":40000},{"tanggal":"2021-06-30","menu":"Teh","total":3000},{"tanggal":"2021-06-30","menu":"Teh Hijau","total":10000},{"tanggal":"2021-06-30","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-06-30","menu":"Teh Hijau","total":20000},{"tanggal":"2021-06-30","menu":"Mie Freno","total":20000},{"tanggal":"2021-06-30","menu":"Nasi Goreng Mawut","total":13000},{"tanggal":"2021-06-30","menu":"Teh","total":9000},{"tanggal":"2021-07-01","menu":"Teh","total":3000},{"tanggal":"2021-07-01","menu":"Kopi Susu","total":6000},{"tanggal":"2021-07-01","menu":"Teh Hijau","total":20000},{"tanggal":"2021-07-01","menu":"Nasi Teriyaki","total":13000},{"tanggal":"2021-07-01","menu":"Nasi Goreng Mawut","total":13000},{"tanggal":"2021-07-01","menu":"Nasi Goreng","total":10000},{"tanggal":"2021-07-01","menu":"Teh","total":15000},{"tanggal":"2021-07-01","menu":"Nasi Goreng Mawut","total":39000},{"tanggal":"2021-07-01","menu":"Teh Hijau","total":20000},{"tanggal":"2021-07-01","menu":"Kopi Susu","total":6000},{"tanggal":"2021-07-01","menu":"Teh Lemon","total":25000},{"tanggal":"2021-07-01","menu":"Nasi Ayam Katsu","total":50000},{"tanggal":"2021-07-01","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-07-01","menu":"Teh Lemon","total":5000},{"tanggal":"2021-08-01","menu":"Nasi Goreng Mawut","total":78000},{"tanggal":"2021-08-01","menu":"Teh Hijau","total":10000},{"tanggal":"2021-08-01","menu":"Teh Lemon","total":10000},{"tanggal":"2021-08-01","menu":"Teh","total":18000},{"tanggal":"2021-08-01","menu":"Nasi Ayam Katsu","total":100000},{"tanggal":"2021-08-01","menu":"Nasi Ayam Katsu","total":30000},{"tanggal":"2021-08-01","menu":"Nasi Goreng Mawut","total":26000},{"tanggal":"2021-08-01","menu":"Nasi Goreng","total":10000},{"tanggal":"2021-08-01","menu":"Kopi Hitam","total":15000},{"tanggal":"2021-08-01","menu":"Teh","total":6000},{"tanggal":"2021-09-01","menu":"Kopi Susu","total":3000},{"tanggal":"2021-09-01","menu":"Teh","total":9000},{"tanggal":"2021-09-01","menu":"Nasi Goreng","total":10000},{"tanggal":"2021-09-01","menu":"Nasi Goreng","total":40000},{"tanggal":"2021-09-01","menu":"Nasi Ayam Katsu","total":10000},{"tanggal":"2021-09-01","menu":"Teh Hijau","total":10000},{"tanggal":"2021-09-01","menu":"Nasi Goreng Mawut","total":13000},{"tanggal":"2021-09-01","menu":"Teh Hijau","total":30000},{"tanggal":"2021-09-01","menu":"Nasi Ayam Katsu","total":10000},{"tanggal":"2021-09-01","menu":"Mie Freno","total":50000},{"tanggal":"2021-09-01","menu":"Mie Freno","total":10000},{"tanggal":"2021-09-01","menu":"Nasi Goreng Mawut","total":13000},{"tanggal":"2021-09-01","menu":"Kopi Hitam","total":21000},{"tanggal":"2021-10-01","menu":"Nasi Ayam Katsu","total":30000},{"tanggal":"2021-10-01","menu":"Nasi Teriyaki","total":26000},{"tanggal":"2021-10-01","menu":"Nasi Goreng Mawut","total":13000},{"tanggal":"2021-10-01","menu":"Teh Lemon","total":5000},{"tanggal":"2021-10-01","menu":"Nasi Ayam Katsu","total":10000},{"tanggal":"2021-10-01","menu":"Teh","total":3000},{"tanggal":"2021-10-01","menu":"Teh","total":6000},{"tanggal":"2021-10-01","menu":"Mie Freno","total":40000},{"tanggal":"2021-10-01","menu":"Nasi Goreng Mawut","total":26000},{"tanggal":"2021-10-01","menu":"Nasi Goreng","total":10000},{"tanggal":"2021-11-01","menu":"Nasi Ayam Katsu","total":20000},{"tanggal":"2021-11-01","menu":"Teh Lemon","total":25000},{"tanggal":"2021-11-01","menu":"Kopi Hitam","total":15000},{"tanggal":"2021-11-01","menu":"Teh","total":3000},{"tanggal":"2021-11-01","menu":"Nasi Goreng","total":40000},{"tanggal":"2021-11-01","menu":"Teh Hijau","total":10000},{"tanggal":"2021-11-01","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-11-01","menu":"Nasi Goreng Mawut","total":13000},{"tanggal":"2021-11-01","menu":"Teh Hijau","total":10000},{"tanggal":"2021-11-01","menu":"Kopi Susu","total":15000},{"tanggal":"2021-11-01","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-12-01","menu":"Nasi Goreng Mawut","total":13000},{"tanggal":"2021-12-01","menu":"Teh","total":3000},{"tanggal":"2021-12-01","menu":"Nasi Goreng","total":30000},{"tanggal":"2021-12-01","menu":"Teh Hijau","total":30000},{"tanggal":"2021-12-01","menu":"Nasi Goreng Mawut","total":13000},{"tanggal":"2021-12-01","menu":"Kopi Susu","total":15000},{"tanggal":"2021-12-01","menu":"Kopi Hitam","total":3000},{"tanggal":"2021-12-01","menu":"Nasi Ayam Katsu","total":10000},{"tanggal":"2021-12-01","menu":"Teh","total":3000},{"tanggal":"2021-12-01","menu":"Nasi Ayam Katsu","total":10000}, {"tanggal":"2022-01-01","menu":"Kopi Hitam","total":3000},{"tanggal":"2022-01-01","menu":"Nasi Teriyaki","total":13000},{"tanggal":"2022-01-01","menu":"Teh","total":12000},{"tanggal":"2022-01-01","menu":"Kopi Hitam","total":3000},{"tanggal":"2022-01-01","menu":"Kopi Hitam","total":3000},{"tanggal":"2022-01-01","menu":"Mie Freno","total":20000},{"tanggal":"2022-01-01","menu":"Nasi Goreng","total":30000},{"tanggal":"2022-01-01","menu":"Nasi Goreng Mawut","total":26000},{"tanggal":"2022-01-01","menu":"Nasi Teriyaki","total":13000},{"tanggal":"2022-01-01","menu":"Nasi Goreng","total":10000},{"tanggal":"2022-01-01","menu":"Nasi Teriyaki","total":39000},{"tanggal":"2022-01-01","menu":"Kopi Hitam","total":3000}
            ];

            function formatRupiah(number) {
            if (typeof number !== 'number') {
                throw new Error('Input harus berupa angka.');
            }
            
            const rupiah = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(number);
            
            return rupiah;
            }


            function populateTable(year) {
                $('#menuTable tbody').empty();
                var menuCategories = menuData.map(item => item.menu);
                var makananTotal = Array(12).fill(0);
                var minumanTotal = Array(12).fill(0);
                
                menuCategories.forEach(menu => {
                    // var row = '<tr><td>' + menu + '</td>';
                    // var makanan = menuData.find(item=>item.kategori==="makanan")
                    // var minuman = menuData.find(item=>item.kategori==="minuman")
                    var row = '<tr><td>' + menu +    '</td>';
                    for (var i = 1; i <= 12; i++) {
                        var total = 0;
                        transaksiData.forEach(transaksi => {
                            if (transaksi.menu === menu && transaksi.tanggal.startsWith(year + '-' + (i < 10 ? '0' : '') + i)) {
                                total += transaksi.total;
                            }
                        });
                        row += '<td>' + formatRupiah(total) + '</td>';

                        // Update category totals
                        if (menuData.find(item => item.menu === menu && item.kategori === "makanan")) {
                            makananTotal[i - 1] += total;
                        } else {
                            minumanTotal[i - 1] += total;
                        }
                    }
                    row += '</tr>';
                    $('#menuTable tbody').append(row);
                });

                // Add category total rows
                var makananTotalRow = '<tr class="bg-secondary"><td >Total Makanan</td>';
                var minumanTotalRow = '<tr class="bg-secondary"><td>Total Minuman</td>';
                var allTotalRow = '<tr class="bg-secondary"><td>Total Keseluruhan</td>';
                for (var i = 0; i < 12; i++) {
                    var allTotal= Number(minumanTotal[i])+Number(makananTotal[i]);
                    makananTotalRow += '<td>' + formatRupiah(makananTotal[i]) + '</td>';
                    minumanTotalRow += '<td>' + formatRupiah(minumanTotal[i]) + '</td>';
                    allTotalRow += '<td>' + formatRupiah(allTotal) + '</td>';
                }
                makananTotalRow += '</tr>';
                minumanTotalRow += '</tr>';
                allTotalRow += '</tr>';
                $('#menuTable tbody').append(makananTotalRow);
                $('#menuTable tbody').append(minumanTotalRow);
                $('#menuTable tbody').append(allTotalRow);
            }

            $('#year-filter').change(function() {
                var selectedYear = $('#year-filter').val();
                populateTable(selectedYear);
            });

            var currentYear = new Date().getFullYear();
            $('#year-filter').val(currentYear);
            populateTable(currentYear);

            $('#menuTable').DataTable();
        });
    </script>
    </div>
</body>
</html>