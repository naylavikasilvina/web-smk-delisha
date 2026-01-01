<<?php 
    include 'hider.php';
    include '../koneksi.php';
    date_default_timezone_set("Asia/Jakarta");

    // Cek apakah ID dikirim
    if (!isset($_GET['id'])) {
        die("<div class='alert alert-danger'>ID tidak ditemukan di URL.</div>");
    }

    $id = $_GET['id'];

    try {
        // Ambil data pengguna
        $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE id = ?");
        $stmt->execute([$id]);
        $p = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$p) {
            die("<div class='alert alert-danger'>Data pengguna tidak ditemukan.</div>");
        }

    } catch (PDOException $e) {
        die("<div class='alert alert-danger'>Error: ". $e->getMessage() ."</div>");
    }
?>

<div class="container" style="margin-top: 30px;">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">📝Ubah Password</h3>
        </div>

        <div class="panel-body">
            <form method="POST" class="form-horizontal" style="margin-top: 15px;">
                
                <!-- Password Baru -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">Buat Password </label>
                    <div class="col-sm-6">
                        <input type="password" name="password_baru" class="form-control" required>
                    </div>
                </div>

                <!-- Ulangi Password -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">Konfirmasi Password</label>
                    <div class="col-sm-6">
                        <input type="password" name="password_ulangi" class="form-control" required>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <button type="submit" name="submit" class="btn btn-info">💾Simpan Password</button>
                        <a href="pengguna.php" class="btn btn-default">◀️Kembali</a>
                    </div>
                </div>
            </form>

            <?php
                if (isset($_POST['submit'])) {

                    $pass1 = $_POST['password_baru'];
                    $pass2 = $_POST['password_ulangi'];

                    if ($pass1 != $pass2) {
                        echo "<div class='alert alert-danger'>Password tidak sesuai!</div>";
                    } else {

                        try {
                            $hash = md5($pass1);

                            $update = $pdo->prepare("
                                UPDATE pengguna 
                                SET password = ?, update_at = NOW()
                                WHERE id = ?
                            ");

                            $update->execute([$hash, $id]);

                            echo "<div class='alert alert-success'>Password berhasil diubah!</div>";

                        } catch (PDOException $e) {
                            echo "<div class='alert alert-danger'>Gagal: ". $e->getMessage() ."</div>";
                        }
                    }
                }
            ?>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>