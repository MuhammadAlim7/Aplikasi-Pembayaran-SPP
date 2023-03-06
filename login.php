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
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- end -->

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- end -->

    <!-- Icon -->
    <link rel="stylesheet" href="https://kit.fontawesome.com/3cf234e365.css" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/3cf234e365.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- end -->

    <style>
    @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");

    :root {
        --header-height: 3rem;
        --nav-width: 68px;
        --first-color: rgb(13, 110, 253);
        --first-color2: rgb(76, 120, 254);
        --first-color-light: rgb(175, 195, 255);
        --white-color: #ffffff;
        --body-font: "Nunito", sans-serif;
        --normal-font-size: 1rem;
        --z-fixed: 100;
    }



    body {
        background-image: url('img/home.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        font-family: "Nunito", sans-serif;
        font-size: var(--normal-font-size);
        transition: 0.5s;
    }


    .container {
        padding-top: 90px;
        transition: 0.5s;

    }

    .card:hover {
        transform: scale(1.025);
        transition: 0.35s;
    }

    .card,
    .btn,
    input,
    select {
        border: 0px !important;
        box-shadow: rgba(149, 157, 165, 0.15) 0px 8px 24px !important;
        background: rgb(245, 245, 245);
        text-align: center;
        transition: 0.35s;
    }

    .card-body {
        border-radius: 8px;
        background: white;
    }

    .card-header,
    .card-footer {
        text-transform: capitalize;
        border: 0px !important;
        background: rgb(245, 245, 245);
        color: var(--first-color);
        font-weight: 600;
    }



    input:focus {
        background-color: #F7F7F7 !important;
        transition: 0.35s;

    }

    .login:hover {
        background: var(--first-color);
        color: white;
        font-weight: 700;
        box-shadow:
            0 2.8px 2.2px rgba(13, 110, 253, 0.044),
            0 6.7px 5.3px rgba(13, 110, 253, 0.058),
            0 12.5px 10px rgba(13, 110, 253, 0.08) !important;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    </style>
    <title>Login</title>

</head>

<body>

    <div id="kode">
        <?php
        // Session
        session_start();
        if (isset($_SESSION["level"])) {
            echo '<script>alert("Anda telah melakukan login !!!"); window.location.href="index"</script>';
            exit;
        }

        if (!isset($_GET['p'])) {
            echo '<script> window.location.href="?m=halaman/login&p=petugas"</script>';
        } else {
            $page = $_GET['p'];
            $modul = $_GET['m'];
        }
        ?>
    </div>

    <section>
        <div class="container  d-flex justify-content-center">

            <div class="card text-center col-md-4">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link <?php  if ($page == "petugas") { echo "active";}?>" aria-current="true"
                                href="?m=halaman/login&p=petugas">Petugas</a>
                        </li>
                        <?php if ($page == "register" ) { 
                        echo '<li class="nav-item ">
                            <a class="nav-link active" href="?m=halaman/login&p=register">Register</a>
                        </li>';}?>
                        <li class="nav-item">
                            <a class="nav-link <?php  if ($page == "siswa") { echo "active";}?>"
                                href="?m=halaman/login&p=siswa">Siswa</a>
                        </li>


                    </ul>
                </div>
                <div class="card-body px-4 " id="isi">
                    <?php

                            include $modul . '/' . $page . ".php";
                        
                    ?>
                </div>
                <div class="card-footer text-muted">
                    <p></p>


                </div>
            </div>

        </div>

    </section>

</body>

</html>