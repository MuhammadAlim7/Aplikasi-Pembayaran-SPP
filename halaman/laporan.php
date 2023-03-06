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
    var table = $('#myTable').DataTable({
        "pageLength": 5,
        "lengthMenu": [
            [5, 10],
            [5, 10]
        ],
    });
});
</script>
<div class="card">
    <div class="card-header">Halaman Laporan </div>
    <div class="card-body">
        <div class="pb-3">

            <a href="cetak" class="blue btn btn-sm " name="cetak">
                Cetak Laporan
            </a>
        </div>





        <table class="table table-bordered" id="myTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Tahun SPP</th>
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
                    ORDER BY tgl_bayar DESC";
                    $query = mysqli_query($kon, $sql);
                    foreach($query as $row){
                        $data_pembayaran = mysqli_query($kon, "SELECT SUM(jumlah_bayar) as jumlah_bayar FROM pembayaran WHERE nisn='$row[nisn]'");
                        $data_pembayaran = mysqli_fetch_array($data_pembayaran);
                        $sudah_bayar = $data_pembayaran['jumlah_bayar'];
                        $kekurangan = $row['nominal']-$data_pembayaran['jumlah_bayar'];
                ?>

                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['nisn'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['nama_kelas'] ?></td>
                    <td><?= $row['tahun'] ?></td>
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
    <div class="card-footer"></div>
</div>