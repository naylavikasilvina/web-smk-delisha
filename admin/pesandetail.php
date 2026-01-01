<?php include 'hider.php'; ?>

<div class="section" style="margin:40px 0;">
    <div class="container text-center">

<?php
require '../koneksi.php'; // pastikan file PDO kamu di-include

if(!isset($_GET['id'])){
    echo "<script>window.location='pesanmasuk.php';</script>";
    exit;
}

// ambil id secara aman
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM pesan_kontak WHERE id = :id");
$stmt->execute(['id' => $id]);
$row = $stmt->fetch(PDO::FETCH_OBJ);

if(!$row){
    echo "<script>window.location='pesanmasuk.php';</script>";
} else {
?>
        <!-- Judul jurusan -->
        <h3 style="margin-bottom:10px;color:#333;">
            <?php echo htmlspecialchars($row->nama); ?>
        </h3>

        <!-- garis kecil dibawah judul -->
        <div style="width:90px;height:3px;background:#e74c3c;margin:10px auto;"></div>

        <h3 style="margin-bottom:10px;color:#333;">
            <?php echo htmlspecialchars($row->email); ?>
        </h3>

         <h3 style="margin-bottom:10px;color:#333;">
            <?php echo htmlspecialchars($row->pesan); ?>
        </h3>

      

        <!-- Deskripsi jurusan -->
        <p style="margin-top:20px;font-size:16px;line-height:1.7;color:#555;text-align:justify;">
            <?php echo nl2br(htmlspecialchars($row->tanggal)); ?>
        </p>

<?php } ?>
    </div>
</div>

<?php include 'footer.php'; ?>
