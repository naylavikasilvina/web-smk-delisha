<?php
    session_start();

    include '../koneksi.php'; 

    // ================================
    // Cek login
    // ================================
    if(!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true){
        header("Location: ../login.php?msg=Harap Login Terlebih Dahulu!");
        exit();
    }
    $stmt = $pdo->query("SELECT * FROM pengaturan ORDER BY id DESC LIMIT 1");
    $d = $stmt->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html> 
<html>
<head>
    <title>Panel Admin - <?=$d->nama ?></title>
    <link rel="icon" type="image/png" href="../uploads/identitas/<?= $d->logo ?>" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <!-- Google Font Quicksand -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom Login Style -->
    <link rel="stylesheet" href="../css/style-login.css">

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
        }
    </style>
</head>

<body>
<!-- ========================= NAVBAR ========================= -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">

        <!-- LOGO -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="dashboard.php" style="display:flex; align-items:center; gap:8px; font-weight:700;">
                <?php if ($d) : ?>
                <?php if (!empty($d->logo)) : ?>
                    <img src="../uploads/identitas/<?= htmlspecialchars($d->logo) ?>?v=<?= time(); ?>"class="logo-img">
                <?php endif; ?>
                <span style="margin-left:8px;"><?= htmlspecialchars($d->nama) ?></span>
                <?php endif; ?>
            </a>
        </div>

        <!-- MENU -->
        <div class="collapse navbar-collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <!-- MENU ADMIN -->
                <?php if ($_SESSION['ulevel'] == 'Super Admin') : ?>
                    <li><a href="dashboard.php">🏫Dashboard</a></li>

                <!-- MENU GURU -->
                <?php elseif ($_SESSION['ulevel'] == 'Admin') : ?>
                    <li><a href="dashboard.php">🏫Dashboard</a></li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown"> ⚙️Pengaturan</a>
                        <ul class="dropdown-menu">
                            <li><a href="identitassekolah.php">Identitas Sekolah</a></li>
                            <li><a href="tentangsekolah.php">Tentang Sekolah</a></li>
                            <li><a href="kepalasekolah.php">Kepala Sekolah</a></li>
                            <li><a href="pesanmasuk.php">Pesan Masuk</a></li>


                        </ul>
                    </li>
                <?php endif; ?>
            </ul>

            <!-- MENU USER (KANAN) -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        👤 <?= htmlspecialchars($_SESSION['unama']) ?> (<?= htmlspecialchars($_SESSION['ulevel']) ?>)
                        <b class="caret"></b>
                    </a>
                    
                    <ul class="dropdown-menu">
                        <li><a href="ubahpassword.php">🗝️Ubah Password</a></li>
                        <li><a href="logout.php">🔐Logout</a></li>
                        <li><a href="../index.php">🏫Halaman Utama</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
</body>
</html>
