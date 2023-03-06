<!-- <?php
header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attactment; filename=Laporan-Pembayaran-SPP.xls");
?> -->
<meta charset="utf-8">
<meta http-equiv="Content-Type">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- DataTables & Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
<!-- end -->





<script>

</script>
<div class="card-body">
    <table class="table table-striped" id="myTable">
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