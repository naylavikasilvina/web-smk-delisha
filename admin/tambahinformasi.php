<?php include 'hider.php'; ?>
<?php include '../koneksi.php'; ?>

<div class="container" style="margin-top: 30px;">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">📢Tambah Informasi</h3>
        </div>
        <div class="panel-body">
            <form method="POST" enctype="multipart/form-data" class="form-horizontal">

                <!-- Judul -->
                <div class="form-group">
                    <label class="col-sm-2 text-left">Judul</label>
                    <div class="col-sm-6">
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="form-group">
                    <label class="col-sm-2 text-left">Keterangan</label>
                    <div class="col-sm-8">
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="6"></textarea>
                    </div>
                </div>

                <!-- Gambar -->
                <div class="form-group">
                    <label class="col-sm-2 text-left">Gambar</label>
                    <div class="col-sm-6">
                        <input type="file" name="gambar" class="form-control" required>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <button type="submit" name="submit" class="btn btn-success">📥Simpan</button>
                        <a href="informasi.php" class="btn btn-default"> ◀️Kembali</a>
                    </div>
                </div>
            </form>

            <?php
            if (isset($_POST['submit'])) {
                try {
                    $judul      = $_POST['judul'] ?? '';
                    $keterangan = $_POST['keterangan'] ?? '';

                    // validasi sederhana
                    if ($judul == '' || $keterangan == '') {
                        echo '<div class="alert alert-danger">Judul & keterangan wajib diisi.</div>';
                    } else {

                        $namaFile = $_FILES['gambar']['name'];
                        $tmpFile  = $_FILES['gambar']['tmp_name'];

                        $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
                        $allowed = ['jpg','jpeg','png','gif'];

                        if (!in_array($ext, $allowed)) {
                            echo '<div class="alert alert-danger">Format gambar tidak didukung!</div>';
                        } else {

                            $path = "../uploads/informasi/";
                            if (!is_dir($path)) {
                                mkdir($path, 0777, true);
                            }

                            $namaBaru = 'informasi_' . time() . '.' . $ext;

                            move_uploaded_file($tmpFile, $path . $namaBaru);

                            $sql = "INSERT INTO informasi (judul, keterangan, gambar) VALUES (:judul, :keterangan, :gambar)";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([
                                ':judul'      => $judul,
                                ':keterangan' => $keterangan,
                                ':gambar'     => $namaBaru
                            ]);

                            echo '<div class="alert alert-success">Informasi berhasil ditambahkan.</div>';
                            echo "<script>setTimeout(()=>window.location='informasi.php',1200);</script>";
                        }
                    }
                } catch (PDOException $e) {
                    echo '<div class="alert alert-danger">Error: '.$e->getMessage().'</div>';
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
    autoParagraph: false,   // <-- mencegah CKEditor menambahkan <p> otomatis
    removePlugins: 'elementspath',
    resize_enabled: false
});
</script>

<?php include 'footer.php'; ?>
