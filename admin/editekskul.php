<?php include 'hider.php'; ?>
<?php 
    include '../koneksi.php';
    date_default_timezone_set("Asia/Jakarta");

    // Pastikan ID ada
    if (!isset($_GET['id']) || $_GET['id'] == '') {
        echo "<script>window.location='ekskul.php'</script>";
        exit;
    }
    $id = $_GET['id'];

    // Ambil data jurusan
    $stmt = $pdo->prepare("SELECT * FROM ekskul WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $p = $stmt->fetch(PDO::FETCH_OBJ);

    // Jika tidak ditemukan
    if (!$p) {
        echo "<script>window.location='ekskul.php'</script>";
        exit;
    }
?>

<div class="container" style="margin-top: 30px;">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">🏆Edit Ekskul</h3>
        </div>

        <div class="panel-body">
            <form method="POST" class="form-horizontal" style="margin-top: 15px;">
                
                <!-- Nama Ekskul -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">Nama Ekskul</label>
                    <div class="col-sm-6">
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($p->nama) ?>" required>
                    </div>
                </div>

                <!-- Keterangan -->
               <div class="form-group">
                    <label class="col-sm-2 text-left">Keterangan</label>
                    <div class="col-sm-6">
                        <textarea 
                            name="keterangan" 
                            class="form-control" 
                            rows="10" 
                            required><?= htmlspecialchars($p->keterangan) ?>
                        </textarea>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <button type="submit" name="submit" class="btn btn-info">📝Edit</button>
                        <a href="ekskul.php" class="btn btn-default">◀️Kembali</a>
                    </div>
                </div>
            </form>

            <?php
                if (isset($_POST["submit"])) {

                    $nama          = trim($_POST['nama']);
                    $keterangan    = trim($_POST['keterangan']);
                    $update = $pdo->prepare("
                        UPDATE ekskul SET 
                            nama = :nama,
                            keterangan = :ket,
                            update_at = NOW()
                        WHERE id = :id
                    ");

                    $exec = $update->execute([
                        ':nama'   => $nama,
                        ':ket'    => $keterangan,
                        ':id'     => $id
                    ]);

                    if ($exec) {
                        echo '<div class="alert alert-success" style="margin-top:15px;">
                                <strong>Berhasil!</strong> Data ekskul berhasil diperbarui.
                            </div>';
                        echo "<meta http-equiv='refresh' content='1'>";
                    } else {
                        echo '<div class="alert alert-danger" style="margin-top:15px;">
                                <strong>Gagal!</strong> Data tidak dapat diperbarui.
                            </div>';
                    }
                }
            ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
