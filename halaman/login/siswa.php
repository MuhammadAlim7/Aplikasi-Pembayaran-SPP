<?php
include "conn.php";

if (isset($_POST['login'])) {

    $nisn = (htmlentities($_POST['nisn']));
    $nis  = ($_POST['nis']);
    $check    = mysqli_query($kon, "SELECT * FROM siswa WHERE nisn = '$nisn' AND nis = '$nis'") or die("Connection failed: " . mysqli_connect_error());
    if (mysqli_num_rows($check) >= 1) {
        while ($row = mysqli_fetch_array($check)) {
            $_SESSION["nisn"] = $row["nisn"];
            $_SESSION["nis"]  = $row["nis"];
            $_SESSION["nama"] = $row["nama"];
?>
<script>
Swal.fire({
    title: 'Selamat Datang!!',
    text: '<?php echo $row["nama"]?>',
    timer: 3000,
    showConfirmButton: false,
    icon: 'success',
    timerProgressBar: true
});
setTimeout(function() {
    location.href = 'index'
}, 3000);
</script>
<?php
        }
    } else {
        echo "
        <script>
        Swal.fire({
            title: 'Gagal!',
            text: 'Password atau Username salah!!',
            timer: 3000,
            icon: 'error',
            timerProgressBar: true
        });
        setTimeout(function(){location.href=''} , 3000);
        </script>";
    }
}
?>
<div class="mt-4 mb-5">
    <h4 class="mb-5">Login</h4>
    <div>
        <form action="" method="post" class="signin-form ">
            <div class="form-group col mb-4 ">
                <input name="nisn" type="number" placeholder="NISN" class="form-control " required>
            </div>
            <div class="form-group  col mb-4">
                <input name="nis" id="password-field" type="number" placeholder="NIS" class="form-control " required>

            </div>
            <div class="form-group mb-5">
                <button type="submit" name="login" class="login form-control btn submit ">login</button>
            </div>
        </form>

    </div>
</div>