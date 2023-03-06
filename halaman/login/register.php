    <?php include 'conn.php';

    // Session

    if (isset($_SESSION["level"])) {
        echo '<script>alert("Anda telah melakukan login !!!"); window.location.href="index"</script>';
        exit;
    }

    // Proses
    if (isset($_POST['register'])) {

        $username=$_POST['username'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        $nama_petugas=$_POST['nama_petugas'];
        $level=$_POST['level'];

        if ($password==$cpassword) {

            $sql="INSERT INTO petugas VALUES (NULL, '$username','$password','$nama_petugas',   '$level')";

            $result=mysqli_query($kon, $sql);

            if ($result) {
                echo "<script>alert('Selamat, Registrasi berhasil!');window.location.href='login';</script>";
                $username="";
                $_POST['password']="";
                $_POST['cpassword']="";
            }

            else {
                echo "<script>alert('Maaf, Registrasi gagal!');window.location.href='login';</script>";
            }
        }

        else {
            echo "<script>alert('Mohon masukan password dengan sesuai!')</script>";
        }
    }
?>
    <style>
.container {
    padding-top: 35px !important;
    transition: 0.5s;

}
    </style>
    <div class="mt-4 mb-5">
        <h4 class="mb-5">Registrasi</h4>
        <div>
            <form action="" method="post" class="signin-form  ">
                <div class="form-group col mb-3 "><input name="nama_petugas" type="text" placeholder="Nama"
                        class="form-control " required pattern="[a-zA-Z\s]{1,50}"
                        oninvalid="this.setCustomValidity('Masukan Nama lengkap dengan benar')"
                        oninput="setCustomValidity('')"
                        style="border:0px; box-shadow:0 2.8px 2.2px rgba(0, 0, 0, 0.034),0 6.7px 5.3px rgba(0, 0, 0, 0.048),0 12.5px 10px rgba(0, 0, 0, 0.06);">
                </div>
                <div class="form-group  col mb-3"><input name="username" type="text" placeholder="Username"
                        class="form-control " required pattern="[a-zA-Z\s]{1,50}"
                        oninvalid="this.setCustomValidity('Masukan Nama lengkap dengan benar')"
                        oninput="setCustomValidity('')"
                        style="border:0px; box-shadow:0 2.8px 2.2px rgba(0, 0, 0, 0.034),0 6.7px 5.3px rgba(0, 0, 0, 0.048),0 12.5px 10px rgba(0, 0, 0, 0.06);">
                </div>
                <div class="form-group  col mb-3"><input name="password" type="password" placeholder="Password"
                        class="form-control " required
                        oninvalid="this.setCustomValidity('Masukan Kata sandi dengan benar')"
                        oninput="setCustomValidity('')" min="10"
                        style="border:0px; box-shadow:0 2.8px 2.2px rgba(0, 0, 0, 0.034),0 6.7px 5.3px rgba(0, 0, 0, 0.048),0 12.5px 10px rgba(0, 0, 0, 0.06);">
                </div>
                <div class="form-group  col mb-3">
                    <input name="cpassword" type="password" placeholder="Konfirmasi Password" class="form-control "
                        required oninvalid="this.setCustomValidity('Masukan kata sandi dengan benar')"
                        oninput="setCustomValidity('')"
                        style="border:0px; box-shadow:0 2.8px 2.2px rgba(0, 0, 0, 0.034),0 6.7px 5.3px rgba(0, 0, 0, 0.048),0 12.5px 10px rgba(0, 0, 0, 0.06);">
                </div>
                <div class="form-group  col mb-3">
                    <div class="col"><select class="form-control" id="" name="level" placeholder="Masukan Role"
                            required>
                            <option value="">Level</option>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mb-5">
                    <button type="submit" name="register" class="form-control btn   submit ">Registrasi</button>
                </div>

            </form>

        </div>
    </div>

    </body>

    </html>