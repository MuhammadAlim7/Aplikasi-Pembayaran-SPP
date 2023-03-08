<?php
    include "conn.php";
    if (isset($_SESSION["level"]) || isset($_SESSION["nisn"])) {
        
    }else{
        echo "
        <script>
        Swal.fire({
            title: 'Gagal!',
            text: 'Anda Belum Login!!',
            timer: 3000,
            icon: 'warning',
            timerProgressBar: true
        });
        setTimeout(function(){location.href='login'} , 3000);
        </script>";
    }

    if (isset($_POST['hapus'])) {
        
        $id_pembayaran = $_POST['id_pembayaran'];
        $sql = "DELETE FROM pembayaran WHERE pembayaran . id_pembayaran = '$id_pembayaran' ";

        $result = mysqli_query($kon, $sql);

        if (!$result) {
            echo "
            <script>
                Toast.fire({
                    icon: 'error',
                    title: 'Data gagal ditambahkan<br>periksa data yang dimasukan',
                });
                setTimeout(function(){location.href=''} , 3000);
            </script>";
        } else {
            echo "
            <script>
                Toast.fire({
                    icon: 'success',
                    title: 'Data berhasil ditambahkan'
                });
                setTimeout(function(){location.href=''} , 3000);
            </script>";
        }
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
    <?php
    if (isset($_SESSION["level"])) {
        $nisn = $_GET['nisn'];
    }else{
        $nisn = ($_SESSION["nisn"]);
    }
    $query = mysqli_query($kon, "SELECT nama,nama_kelas FROM siswa,kelas WHERE nisn=$nisn AND siswa.id_kelas=kelas.id_kelas");
    while ($banner_nama = mysqli_fetch_array($query)) {
        ?>
    <div class="card-header px-2">
        <a href="?m=halaman&p=pembayaran" class="px-2 " title="Kembali"><i class="fa-solid fa-angles-left"></i></a>
        Histori Pembayaran
        <?= $banner_nama['nama'] ?>
        <?= $banner_nama['nama_kelas'] ?>
    </div>

    <?php } ?>

    <div class="card-body">

        <table class="table table-bordered" id="myTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NISN</th>
                    <th>Tahun SPP</th>
                    <th>Bulan SPP</th>
                    <th>Nominal Dibayar</th>
                    <th>Sudah Dibayar</th>
                    <th>Kekurangan</th>
                    <th>Tanggal Dibayar</th>
                    <th>Petugas</th>
                    <?php if (isset($_SESSION["level"])) { ?>
                    <th>Hapus</th>
                    <?php } ?>

                </tr>
            </thead>
            <tbody>

                <?php
                if (isset($_SESSION["level"])) {
                    $nisn = $_GET['nisn'];
                }else{
                    $nisn = ($_SESSION["nisn"]);
                }
                include "conn.php";
                $no = 1;
                $sql = "SELECT * FROM pembayaran,siswa,kelas,spp,petugas 
                WHERE pembayaran.nisn=siswa.nisn 
                AND siswa.id_kelas=kelas.id_kelas 
                AND pembayaran.id_spp=spp.id_spp 
                AND pembayaran.id_petugas=petugas.id_petugas 
                AND pembayaran.nisn='$nisn' ORDER BY tgl_bayar DESC";
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
                    <td><?= $row['tahun'] ?></td>
                    <td><?= $row['bulan_bayar'] ?></td>
                    <td><?= number_format($row['nominal'],2,',','.'); ?></td>
                    <td><?= number_format($row['jumlah_bayar'],2,',','.'); ?></td>
                    <td><?= number_format($kekurangan,2,',','.'); ?></td>
                    <td><?= $row['tgl_bayar'] ?></td>
                    <td><?= $row['nama_petugas'] ?></td>
                    <?php if (isset($_SESSION["level"])) { ?>
                    <td width="" style="width: 1px; white-space: nowrap;">
                        <button type="button" class="red btn btn-sm " data-bs-toggle="modal"
                            data-bs-target="#hapus<?= $row['id_pembayaran'] ?>"><i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                    <?php } ?>
                </tr>





                <!-- modal hapus -->
                <div class="modal fade" id="hapus<?= $row['id_pembayaran'] ?>" tabindex="-1000"
                    aria-labelledby="exampleModalLabel1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title" id="exampleModalLabel1">Hapus Data?</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>

                            </div>
                            <div class="modal-body">
                                <form role="form" method="post" action="">
                                    <div class="box-body px-3">
                                        <div class="form-group ">
                                            <input type="hidden" name="id_pembayaran"
                                                value="<?= $row['id_pembayaran'] ?>" class="gelap form-control"
                                                required>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="">Jumlah Bayar</label>
                                            <input type="" name="jumlah_bayar"
                                                value="<?= number_format($row['jumlah_bayar'],2,',','.'); ?>"
                                                class="gelap form-control" required disabled>
                                        </div>
                                        <div class="mb-1">
                                            <button type="submit" class="red btn btn-sm" name="hapus"
                                                title="Simpan Data">
                                                Hapus</button>
                                            <a href="" class="green btn btn-sm" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                Kembali</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer"></div>

                        </div>
                    </div>
                </div>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer">

    </div>
</div>