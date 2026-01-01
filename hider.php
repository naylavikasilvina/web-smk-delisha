<?php
require_once "koneksi.php";

try {
    $stmt = $pdo->query("SELECT * FROM pengaturan ORDER BY id DESC LIMIT 1");
    $d = $stmt->fetch(PDO::FETCH_OBJ);   // <-- WAJIB OBJECT
} catch(PDOException $e){
    $d = null;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>
        <?= $d ? "Web " . htmlspecialchars($d->nama) : "Website Sekolah"; ?>
    </title>

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <!-- FAVICON -->
    <?php if($d && !empty($d->favicon)): ?>
    <link rel="icon" type="image/png" href="uploads/identitas/<?= htmlspecialchars($d->favicon) ?>?v=<?= time(); ?>">
    <?php endif; ?>


<style>
/* ================= NAVBAR ================= */
.navbar{
    background:#0058ab !important;
    padding-top:6px;
    padding-bottom:0px;
}

/* LOGO */
.logo-img{
    height:45px;
    width:auto;
    border-radius:6px;
    margin-right:8px;
    display:inline-block;
}
.navbar-brand{
    display:flex;
    align-items:center;
    gap:8px;
    color:#fff !important;
    font-weight:bold;
}

/* ================= TEKS MENU ================= */
.navbar .navbar-nav .nav-link{
    color:#ffffff !important;
    font-weight:600;
    border-radius:6px;
}

/* Hover */
.navbar .navbar-nav .nav-link:hover{
    color:#ffffff !important;
    background:rgba(255,255,255,0.18);
}

/* Hilangkan abu-abu bootstrap */
.nav > li > a,
.nav > li.active > a,
.nav-pills > li > a,
.nav-pills > li.active > a{
    background:transparent !important;
    color:#fff !important;
    box-shadow:none !important;
}
/* ================= MENU AKTIF PASTI BERUBAH ================= */

/* Kalau active ada di <a> */
.navbar .navbar-nav .nav-link.active,
.navbar .navbar-nav .nav-link:focus,
.navbar .navbar-nav .nav-link.show{
    background: rgba(0,0,0,0.55) !important;
    color:#fff !important;
}

/* Kalau active ada di <li> */
.navbar-nav > li.active > a,
.navbar-nav > li > a:focus,
.navbar-nav > li > a:hover{
    background: rgba(0,0,0,0.55) !important;
    color:#fff !important;
}

/* Untuk template yang pakai .menu-open */
.nav-item.menu-open > a,
.nav-item.menu-open > .nav-link{
    background: rgba(0,0,0,0.55) !important;
    color:#fff !important;
}
/* 🔥 BATASI HANYA UNTUK NAVBAR SAJA 🔥 */

/* Active kalau ada di <a> */
.navbar .navbar-nav > li > a.active,
.navbar .navbar-nav > li > a:focus{
    background: rgba(0,0,0,0.55) !important;
    color:#fff !important;
    border-radius:6px;
}

/* Active kalau posisinya di <li> */
.navbar .navbar-nav > li.active > a{
    background: rgba(0,0,0,0.55) !important;
    color:#fff !important;
    border-radius:6px;
}

/* Hover tetap aman */
.navbar .navbar-nav > li > a:hover{
    background: rgba(0,0,0,0.35) !important;
    color:#fff !important;
}

</style>

</head>

<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed"
                    data-toggle="collapse" data-target="#menuWeb">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- LOGO + NAMA SEKOLAH -->
            <a class="navbar-brand" href="index.php">
                <?php if ($d) : ?>
                <?php if (!empty($d->logo)) : ?>
                    <img src="uploads/identitas/<?= htmlspecialchars($d->logo) ?>?v=<?= time(); ?>"class="logo-img">
                <?php endif; ?>
                <span style="margin-left:8px;"><?= htmlspecialchars($d->nama) ?></span>
                <?php endif; ?>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="menuWeb">
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="index.php">🏫Beranda</a></li>
                <li><a href="tentangsekolah.php">Tentang Sekolah</a></li>
                <li><a href="jurusan.php">Jurusan</a></li>
                <li><a href="galeri.php">Galeri</a></li>
                <li><a href="ekskul.php">Ekskul</a></li>
                <li><a href="informasi.php">Informasi</a></li>
                <li><a href="kontak.php">Kontak</a></li>
                <li><a href="login.php">🗝️Login</a></li>
            </ul>
        </div>
    </div>
</nav>