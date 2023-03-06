<script>
function myFunction() {
    var x = document.getElementById("myInput");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>
<?php 
if (isset($_SESSION["level"]) || isset($_SESSION["nisn"])) {
        
}else{
    echo '<script>alert("Anda Belum Login !!!"); window.location.href="login"</script>';
    exit;
}
if (isset($_SESSION["level"])) {
?>
<!-- card admin/petugas -->
<div class="card">
    <div class="card-header">
        Selamat datang <?php echo $_SESSION['level'];?> <?php echo $_SESSION['nama_petugas']; ?>
    </div>
    <div class="card-body p-4">
        <div class="row ">
            <div class="col-auto ">
                <div class="px-4">
                    <img src="img/profile.jpg" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                        <h4><?php echo $_SESSION['nama_petugas']?></h4>
                        <p class="text-secondary mb-1"><?php echo $_SESSION['level'];?></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="py-3">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nama</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $_SESSION['nama_petugas']?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Username</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $_SESSION['username']?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Password <button onclick="myFunction()"
                                    style="background:none; border:none;"><i class="fa-regular fa-eye"></i></button>
                            </h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="password" value="<?php echo $_SESSION['password']?>" id="myInput" disabled
                                style="background:none; border:none; ">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">level</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $_SESSION['level']?>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="card-footer">

    </div>
</div>
<?php
} else { 
?>
<!-- card siswa -->
<div class="card">
    <div class="card-header">
        Selamat datang <?php echo $_SESSION['nama'];?>
    </div>
    <div class="card-body p-4">
        <div class="row ">
            <div class="col-auto ">
                <div class="px-4">
                    <img src="img/profile.jpg" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                        <h4><?php echo $_SESSION['nama']?></h4>
                        <p class="text-secondary mb-1">Siswa</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="py-3">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nama</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $_SESSION['nama']?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">NISN</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $_SESSION['nisn']?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">NIS</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $_SESSION['nis']?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">level</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            Siswa
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="card-footer">

    </div>
</div>
<?php
} ?>