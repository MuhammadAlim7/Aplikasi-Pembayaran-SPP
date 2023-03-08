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
        $tahun = $_POST['tahun'];
        $nominal = $_POST['nominal'];

        $sql = "INSERT INTO spp VALUES (NULL, '$tahun', '$nominal')";

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

        $id_spp = $_POST['id_spp'];
        $tahun = $_POST['tahun'];
        $nominal = $_POST['nominal'];

        $sql = "UPDATE spp SET tahun='$tahun', nominal='$nominal' WHERE id_spp ='$id_spp'";

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

        $id_spp = $_POST['id_spp'];
        $tahun = $_POST['tahun'];
        $nominal = $_POST['nominal'];

        $sql = "DELETE FROM spp WHERE id_spp ='$id_spp'";

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
        ], // Pilihan jumlah data per halaman
    });
});
</script>

<div class="card">
    <div class="card-header">
        Halaman SPP
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
                    <th width="5%">No</th>
                    <th>Tahun</th>
                    <th>Nominal</th>
                    <th width="7.7%">Aksi</th>
                </tr>
            </thead>
            <tbody>

                <?php
                
                    include "conn.php";
                    $no = 1;
                    $query = mysqli_query($kon, "SELECT * FROM spp");
                    while ($row = mysqli_fetch_array($query)) {
                                
                ?>

                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['tahun']; ?></td>
                    <td><?php echo $row['nominal']; ?></td>
                    <td>
                        <button type="button" class="green btn btn-sm " data-bs-toggle="modal"
                            data-bs-target="#editin<?php echo $row['id_spp']; ?>"><i
                                class="fa-solid fa-pen-to-square"></i></button>
                        <button type button class="red btn btn-sm" data-bs-toggle="modal"
                            data-bs-target="#hapus<?php echo $row['id_spp']; ?>"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>


                <!-- Modal edit -->

                <div class="modal fade" id="editin<?php echo $row['id_spp']; ?>" tabindex="-1000"
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
                                        <input type="hidden" name="id_spp" value="<?php echo $row['id_spp']; ?>">

                                        <div class="mb-3">
                                            <label for="tahun">Tahun</label>
                                            <input type="text" name="tahun" class="form-control"
                                                value="<?php echo $row['tahun']; ?>" placeholder="Tahun" required>
                                        </div>
                                        <div class=" mb-4">
                                            <label for="nominal">Nominal</label>
                                            <input value="<?php echo $row['nominal']; ?>" type="number" name="nominal"
                                                class="form-control" placeholder="Nominal" required>
                                        </div>
                                        <div class="mb-1">
                                            <button type="submit" class="blue btn btn-sm" name="edit">
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

                <div class="modal fade" id="hapus<?php echo $row['id_spp']; ?>" tabindex="-1000"
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
                                        <input type="hidden" name="id_spp" value="<?php echo $row['id_spp']; ?>">

                                        <div class="mb-3">
                                            <label for="tahun">Tahun</label>
                                            <input type="text" name="tahun" class="form-control gelap"
                                                value="<?php echo $row['tahun']; ?>" placeholder="Tahun" required
                                                readonly>
                                        </div>
                                        <div class=" mb-4">
                                            <label for="nominal">Nominal</label>
                                            <input type="number" value="<?php echo $row['nominal']; ?>" name="nominal"
                                                class="form-control gelap" placeholder="Nominal" required readonly>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="red btn btn-sm" name="hapus">
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
                                <h1 class="modal-title" id="exampleModalLabel">Tambah Data</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form role="form" method="post" action="">
                                    <div class="box-body px-3">
                                        <input type="hidden" name="id_spp">

                                        <div class="mb-3">
                                            <label for="tahun">Tahun</label>
                                            <input type="text" name="tahun" class="form-control" placeholder="Tahun"
                                                required>
                                        </div>
                                        <div class=" mb-1">
                                            <label for="nominal">Nominal</label>
                                            <input type="number" name="nominal" class="form-control"
                                                placeholder="Nominal" required>
                                        </div>
                                        <div class="mb-1">
                                            <button type="submit" class="blue btn btn-sm " name="tambah">
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