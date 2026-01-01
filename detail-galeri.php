<?php include 'hider.php'; ?>

<div class="section" style="margin:40px 0;">
    <div class="container text-center">

<?php
require 'koneksi.php'; // pastikan file PDO kamu di-include

if(!isset($_GET['id'])){
    echo "<script>window.location='index.php';</script>";
    exit;
}

// ambil id secara aman
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM galeri WHERE id = :id");
$stmt->execute(['id' => $id]);
$j = $stmt->fetch(PDO::FETCH_OBJ);

if(!$j){
    echo "<script>window.location='index.php';</script>";
} else {
?>
        <!-- Judul jurusan -->
        <h3 style="margin-bottom:10px;color:#333;">
            <?php echo htmlspecialchars($j->judul); ?>
        </h3>

        <!-- garis kecil dibawah judul -->
        <div style="width:90px;height:3px;background:#e74c3c;margin:10px auto;"></div>

        <!-- Gambar jurusan -->
        <?php if(!empty($j->foto)) { ?>
            <img src="uploads/galeri/<?php echo htmlspecialchars($j->foto); ?>" 
                 class="img-responsive img-thumbnail" 
                 style="margin:20px auto;max-width:500px;">
        <?php } ?>

        <!-- Deskripsi jurusan -->
        <p style="margin-top:20px;font-size:16px;line-height:1.7;color:#555;text-align:justify;">
            <?php echo nl2br(htmlspecialchars($j->keterangan)); ?>
        </p>

<?php } ?>
    </div>
</div>

<?php include 'footer.php'; ?>
