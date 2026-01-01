<?php
    include 'hider.php'; // pastikan di sini sudah ada $pdo

    // ================== AMBIL DATA ==================
    $identitas = $pdo->query("SELECT * FROM pengaturan ORDER BY id ASC LIMIT 1");
    $d = $identitas->fetch(PDO::FETCH_OBJ);

    if (!$d) {die("Data pengaturan tidak ditemukan");}
    $id = $d->id;
?>

<div class="container" style="margin-top: 30px;">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">👨‍🏫Kepala Sekolah</h3>
        </div>

        <div class="panel-body">
            <form method="POST" class="form-horizontal" enctype="multipart/form-data" style="margin-top: 15px;">

                <!-- Nama Kepala Sekolah -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">Nama Kepala Sekolah</label>
                    <div class="col-sm-6">
                        <input type="text" name="nama_kepsek" class="form-control" value="<?= htmlspecialchars($d->nama_kepsek); ?>" required>
                    </div>
                </div>

                <!-- Sambutan -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">Sambutan</label>
                    <div class="col-sm-8">
                        <textarea name="kata_sambutan" id="kata_sambutan" class="form-control" rows="8" required><?= htmlspecialchars($d->kata_sambutan); ?></textarea>
                    </div>
                </div>

                <!-- Foto Kepala Sekolah -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">Foto Kepala Sekolah</label>
                    <div class="col-sm-6">

                        <?php if (!empty($d->foto_kepsek)) { ?>
                            <img src="../uploads/identitas/<?= htmlspecialchars($d->foto_kepsek); ?>"
                                 style="max-width:250px; border:1px solid #ddd; border-radius:4px; margin-bottom:10px; padding:3px;">
                        <?php } else { ?>
                            <p><i>Belum ada foto kepala sekolah</i></p>
                        <?php } ?>

                        <input type="file" name="foto_kepsek" class="form-control" style="margin-top:10px;">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <button type="submit" name="submit" class="btn btn-success">📥Simpan</button>
                    </div>
                </div>
            </form>

            <?php
            // ================== PROSES SIMPAN ==================
            if (isset($_POST['submit'])) {

                $nama_kepsek    = $_POST['nama_kepsek'];
                $kata_sambutan  = $_POST['kata_sambutan'];

                // ambil data lama
                $stmt = $pdo->prepare("SELECT * FROM pengaturan WHERE id = :id LIMIT 1");
                $stmt->execute([':id' => $id]);
                $lama = $stmt->fetch(PDO::FETCH_OBJ);
                $foto_lama = $lama->Foto_kepsek;

                $folder_upload = "../uploads/identitas/";
                if (!is_dir($folder_upload)) {
                    mkdir($folder_upload, 0777, true);
                }

                // HANDLE FOTO
                $foto_baru = $foto_lama;
                if (!empty($_FILES['foto_kepsek']['name'])) {
                    $nama_file = time() . "_" . $_FILES['foto_kepsek']['name'];
                    $tmp_file  = $_FILES['foto_kepsek']['tmp_name'];

                    if (move_uploaded_file($tmp_file, $folder_upload . $nama_file)) {
                        if (!empty($foto_lama) && file_exists($folder_upload . $foto_lama)) {
                            @unlink($folder_upload . $foto_lama);
                        }
                        $foto_baru = $nama_file;
                    }
                }

                // UPDATE DATA
                $sql = "UPDATE pengaturan SET 
                            nama_kepsek = :nama,
                            kata_sambutan = :sambutan,
                            foto_kepsek = :foto
                        WHERE id = :id";

                $update = $pdo->prepare($sql)->execute([
                    ':nama'     => $nama_kepsek,
                    ':sambutan' => $kata_sambutan,
                    ':foto'     => $foto_baru,
                    ':id'       => $id
                ]);

                if ($update) {
                    echo '<div class="alert alert-success" style="margin-top:15px;"><strong>Berhasil!</strong> Data kepala sekolah diperbarui.</div>';
                    echo '<meta http-equiv="refresh" content="1; url=kepalasekolah.php">';
                } else {
                    echo '<div class="alert alert-danger" style="margin-top:15px;"><strong>Gagal!</strong> Terjadi kesalahan update.</div>';
                }
            }
            ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
 
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('kata_sambutan', {
        height: 250
    });
</script>
