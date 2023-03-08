<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- DataTables & Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <!-- end -->

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- end -->

    <!-- Icon -->
    <link rel="stylesheet" href="https://kit.fontawesome.com/3cf234e365.css" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/3cf234e365.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- end -->

    <link rel="stylesheet" href="style.css">
    <script>
    document.addEventListener("DOMContentLoaded", function(event) {

        const showNavbar = (toggleId, navId, bodyId, headerId) => {
            const toggle = document.getElementById(toggleId),
                nav = document.getElementById(navId),
                bodypd = document.getElementById(bodyId),
                headerpd = document.getElementById(headerId)

            if (toggle && nav && bodypd && headerpd) {
                toggle.addEventListener('click', () => {
                    toggle.classList.toggle('bx-x')
                    nav.classList.toggle('show2')
                    bodypd.classList.toggle('body-pd2')
                    headerpd.classList.toggle('body-pd')
                })
            }
        }

        showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header')

        const linkColor = document.querySelectorAll('.nav_link')

        function colorLink() {
            if (linkColor) {
                linkColor.forEach(l => l.classList.remove('active'))
                this.classList.add('active')
            }
        }
        linkColor.forEach(l => l.addEventListener('click', colorLink))

    });
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    </script>

    <?php 
        session_start(); 
        include "conn.php";
        if (isset($_SESSION["level"]) || isset($_SESSION["nama"])) {
            
        }else{
            echo '<script>alert("Anda Belum Login !!!"); window.location.href="login"</script>';
            exit;
        }

        if (!isset($_GET['p'])) {
            echo '<script> window.location.href="?m=halaman&p=home"</script>';
        } else {
            $page = $_GET['p'];
            $modul = $_GET['m'];
        }

        if (isset($_POST['logout'])) {
            session_start();
            session_unset();
            session_destroy();
            header('Location:login');
            exit;
        }
        if (isset($_POST['cetak'])) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attactment; filename=Laporan-Pembayaran-SPP.xls");
    
            if (!$result) {
                die("Connection failed: " . mysqli_connect_error());
            } else {

    
            }
        }
        
    ?>

<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="header_img">
            <?php if (isset($_SESSION["nama_petugas"])) { echo $_SESSION['nama_petugas'];
            } else { echo $_SESSION['nama']; } ?>
        </div>
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <a class="nav_logo">
                    <i class='bx bxs-graduation nav_logo-icon'></i>
                    <span class="nav_logo-name">SPP</span>
                </a>
                <?php 
                if (isset($_SESSION["level"])) { 
                ?>
                <!-- sidebar admin/petugas -->
                <div class="nav_list">
                    <a href="?m=halaman&p=home" class="togel nav_link <?php  if ($page == "home") { echo "active";}?>">
                        <i class='bx bx-home-alt nav_icon'></i>
                        <span class="nav_name">Home</span>
                    </a>
                    <?php
                    if (($_SESSION['level'] == "admin")){
                    ?>
                    <a href="?m=halaman&p=siswa" class="nav_link <?php  if ($page == "siswa") { echo "active";}?>">
                        <i class='bx bx-user nav_icon'></i>
                        <span class="nav_name">Siswa</span>
                    </a>
                    <a href="?m=halaman&p=petugas" class="nav_link <?php  if ($page == "petugas") { echo "active";}?>">
                        <i class='bx bxs-user-account nav_icon'></i>
                        <span class="nav_name">Petugas</span>
                    </a>
                    <a href="?m=halaman&p=kelas" class="nav_link <?php  if ($page == "kelas") { echo "active";}?>">
                        <i class='bx bxs-school nav_icon'></i>
                        <span class="nav_name">Kelas</span>
                    </a>
                    <a href="?m=halaman&p=spp" class="nav_link <?php  if ($page == "spp") { echo "active";}?>">
                        <i class='bx bxs-bank nav_icon'></i>
                        <span class="nav_name">SPP</span>
                    </a>

                    <?php } ?>
                    <a href="?m=halaman&p=pembayaran"
                        class="nav_link <?php  if ($page == "pembayaran" || $page == "histori-pembayaran") { echo "active";}?>">
                        <i class='bx bx-money nav_icon'></i>
                        <span class="nav_name">Pembayaran</span>
                    </a>
                    <?php
                    if (($_SESSION['level'] == "admin")){
                    ?>
                    <a href="?m=halaman&p=laporan" class="nav_link <?php  if ($page == "laporan") { echo "active";}?>">
                        <i class='bx bxs-report nav_icon'></i>
                        <span class="nav_name">Laporan</span>
                    </a>
                    <?php } ?>

                </div>
                <?php
                } else { 
                ?>
                <!-- sidebar siswa -->
                <div class="nav_list">
                    <a href="?m=halaman&p=home" class="togel nav_link <?php  if ($page == "home") { echo "active";}?>">
                        <i class='bx bx-home-alt nav_icon'></i>
                        <span class="nav_name">Home</span>
                    </a>
                    <a href="?m=halaman&p=histori-pembayaran"
                        class="nav_link <?php  if ($page == "histori-pembayaran") { echo "active";}?>">
                        <i class='bx bx-history nav_icon'></i>
                        <span class="nav_name">Histori Pembayaran</span>
                    </a>

                    </a>
                </div>
                <?php
                } 
                ?>

            </div>


            <form action="" method="post">

                <button type="submit" class="nav_link" name=" logout" style="background: none; border: none;">
                    <i class='bx bx-log-out nav_icon'></i>
                    <span class="nav_name">SignOut</span>
                </button>

            </form>
        </nav>
    </div>

    <!--Container Main start-->
    <div class="isi ">
        <?php

            include $modul . '/' . $page . ".php";
        
        ?>

    </div>
    <!--Container Main end-->



</body>