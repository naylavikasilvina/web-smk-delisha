<?php 
include 'hider.php';
require 'koneksi.php';   // penting supaya $pdo ada

// cek id
if (!isset($_GET['id'])) {
    echo "<script>window.location='index.php';</script>";
    exit;
}

$id = $_GET['id'];

// ambil data informasi pakai PDO
$stmt = $pdo->prepare("SELECT * FROM informasi WHERE id = :id");
$stmt->execute(['id' => $id]);
$i = $stmt->fetch(PDO::FETCH_OBJ);

// jika data tidak ada
if(!$i){
    echo "<script>window.location='index.php';</script>";
    exit;
}
?>

<div class="section" style="margin:40px 0;">
    <div class="container">

        <!-- Judul informasi -->
        <h3 class="text-center" style="margin-bottom:5px;color:#333;">
            <?= htmlspecialchars($i->judul); ?>
        </h3>

        <!-- garis kecil bawah judul -->
        <div style="width:90px;height:3px;background:#3498db;margin:10px auto 25px auto;"></div>

        <!-- Tanggal -->
        <p class="text-center" style="color:gray;margin-bottom:25px;">
            <i class="glyphicon glyphicon-calendar"></i>
            <?= date('d M Y', strtotime($i->created_at)); ?>
        </p>

        <!-- Gambar informasi -->
        <?php if(!empty($i->gambar)) { ?>
            <div class="text-center">
                <img src="uploads/informasi/<?= htmlspecialchars($i->gambar); ?>"
                     class="img-responsive img-thumbnail"
                     style="margin:0 auto 25px auto;max-width:600px;">
            </div>
        <?php } ?>

        <!-- Isi informasi -->
        <p style="font-size:16px;line-height:1.8;color:#555;text-align:justify;">
            <?= nl2br(html_entity_decode($i->keterangan)); ?>
        </p>

    </div>
</div>

<?php include 'footer.php'; ?>
