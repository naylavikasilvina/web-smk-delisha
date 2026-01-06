<?php 
include 'hider.php';
include 'koneksi.php';

// biar notice kelihatan saat debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ambil input
    $nama  = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $pesan = trim($_POST['pesan']);

    // validasi sederhana
    if ($nama == '' || $email == '' || $pesan == '') {
        $status  = 'error';
        $message = 'Semua field wajib diisi.';
    } else {
        try {
            // pakai prepared statement
            $sql = "INSERT INTO pesan_kontak (nama, email, pesan, tanggal)
                    VALUES (:nama, :email, :pesan, NOW())";

            $stmt = $pdo->prepare($sql);
            $simpan = $stmt->execute([
                ':nama'  => $nama,
                ':email' => $email,
                ':pesan' => $pesan
            ]);

            if ($simpan) {
                $status  = 'success';
                $message = 'Pesan berhasil dikirim. Terima kasih sudah menghubungi kami.';
            } else {
                $status  = 'error';
                $message = 'Terjadi kesalahan saat mengirim pesan. Coba lagi beberapa saat lagi.';
            }

        } catch (PDOException $e) {
            $status  = 'error';
            $message = 'Error: ' . $e->getMessage();
        }
    }

} else {
    header('Location: kontak.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kirim Pesan - SMK RAID SCHOOL</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container" style="padding-top:60px; max-width:600px;">
    <?php if ($status == 'success') : ?>
        <div class="alert alert-success">
            <strong>Berhasil!</strong> <?= $message; ?>
        </div>
    <?php else : ?>
        <div class="alert alert-danger">
            <strong>Gagal!</strong> <?= $message; ?>
        </div>
    <?php endif; ?>

    <a href="kontak.php" class="btn btn-primary">
        &laquo; Kembali ke Halaman Kontak
    </a>
</div>

<?php include 'footer.php'; ?>
