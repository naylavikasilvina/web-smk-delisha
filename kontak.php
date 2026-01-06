<?php include 'hider.php'; ?>

<?php
// ambil data identitas dari database pakai PDO
try {
    $sql = "SELECT * FROM pengaturan LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $d = $stmt->fetch(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<section style="padding:40px 0;">
    <div class="container">
        <h3 class="text-center" style="margin-bottom:25px;">
            📞KONTAK SEKOLAH
        </h3>

        <div class="row">

            <!-- Informasi Kontak -->
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading" style="font-weight:bold;">
                        Informasi Kontak
                    </div>
                    <div class="panel-body">
                        
                        <p style="font-size:15px;">
                            <span class="glyphicon glyphicon-education"></span> 
                            &nbsp;<strong><?= htmlspecialchars($d->nama); ?></strong>
                        </p>

                        <p>
                            <span class="glyphicon glyphicon-map-marker"></span>
                            &nbsp;<?= htmlspecialchars($d->alamat); ?>
                        </p>

                        <p>
                            <span class="glyphicon glyphicon-earphone"></span>
                            &nbsp; <?= htmlspecialchars($d->telpon); ?>
                        </p>

                        <p>
                            <span class="glyphicon glyphicon-envelope"></span>
                            &nbsp; <?= htmlspecialchars($d->email); ?>
                        </p>

                        <hr>
                        <small style="opacity:.8;">
                            Jam layanan: Senin – Jumat, 08.00 – 15.00 WIB
                        </small>
                    </div>
                </div>

                <!-- Peta Lokasi -->
                <div class="embed-responsive embed-responsive-16by9" style="margin-top:10px;">
                    <iframe 
                        class="embed-responsive-item"
                        src="<?= $d->GoogleMaps; ?>" 
                        style="border:0;"
                        allowfullscreen></iframe>
                </div>
            </div>

            <!-- Form Pesan -->
            <div class="col-md-7">
                <div class="panel panel-default">
                    <div class="panel-heading" style="font-weight:bold;">
                        Kirim Pesan
                    </div>

                    <div class="panel-body">
                        <form method="post" action="kirim_pesan.php">

                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Pesan</label>
                                <textarea name="pesan" rows="4" class="form-control" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                <span class="glyphicon glyphicon-send"></span> Kirim
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div><!-- row -->
    </div><!-- container -->
</section>

<?php include 'footer.php'; ?>
