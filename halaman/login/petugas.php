<?php
include "conn.php";

if (isset($_POST['login'])) {

    $username = (htmlentities($_POST['username']));
    $password = ($_POST['password']);
    $check    = mysqli_query($kon, "SELECT * FROM petugas WHERE username = '$username' AND password = '$password'") or die("Connection failed: " . mysqli_connect_error());
    if (mysqli_num_rows($check) >= 1) {
        while ($row = mysqli_fetch_array($check)) {
            $_SESSION["id_petugas"]   = $row["id_petugas"];
            $_SESSION["username"]     = $row["username"];
            $_SESSION['password']     = $row['password'];
            $_SESSION["nama_petugas"] = $row["nama_petugas"];
            $_SESSION['level']        = $row['level'];
?>
<script>
Swal.fire({
    title: 'Selamat Datang!!',
    text: '<?php echo $row["nama_petugas"]?>',
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
                <input name="username" type="text" placeholder="Username" class="form-control " required>
            </div>
            <div class="form-group  col mb-4">
                <input name="password" id="password-field" type="password" placeholder="Password" class="form-control "
                    required>

            </div>
            <div class="form-group mb-5">
                <button type="submit" name="login" class="login form-control btn submit ">Login</button>
            </div>
        </form>

    </div>
</div>