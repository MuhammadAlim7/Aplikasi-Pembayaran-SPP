<?php
    include "conn.php";
    if (isset($_SESSION["level"])) {

    }else{
        echo '<script>alert("Anda Belum Login !!!"); window.location.href="login"</script>';
        exit;
    }
    if (isset($_SESSION["nisn"])){
        echo '<script>window.location.href="index"</script>';
        exit;
    }
    
    if (isset($_POST['pembayaran'])) {

        $id_petugas = $_SESSION['id_petugas'];
        $nisn = $_POST['nisn'];
        $tgl_bayar = $_POST['tgl_bayar'];
        $bulan_bayar = $_POST['bulan_bayar'];
        $tahun_bayar = $_POST['tahun_bayar'];
        $id_spp = $_POST['id_spp'];
        $jumlah_bayar = $_POST['jumlah_bayar'];

 
        $sql = "INSERT INTO pembayaran(id_petugas,nisn,tgl_bayar,bulan_bayar,tahun_bayar,id_spp,jumlah_bayar) VALUES('$id_petugas','$nisn','$tgl_bayar','$bulan_bayar','$tahun_bayar','$id_spp','$jumlah_bayar')";


        $result = mysqli_query( $kon,$sql );

        if (!$result) {
            echo "
            <script>
                Toast.fire({
                    icon: 'error',
                    title: 'Gagal dibayar!!',
                });
                setTimeout(function(){location.href=''} , 3000);
            </script>";
        } else {
            echo "
            <script>
                Toast.fire({
                    icon: 'success',
                    title: 'Berhasil dibayar!!'
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
    <div class="card-header">Halaman Pembayaran</div>
    <div class="card-body">

        <table class="table table-bordered" id="myTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Tahun SPP</th>
                    <th>Nominal</th>
                    <th>Sudah Bayar</th>
                    <th>Belum Bayar</th>
                    <th>Status</th>
                    <th>History</th>
                </tr>
            </thead>

            <tbody>

                <?php
                $no = 1;
                $sql = "SELECT*FROM siswa,spp,kelas WHERE siswa.id_kelas=kelas.id_kelas AND siswa.id_spp=spp.id_spp ORDER BY nama ASC";
                $query = mysqli_query($kon, $sql);
                foreach($query as $row){
                    $data_pembayaran = mysqli_query($kon, "SELECT SUM(jumlah_bayar) as jumlah_bayar FROM pembayaran WHERE nisn='$row[nisn]'");
                    $data_pembayaran = mysqli_fetch_array($data_pembayaran);
                    $sudah_bayar = $data_pembayaran['jumlah_bayar'];
                    $kekurangan = $row['nominal']-$data_pembayaran['jumlah_bayar'];
                                
                ?>

                <tr>
                    <td width="5%"><?php echo $no++; ?></td>
                    <td><?= $row['nisn'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['nama_kelas'] ?></td>
                    <td><?= $row['tahun'] ?></td>
                    <td><?= number_format($row['nominal'],2,',','.'); ?></td>
                    <td><?= number_format($sudah_bayar,2,',','.'); ?></td>
                    <td><?= number_format($kekurangan,2,',','.'); ?></td>
                    <td width="13%" style="text-align:center;">
                        <?php
                            if($kekurangan==0){
                                echo"<span class='green badge '><i class='fa-solid fa-check'></i> Sudah Lunas </span>";
                            }else{ ?>
                        <button type="button" class="red btn btn-sm " data-bs-toggle="modal"
                            data-bs-target="#pilihbayar<?= $row['nisn'] ?>"><i class="fa-solid fa-pen-to-square"></i>
                            Pilih & Bayar</button>

                        <?php } ?>
                    </td>
                    <td style="text-align:center;">
                        <a href="?m=halaman&p=histori-pembayaran&nisn=<?= $row['nisn'] ?>"
                            class='blue btn btn-sm'>History</a>
                    </td>
                </tr>

                <!-- Modal Pembayaran -->
                <div class="modal fade" id="pilihbayar<?= $row['nisn'] ?>" tabindex="-1000"
                    aria-labelledby="exampleModalLabel1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel1">Edit Data</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form role="form" method="POST" action="">
                                    <div class="box-body px-3">
                                        <input name="id_spp" value="<?= $row['id_spp'] ?>" type="hidden"
                                            class="form-control" required>
                                        <div class="form-group mb-3">
                                            <label>Nama Petugas</label>
                                            <input value="<?= $_SESSION['nama_petugas'] ?>" disabled
                                                class="form-control" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>NISN</label>
                                            <input name="nisn" value="<?= $row['nisn'] ?>" readonly
                                                class="gelap form-control" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Nama Siswa</label>
                                            <input disabled value="<?= $row['nama'] ?>" type="text" class="form-control"
                                                required>
                                        </div>
                                        <div class="form-group row align-items-start mb-3">
                                            <div class="col">
                                                <label>Tanggal Bayar</label>
                                                <input type="date" name="tgl_bayar" value="<?= date('Y-m-d'); ?>"
                                                    class="form-control" required>
                                            </div>
                                            <div class="col">
                                                <label>Bulan Bayar</label>
                                                <?php
                                                    include 'conn.php';
                                                    $nisn= $row['nisn'];
                                                    $data_bulan=array();
                                                    $spp = mysqli_query($kon , "SELECT bulan_bayar FROM pembayaran where nisn=$nisn");
                                                    //echo "SELECT bulan_bayar FROM pembayaran where nisn=$nisn";
                                                    while ($row = mysqli_fetch_array($spp)) {
                                                        $data_bulan[]=$row['bulan_bayar'];
                                                    }
                                                    $bulan= array("Januari", "Februari", "Maret", "April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"); 
                                                    $result=array_diff($bulan,$data_bulan);
                                                    //print_r($result);
                                                    foreach ($result as $key2 ) {
                                                    // echo $key2;
                                                    }
                                                ?>
                                                <select name="bulan_bayar" class="form-select" required>
                                                    <?php foreach ($result as $key ) { ?>
                                                    <option value="<?= $key; ?>"><?php echo $key; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Tahun Bayar</label>
                                            <select name="tahun_bayar" class="form-control" required>
                                                <option value="<?= $row['tahun'] ?>"><?= $row['tahun'] ?></option>
                                                <?php
                                                    for($i=2020; $i<=date('Y'); $i++){
                                                        echo "<option value='$i'>$i</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label class="mb-1">Jumlah yang harus di bayar adalah
                                                <b><?= number_format($kekurangan,2,',','.')?></b></label>
                                            <div class="row g-1">
                                                <div class="col-auto">
                                                    <label for=""
                                                        style="border: none !important; padding-left:0px; padding-right:0px;"
                                                        class="form-control">Total
                                                        harga perbulan : </label>
                                                </div>
                                                <div class="col-auto">
                                                    <input type="number" value="100000" name="jumlah_bayar"
                                                        style="border: none !important; padding-left:0px; padding-right:0px;"
                                                        max="<?= $kekurangan; ?>" class="harga form-control fw-bold"
                                                        required readonly>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="mb-1">
                                            <button type="submit" class="blue btn btn-sm " name="pembayaran"
                                                title="Simpan Data">
                                                Simpan</button>
                                            <button type="button" class="green btn btn-sm" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                Kembali</a>
                                        </div>
                                    </div>


                                </form>
                            </div>
                            <div class="modal-footer"></div>
                            <?php } ?>

                        </div>
                    </div>
                </div>


            </tbody>
        </table>
    </div>
    <div class="card-footer"></div>
</div>