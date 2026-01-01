<?php
include 'hider.php';
include '../koneksi.php';

// CEK ID
if (!isset($_GET['id']) || $_GET['id'] == '') {
    echo "<script>window.location='informasi.php'</script>";
    exit;  // hapus tulisan "coba perbaiki"
}

$id = $_GET['id'];

// AMBIL DATA INFORMASI
$stmt = $pdo->prepare("SELECT * FROM informasi WHERE id = :id");
$stmt->execute([':id' => $id]);

if ($stmt->rowCount() == 0) {
    echo "<script>window.location='informasi.php'</script>";
    exit;
}

$p = $stmt->fetch(PDO::FETCH_OBJ);
?>

<div class="container" style="margin-top:30px;">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">📢Edit Informasi</h3>
        </div>

        <div class="panel-body">
            <form method="POST" enctype="multipart/form-data" class="form-horizontal">

                <!-- JUDUL -->
                <div class="form-group">
                    <label class="col-sm-2 text-left">Judul</label>
                    <div class="col-sm-6">
                        <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($p->judul) ?>" required>
                    </div>
                </div>

                <!-- KETERANGAN -->
                <div class="form-group">
                    <label class="col-sm-2 text-left">Keterangan</label>
                    <div class="col-sm-6">
                        <!-- pakai htmlspecialchars saja, jangan nl2br di textarea -->
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="10" required><?= htmlspecialchars($p->keterangan) ?></textarea>
                    </div>
                </div>

                <!-- FOTO LAMA -->
                <div class="form-group">
                    <label class="col-sm-2 text-left">Foto Saat Ini</label>
                    <div class="col-sm-6">
                        <?php if (!empty($p->gambar)) { ?>
                            <img src="../uploads/informasi/<?= htmlspecialchars($p->gambar) ?>"
                                 width="150"
                                 style="margin-bottom:10px; display:block;">
                        <?php } else { ?>
                            <p class="text-muted">Belum ada foto</p>
                        <?php } ?>
                    </div>
                </div>

                <!-- INPUT FOTO BARU -->
                <div class="form-group">
                    <label class="col-sm-2 text-left">Ganti Foto</label>
                    <div class="col-sm-6">
                        <input type="file" name="gambar" class="form-control">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti foto</small>
                    </div>
                </div>

                <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($p->gambar) ?>">

                <!-- TOMBOL -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <button type="submit" name="submit" class="btn btn-info">📝Edit</button>
                        <a href="informasi.php" class="btn btn-default">◀️Kembali</a>
                    </div>
                </div>
            </form>

            <?php
            if (isset($_POST['submit'])) {
                $judul      = $_POST['judul'];
                $keterangan = $_POST['keterangan']; // tetap simpan HTML dari CKEditor
                $foto_lama  = $_POST['foto_lama'];
                $path = "../uploads/informasi/";

                // Jika ganti gambar
                if (!empty($_FILES['gambar']['name'])) {
                    $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
                    $allowed = ['jpg','jpeg','png','gif'];

                    if (!in_array($ext, $allowed)) {
                        echo '<div class="alert alert-danger">Format gambar tidak didukung</div>';
                    } else {
                        if (!is_dir($path)) mkdir($path, 0777, true);

                        $foto_baru = "informasi_" . time() . "." . $ext;
                        move_uploaded_file($_FILES['gambar']['tmp_name'], $path . $foto_baru);

                        if (!empty($foto_lama) && file_exists($path . $foto_lama)) unlink($path . $foto_lama);

                        $stmtUpdate = $pdo->prepare("
                            UPDATE informasi 
                            SET judul = :judul,
                                keterangan = :ket,
                                gambar = :gambar,
                                update_at = NOW()
                            WHERE id = :id
                        ");

                        $save = $stmtUpdate->execute([
                            ':judul'  => $judul,
                            ':ket'    => $keterangan,
                            ':gambar' => $foto_baru,
                            ':id'     => $id
                        ]);
                    }

                } else {
                    // Tanpa ganti gambar
                    $stmtUpdate = $pdo->prepare("
                        UPDATE informasi 
                        SET judul = :judul,
                            keterangan = :ket,
                            update_at = NOW()
                        WHERE id = :id
                    ");

                    $save = $stmtUpdate->execute([
                        ':judul' => $judul,
                        ':ket'   => $keterangan,
                        ':id'    => $id
                    ]);
                }

                if ($save) {
                    echo '<div class="alert alert-success" style="margin-top:15px;">Informasi berhasil diperbarui</div>';
                } else {
                    echo '<div class="alert alert-danger" style="margin-top:15px;">Gagal memperbarui data</div>';
                }
            }
            ?>
        </div>
    </div>
</div>

<!-- CKEDITOR -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace('keterangan', {
    autoParagraph: false,   // mencegah <p> otomatis
    enterMode: CKEDITOR.ENTER_BR, // tekan enter → <br>
    shiftEnterMode: CKEDITOR.ENTER_P,
    removePlugins: 'elementspath',
    resize_enabled: false
});
</script>

<?php include 'footer.php'; ?>
