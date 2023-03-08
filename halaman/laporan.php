<?php
    include "conn.php";
    if (isset($_SESSION["level"])) {
        
    }else{
        echo '<script>alert("Anda Belum Login !!!"); window.location.href="login"</script>';
        exit;
    }
    if (($_SESSION['level'] == "admin")){

    }else{
        echo '<script>window.location.href="index"</script>';
    }

?>
<script>
$(document).ready(function() {
    dataTable = $("#myTable").DataTable({
        "pageLength": 5,
        "lengthMenu": [
            [5, 100],
            [5, 100]
        ]

    });

    //tahun
    $('.status-dropdown').on('change', function(e) {
        var status = $(this).val();
        $('.status-dropdown').val(status)
        console.log(status)
        dataTable.column(4).search(status).draw();
    })
    //kelas
    $('.status-dropdown2').on('change', function(e) {
        var status = $(this).val();
        $('.status-dropdown2').val(status)
        console.log(status)
        dataTable.column(3).search(status).draw();
    })
});

function printData() {
    var divToPrint = document.getElementById("myTable");
    var newWin = window.open("");
    newWin.document.write('<html><head><title>Cetak Laporan</title>');
    newWin.document.write('<style>');
    newWin.document.write('table { border-collapse: collapse; width: 100%; }');
    newWin.document.write('th, td { text-align: left; padding: 8px; }');
    newWin.document.write('tr:nth-child(even) { background-color: #f2f2f2; }');
    newWin.document.write('th { background-color: #E5F0FF; color: white; }');
    newWin.document.write('</style>');
    newWin.document.write('</head><body>');
    newWin.document.write(divToPrint.outerHTML);
    newWin.document.write('</body></html>');
    newWin.print();
    newWin.close();
}
</script>


<div class="card">
    <div class="card-header">Halaman Laporan </div>
    <div class="card-body">
        <div class="pb-3">

            <a onclick="printData()" class="blue btn btn-sm " name="cetak">
                Cetak Laporan
            </a>
            <div class="btn-group submitter-group float-right">
                <select class="form-select form-select-sm status-dropdown">
                    <option value="">Tahun</option>
                    <?php
                            include 'conn.php';
                            $spp = mysqli_query($kon , "SELECT DISTINCT tahun FROM spp ORDER BY tahun ASC;");
                            foreach($spp as $data_spp){
                        ?>
                    <option value="<?= $data_spp['tahun'] ?>">
                        <?= $data_spp['tahun'];?>
                    </option>
                    <?php }?>
                </select>
            </div>
            <div class="btn-group submitter-group float-right">
                <select class="form-select form-select-sm status-dropdown2">
                    <option value="">Kelas</option>
                    <?php
                            include 'conn.php';
                            $kelas = mysqli_query($kon, "SELECT*FROM kelas ORDER BY nama_kelas ASC");
                            foreach($kelas as $data_kelas){
                        ?>
                    <option value="<?= $data_kelas['nama_kelas'] ?>">
                        <?= $data_kelas['nama_kelas'];?> </option>
                    <?php }?>
                </select>
            </div>
        </div>

        <div id="printableTable">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Tahun SPP</th>
                        <th>Bulan SPP</th>
                        <th>Nominal Dibayar</th>
                        <th>Sudah Dibayar</th>
                        <th>Kekurangan</th>
                        <th>Tanggal Dibayar</th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    include 'conn.php';
                    $no = 1;
                    $sql = "SELECT*FROM pembayaran,siswa,kelas,spp,petugas 
                    WHERE pembayaran.nisn=siswa.nisn 
                    AND siswa.id_kelas=kelas.id_kelas 
                    AND pembayaran.id_spp=spp.id_spp 
                    AND pembayaran.id_petugas=petugas.id_petugas 
                    ORDER BY tgl_bayar ASC";
                    $query = mysqli_query($kon, $sql);
                    foreach($query as $row){
                        $data_pembayaran = mysqli_query($kon, "SELECT SUM(jumlah_bayar) as jumlah_bayar FROM pembayaran WHERE nisn='$row[nisn]'");
                        $data_pembayaran = mysqli_fetch_array($data_pembayaran);
                        $sudah_bayar = $data_pembayaran['jumlah_bayar'];
                        $kekurangan = $row['nominal']-$sudah_bayar;
                ?>

                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nisn'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['nama_kelas'] ?></td>
                        <td><?= $row['tahun'] ?></td>
                        <td><?= $row['bulan_bayar'] ?></td>
                        <td><?= number_format($row['nominal'],2,',','.'); ?></td>
                        <td><?= number_format($row['jumlah_bayar'],2,',','.'); ?></td>
                        <td><?= number_format($kekurangan,2,',','.'); ?></td>
                        <td><?= $row['tgl_bayar'] ?></td>
                        <td><?= $row['nama_petugas'] ?></td>
                    </tr>


                    <?php } ?>

                </tbody>
            </table>
        </div>

    </div>
    <div class="card-footer"></div>

</div>