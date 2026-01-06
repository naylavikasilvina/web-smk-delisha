<?php
session_start();
include "koneksi.php"; // koneksi.php menggunakan $pdo

// ==============================
// Proses Login (paling atas, sebelum HTML)
// ==============================
if(isset($_POST['submit'])){
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    // Gunakan $pdo sesuai koneksi.php
    $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE username = ?");
    $stmt->execute([$user]);
    $d = $stmt->fetch(PDO::FETCH_OBJ);

    if($d){
        if(md5($pass) == $d->password){
            $_SESSION['status_login'] = true;
            $_SESSION['uid'] = $d->id;
            $_SESSION['unama'] = $d->nama;
            $_SESSION['ulevel'] = $d->level;

            // Redirect aman ke dashboard
            header("Location: admin/dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Password salah";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Username tidak ditemukan";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Login</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style-login.css">

    <!-- Logo sekolah sebagai favicon -->
    <?php
    include 'koneksi.php';
    $stmt = $pdo->query("SELECT * FROM pengaturan LIMIT 1");
    $d = $stmt->fetch(PDO::FETCH_OBJ);
    ?>
    <?php if (!empty($d->logo)) : ?>
        <link rel="icon" type="image/png" href="uploads/identitas/<?= htmlspecialchars($d->logo) ?>" />
    <?php endif; ?>
</head>

<body>

<div class="card-login panel panel-default">
    <div class="card-header">HALAMAN LOGIN</div>
    <div class="panel-body">

        <?php 
        // Tampilkan pesan error jika ada
        if(isset($_SESSION['error'])){
            echo "<div class='alert alert-danger'>".$_SESSION['error']."</div>";
            unset($_SESSION['error']);
        }

        // Tampilkan pesan GET msg (misal logout atau belum login)
        if(isset($_GET['msg'])){
            echo "<div class='alert alert-danger'>".$_GET['msg']."</div>";
        }
        ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="user" placeholder="Username" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="pass" placeholder="Password" class="form-control" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>
    <div class="card-footer">
        <a href="index.php">Halaman Utama</a>
    </div>
</div>

<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){
    $(".card-login").fadeIn(1000);
});
</script>

</body>
</html>
