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
        $namakls = $_POST['nama_kelas'];
        $kompetensi = $_POST['kompetensi_keahlian'];

        $sql = "INSERT INTO kelas VALUES (NULL, '$namakls', '$kompetensi')";

        $result = mysqli_query($kon, $sql);

        if (!$result) {
            echo "
            <script>
                Toast.fire({
                    icon: 'error',
                    title: 'Data gagal ditambhakan<br>periksa data yang dimasukan',
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

        $id_kelas = $_POST['id_kelas'];
        $namakls = $_POST['nama_kelas'];
        $kompetensi = $_POST['kompetensi_keahlian'];

        $sql = "UPDATE kelas SET nama_kelas='$namakls', kompetensi_keahlian='$kompetensi' WHERE id_kelas ='$id_kelas'";

        $result = mysqli_query($kon, $sql);

        if (!$result) {
            echo "
            <script>
                Toast.fire({
                    icon: 'error',
                    title: 'Data gagal diedit<br>periksa data yang dimasukan',
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

        $id_kelas = $_POST['id_kelas'];


        $sql = "DELETE FROM kelas WHERE id_kelas ='$id_kelas'";

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
    <div class="card-header">Halaman Kelas</div>
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
                    <th>Nama Kelas</th>
                    <th>Kompetensi Keahlian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

                <?php
                
                    include "conn.php";
                    $no = 1;
                    $query = mysqli_query($kon, "SELECT * FROM kelas");
                    while ($row = mysqli_fetch_array($query)) {
                                
                ?>

                <tr>
                    <td width="5%"><?php echo $no++; ?></td>
                    <td width=""><?php echo $row['nama_kelas']; ?></td>
                    <td width=""><?php echo $row['kompetensi_keahlian']; ?></td>
                    <td width="7.7%">
                        <button type="button" class="green btn btn-sm " data-bs-toggle="modal"
                            data-bs-target="#editin<?php echo $row['id_kelas']; ?>"><i
                                class="fa-solid fa-pen-to-square"></i></button>
                        <button type button class="red btn btn-sm" data-bs-toggle="modal"
                            data-bs-target="#hapus<?php echo $row['id_kelas']; ?>"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>


                <!-- Modal edit -->
                <div class="modal fade" id="editin<?php echo $row['id_kelas']; ?>" tabindex="-1000"
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
                                        <input type="hidden" name="id_kelas" value="<?php echo $row['id_kelas']; ?>">

                                        <div class="mb-3">
                                            <label for="tahun">Nama Kelas</label>
                                            <input type="text" name="nama_kelas" class="form-control"
                                                value="<?php echo $row['nama_kelas']; ?>" placeholder="Nama Kelas"
                                                required>
                                        </div>
                                        <div class=" mb-4">
                                            <label for="nominal">Kompetensi Keahlian</label>
                                            <input value="<?php echo $row['kompetensi_keahlian']; ?>" type="text"
                                                name="kompetensi_keahlian" class="form-control"
                                                placeholder="Kompetensi Keahlian" required>
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
                <div class="modal fade" id="hapus<?php echo $row['id_kelas']; ?>" tabindex="-1000"
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
                                        <input type="hidden" name="id_kelas" value="<?php echo $row['id_kelas']; ?>">

                                        <div class="mb-3">
                                            <label for="nama_kelas">Nama Kelas</label>
                                            <input type="text" name="nama_kelas" class="form-control gelap"
                                                value="<?php echo $row['nama_kelas']; ?>" placeholder="Nama Kelas"
                                                required readonly disabled>
                                        </div>
                                        <div class=" mb-4">
                                            <label for="kompetensi_keahlian">Kompetensi Keahlian</label>
                                            <input type="text" value="<?php echo $row['kompetensi_keahlian']; ?>"
                                                name="kompetensi_keahlian" class="form-control gelap"
                                                placeholder="kompetensi_keahlian" required readonly disabled>
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
                                        <input type="hidden" name="id_kelas">

                                        <div class="mb-3">
                                            <label for="nama_kelas">Nama Kelas</label>
                                            <input type="text" name="nama_kelas" class="form-control"
                                                placeholder="Nama Kelas" required>
                                        </div>
                                        <div class=" mb-4">
                                            <label for="kompetensi_keahlian">Kompetensi Keahlian</label>
                                            <input type="text" name="kompetensi_keahlian" class="form-control"
                                                placeholder="Kompetensi Keahlian" required>
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