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
    if (isset($_POST['tambah'])) {

        $nisn = $_POST['nisn'];
        $nis = $_POST['nis'];
        $nama = $_POST['nama'];
        $id_kelas = $_POST['id_kelas'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];
        $id_spp = $_POST['id_spp'];
        $sql = "INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('$nisn','$nis','$nama','$id_kelas','$alamat','$no_telp','$id_spp')";
   

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
    if (isset($_POST['edit'])) {

        $nisn = $_POST['nisn'];
        $nis = $_POST['nis'];
        $nama = $_POST['nama'];
        $id_kelas = $_POST['id_kelas'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];
        $id_spp = $_POST['id_spp'];
        
        $sql = "UPDATE siswa SET nis = '$nis' , nama = '$nama' , id_kelas = '$id_kelas' , alamat = '$alamat' , no_telp = '$no_telp' , id_spp = '$id_spp' WHERE nisn = '$nisn'";



        $result = mysqli_query( $kon,$sql );
        if (!$result) {
            echo "
            <script>
                Toast.fire({
                    icon: 'error',
                    title: 'Data gagal diedit<br>Data mungkin saja digunakan',
                });
                setTimeout(function(){location.href=''} , 3000);
            </script>";
        echo "Kode error: ".mysqli_error($kon); 
        } else {
            echo "
            <script>
                Toast.fire({
                    icon: 'success',
                    title: 'Data berhasil diedit'
                });
                setTimeout(function(){location.href=''} , 3000);
            </script>";
        }

    }
    if (isset($_POST['hapus'])) {

        $nisn = $_POST['nisn'];

        $sql = "DELETE FROM siswa WHERE  nisn  = '$nisn'";

        $result = mysqli_query($kon, $sql);

        if (!$result) {
            echo "
                <script>
                    Toast.fire({
                        icon: 'error',
                        title: 'Data gagal dihapus<br>Data mungkin saja digunakan',
                    });
                    setTimeout(function(){location.href=''} , 3000);
                </script>";
        } else {
            echo "
            <script>
                Toast.fire({
                    icon: 'success',
                    title: 'Data berhasil dihapus'
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
        ]
    });
});
</script>

<div class="card">
    <div class="card-header">Halaman Siswa</div>
    <div class="card-body">
        <div class="pb-3">
            <button type="button" class="blue btn btn-sm " id="tambah" data-bs-toggle="modal"
                data-bs-target="#tambahin">
                <i class="fa-solid fa-plus"></i> Tambah Data</button>
        </div>
        <table class="table table-bordered" id="myTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NISN</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Alamat</th>
                    <th>No Telepon</th>
                    <th>SPP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

                <?php
                
                    include "conn.php";
                    $no = 1;
                    $query = mysqli_query($kon, "SELECT * FROM siswa, spp,kelas WHERE siswa.id_kelas=kelas.id_kelas AND siswa.id_spp=spp.id_spp ORDER BY nama ASC");
                    while ($row = mysqli_fetch_array($query)) {
                                
                ?>

                <tr>
                    <td width="5%"><?php echo $no++; ?></td>
                    <td><?= $row['nisn'] ?></td>
                    <td><?= $row['nis'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['nama_kelas'] ?></td>
                    <td><?= $row['alamat'] ?></td>
                    <td><?= $row['no_telp'] ?></td>
                    <td><?= $row['tahun'] ?> - <?= number_format($row['nominal'], 2, ',', '.'); ?></td>
                    <td width="7.7%">
                        <button type="button" class="green btn btn-sm " data-bs-toggle="modal"
                            data-bs-target="#editin<?php echo $row['nisn'] ?>"><i
                                class="fa-solid fa-pen-to-square"></i></button>
                        <button type button class="red btn btn-sm" data-bs-toggle="modal"
                            data-bs-target="#hapus<?php echo $row['nisn'] ?>"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>


                <!-- Modal edit -->
                <div class="modal fade" id="editin<?php echo $row['nisn'] ?>" tabindex="-1000"
                    aria-labelledby="exampleModalLabel1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title" id="exampleModalLabel1">Edit Data</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form role="form" method="POST" action="">
                                    <div class="box-body px-3">
                                        <div class="form-group row align-items-start mb-2">
                                            <div class="col">
                                                <label>NISN</label>
                                                <input type="text" name="nisn" value="<?php echo $row['nisn'] ?>"
                                                    readonly type="number" class="gelap form-control" placeholder="NISN"
                                                    required>
                                            </div>
                                            <div class="col">
                                                <label for="nis">NIS</label>
                                                <input type="text" name="nis" value="<?php echo $row['nis']; ?>"
                                                    class="form-control" placeholder="NIS" required>
                                            </div>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="nisn">Nama</label>
                                            <input type="text" name="nama" value="<?php echo $row['nama']; ?>"
                                                class="form-control" placeholder="Nama" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" name="alamat" value="<?php echo $row['alamat']; ?>"
                                                class="form-control" placeholder="Alamat" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="no_telp">No Telpon</label>
                                            <input type="text" name="no_telp" value="<?php echo $row['no_telp']; ?>"
                                                class="form-control" placeholder="No Telpon" required>
                                        </div>
                                        <div class="form-group row align-items-start mb-4">
                                            <div class="col">
                                                <label>SPP</label>
                                                <select name="id_spp" class="form-select" required>
                                                    <option value="<?= $row['id_spp'] ?>">
                                                        <?= $row['tahun'];?> -
                                                        <?= number_format($row['nominal'],2,',','.');?>
                                                    </option>
                                                    <?php
                                                    include 'conn.php';
                                                    $spp = mysqli_query($kon , "SELECT*FROM spp ORDER BY id_spp ASC");
                                                    foreach($spp as $data_spp){
                                                ?>
                                                    <option value="<?= $data_spp['id_spp'] ?>">
                                                        <?= $data_spp['tahun'];?> |
                                                        <?= number_format($data_spp['nominal'],2,',','.');?>
                                                    </option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label>Kelas</label>
                                                <select name="id_kelas" class="form-select" required>
                                                    <option value="<?= $row['id_kelas'] ?>"><?= $row['nama_kelas'] ?>
                                                    </option>
                                                    <?php
                                                        include 'conn.php';
                                                        $kelas = mysqli_query($kon, "SELECT*FROM kelas ORDER BY nama_kelas ASC");
                                                        foreach($kelas as $data_kelas){
                                                    ?>
                                                    <option value="<?= $data_kelas['id_kelas'] ?>">
                                                        <?= $data_kelas['nama_kelas'];?> </option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-1">
                                            <button type="submit" class="blue btn btn-sm " name="edit"
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

                        </div>
                    </div>
                </div>
                <!-- modal hapus -->
                <div class="modal fade" id="hapus<?php echo $row['nisn'] ?>" tabindex="-1000"
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
                                        <div class="form-group row align-items-start mb-2">
                                            <div class="col">
                                                <label>NISN</label>
                                                <input type="text" name="nisn" value="<?php echo $row['nisn'] ?>"
                                                    readonly type="number" class="gelap form-control" placeholder="NISN"
                                                    required>
                                            </div>
                                            <div class="col">
                                                <label for="nis">NIS</label>
                                                <input type="text" name="nis" value="<?php echo $row['nis']; ?>"
                                                    readonly disabled class="form-control" placeholder="NIS" required>
                                            </div>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="nisn">Nama</label>
                                            <input type="text" name="nama" value="<?php echo $row['nama']; ?>" readonly
                                                disabled class="form-control" placeholder="Nama" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" name="alamat" value="<?php echo $row['alamat']; ?>"
                                                readonly disabled class="form-control" placeholder="Alamat" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="no_telp">No Telpon</label>
                                            <input type="text" name="no_telp" value="<?php echo $row['no_telp']; ?>"
                                                readonly disabled class="form-control" placeholder="No Telpon" required>
                                        </div>
                                        <div class="form-group row align-items-start mb-4">
                                            <div class="col">
                                                <label>SPP</label>
                                                <select name="id_spp" class="form-select" required readonly disabled>
                                                    <option value="<?= $row['id_spp'] ?>">
                                                        <?= $row['tahun'];?> -
                                                        <?= number_format($row['nominal'],2,',','.');?>
                                                    </option>
                                                    <?php
                                                    include 'conn.php';
                                                    $spp = mysqli_query($kon , "SELECT*FROM spp ORDER BY id_spp ASC");
                                                    foreach($spp as $data_spp){
                                                ?>
                                                    <option value="<?= $data_spp['id_spp'] ?>">
                                                        <?= $data_spp['tahun'];?> |
                                                        <?= number_format($data_spp['nominal'],2,',','.');?>
                                                    </option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label>Kelas</label>
                                                <select name="id_kelas" class="form-select" required readonly disabled>
                                                    <option value="<?= $row['id_kelas'] ?>"><?= $row['nama_kelas'] ?>
                                                    </option>
                                                    <?php
                                                        include 'conn.php';
                                                        $kelas = mysqli_query($kon, "SELECT*FROM kelas ORDER BY nama_kelas ASC");
                                                        foreach($kelas as $data_kelas){
                                                    ?>
                                                    <option value="<?= $data_kelas['id_kelas'] ?>">
                                                        <?= $data_kelas['nama_kelas'];?> </option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-1">
                                            <button type="submit" class="red btn btn-sm" name="hapus"
                                                title="Hapus Data">
                                                Hapus</button>
                                            <a href="" class="green btn btn-sm" data-bs-dismiss="modal"
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
                <!-- modal tambah -->
                <div class="modal fade" id="tambahin" tabindex="-1000" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title " id="exampleModalLabel">Tambah Data</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form role="form" method="post" action="">
                                    <div class="box-body px-3">
                                        <div class="form-group row align-items-start mb-2">
                                            <div class="col">
                                                <label>NISN</label>
                                                <input type="text" name="nisn" type="number" class=" form-control"
                                                    placeholder="NISN" required>
                                            </div>
                                            <div class="col">
                                                <label for="nis">NIS</label>
                                                <input type="text" name="nis" class="form-control" placeholder="NIS"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="nisn">Nama</label>
                                            <input type="text" name="nama" class="form-control" placeholder="Nama"
                                                required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" name="alamat" class="form-control" placeholder="Alamat"
                                                required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="no_telp">No Telpon</label>
                                            <input type="text" name="no_telp" class="form-control"
                                                placeholder="No Telpon" required>
                                        </div>
                                        <div class="form-group row align-items-start mb-4">
                                            <div class="col">
                                                <label>SPP</label>
                                                <select name="id_spp" class="form-select" required>
                                                    <option value="">Pilih SPP</option>
                                                    <?php
                                                    include 'conn.php';
                                                    $spp = mysqli_query($kon , "SELECT*FROM spp ORDER BY id_spp ASC");
                                                    foreach($spp as $data_spp){
                                                ?>
                                                    <option value="<?= $data_spp['id_spp'] ?>">
                                                        <?= $data_spp['tahun'];?> |
                                                        <?= number_format($data_spp['nominal'],2,',','.');?>
                                                    </option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label>Kelas</label>
                                                <select name="id_kelas" class="form-select" required>
                                                    <option value="">Pilih Kelas</option>
                                                    <?php
                                                        include 'conn.php';
                                                        $kelas = mysqli_query($kon, "SELECT*FROM kelas ORDER BY nama_kelas ASC");
                                                        foreach($kelas as $data_kelas){
                                                    ?>
                                                    <option value="<?= $data_kelas['id_kelas'] ?>">
                                                        <?= $data_kelas['nama_kelas'];?> </option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-1">
                                            <button type="submit" class="blue btn btn-sm " name="tambah"
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


                        </div>
                    </div>
                </div>

            </tbody>
        </table>
    </div>
    <div class="card-footer"></div>
</div>