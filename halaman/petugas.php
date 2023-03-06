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
        $username = $_POST['username'];
        $password = $_POST['password'];
        $nama_petugas = $_POST['nama_petugas'];
        $level = $_POST['level'];
        
        $sql = "INSERT INTO petugas(username,password,nama_petugas,level) VALUES('$username', '$password','$nama_petugas','$level')";

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

        $id_petugas = $_POST['id_petugas'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $nama_petugas = $_POST['nama_petugas'];
        $level = $_POST['level'];
        
        $sql = "UPDATE petugas SET username='$username', password='$password', nama_petugas='$nama_petugas', level='$level' WHERE id_petugas='$id_petugas'";

        $result = mysqli_query($kon, $sql);

        if (!$result) {
            echo "
            <script>
                Toast.fire({
                    icon: 'error',
                    title: 'Data gagal diedit<br>Data mungkin saja digunakan',
                });
                setTimeout(function(){location.href=''} , 3000);
            </script>";
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

        $id_petugas = $_POST['id_petugas'];
        

        $sql = "DELETE FROM petugas WHERE id_petugas='$id_petugas'";

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
        ],

    });
});
</script>
<div class="card">
    <div class="card-header">
        Halaman Petugas
    </div>
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
                    <th>Username</th>
                    <th>Password</th>
                    <th>Nama Petugas</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

                <?php
                
                    include "conn.php";
                    $no = 1;
                    $query = mysqli_query($kon, " SELECT * FROM petugas");
                    while ($row = mysqli_fetch_array($query)) {
                                
                ?>

                <tr>
                    <td width="5%"><?php echo $no++; ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['password'] ?></td>
                    <td><?= $row['nama_petugas'] ?></td>
                    <td><?= $row['level'] ?></td>
                    <td width="7.7%">
                        <button type="button" class="green btn btn-sm " data-bs-toggle="modal"
                            data-bs-target="#editin<?php echo $row['id_petugas']; ?>"><i
                                class="fa-solid fa-pen-to-square"></i></button>
                        <button type button class="red btn btn-sm" data-bs-toggle="modal"
                            data-bs-target="#hapus<?php echo $row['id_petugas']; ?>"><i
                                class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>


                <!-- Modal edit -->
                <div class="modal fade" id="editin<?php echo $row['id_petugas']; ?>" tabindex="-1000"
                    aria-labelledby="exampleModalLabel1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title " id="exampleModalLabel1">Edit Data</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form role="form" method="post" action="">
                                    <div class="box-body px-3">
                                        <input type="hidden" name="id_petugas"
                                            value="<?php echo $row['id_petugas']; ?>">

                                        <div class="mb-3">
                                            <label for="tahun">Username</label>
                                            <input type="text" name="username" class="form-control"
                                                value="<?php echo $row['username']; ?>" placeholder="Username" required>
                                        </div>
                                        <div class=" mb-3">
                                            <label for="nominal">Password</label>
                                            <input value="<?php echo $row['password']; ?>" type="text" name="password"
                                                class="form-control" placeholder="Password" required>
                                        </div>
                                        <div class=" mb-3">
                                            <label for="nominal">Nama Petugas</label>
                                            <input value="<?php echo $row['nama_petugas']; ?>" type="text"
                                                name="nama_petugas" class="form-control" placeholder="Nama Petugas"
                                                required>
                                        </div>
                                        <div class="mb-4"><label>Level</label>
                                            <select name="level" class="form-control" required>
                                                <option value="<?= $row['level'] ?>"><?= $row['level'] ?> </option>
                                                <option value="admin"> Admin</option>
                                                <option value="petugas"> Petugas</option>
                                            </select>
                                        </div>
                                        <div class="mb-1">
                                            <button type="submit" class="blue btn btn-sm" name="edit"
                                                title="Simpan Data">
                                                Simpan</button>
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
                <!-- Modal hapus -->
                <div class="modal fade" id="hapus<?php echo $row['id_petugas']; ?>" tabindex="-1000"
                    aria-labelledby="exampleModalLabel1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title " id="exampleModalLabel1">Hapus Data?</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>

                            </div>
                            <div class="modal-body">
                                <form role="form" method="post" action="">
                                    <div class="box-body px-3">
                                        <input type="hidden" name="id_petugas"
                                            value="<?php echo $row['id_petugas']; ?>">

                                        <div class="mb-3">
                                            <label for="tahun">Username</label>
                                            <input type="text" name="username" class="gelap form-control"
                                                value="<?php echo $row['username']; ?>" placeholder="Username" required
                                                readonly disabled>
                                        </div>
                                        <div class=" mb-3">
                                            <label for="nominal">Password</label>
                                            <input value="<?php echo $row['password']; ?>" type="text" name="password"
                                                class="gelap form-control" placeholder="Password" required readonly
                                                disabled>
                                        </div>
                                        <div class=" mb-3">
                                            <label for="nominal">Nama Petugas</label>
                                            <input value="<?php echo $row['nama_petugas']; ?>" type="text"
                                                name="nama_petugas" class="gelap form-control"
                                                placeholder="Nama Petugas" required readonly disabled>
                                        </div>
                                        <div class="mb-4"><label>Level</label>
                                            <select name="level" class="gelap form-control" required readonly disabled>
                                                <option value="<?= $row['level'] ?>"><?= $row['level'] ?> </option>
                                                <option value="admin"> Admin</option>
                                                <option value="petugas"> Petugas</option>
                                            </select>
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
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- Modal tambah -->
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

                                        <div class="mb-3">
                                            <label for="tahun">Username</label>
                                            <input type="text" name="username" class="form-control"
                                                placeholder="Username" required>
                                        </div>
                                        <div class=" mb-3">
                                            <label for="nominal">Password</label>
                                            <input type="text" name="password" class="form-control"
                                                placeholder="Password" required>
                                        </div>
                                        <div class=" mb-3">
                                            <label for="nominal">Nama Petugas</label>
                                            <input type="text" name="nama_petugas" class="form-control"
                                                placeholder="Nama Petugas" required>
                                        </div>
                                        <div class="mb-4"><label>Level</label>
                                            <select name="level" class="form-control" required>
                                                <option value="">Pilih Level</option>
                                                <option value="admin"> Admin</option>
                                                <option value="petugas"> Petugas</option>
                                            </select>
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