<?php include 'hider.php'; ?>

<div class="section" style="margin:40px 0;">
    <div class="container text-center">

        <h3 style="margin-bottom:5px;">📢INFORMASI</h3>
        <div style="width:80px;height:3px;background:#e74c3c;margin:10px auto 25px auto;"></div>

        <div class="row">
            <?php
                try {
                    $sql = "SELECT id, judul, keterangan, gambar FROM informasi ORDER BY id DESC";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $informasi = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($informasi && count($informasi) > 0) {
                        foreach ($informasi as $p) {
            ?>
            <a href="detail-informasi.php?id=<?= $p['id']; ?>" style="text-decoration:none; color:inherit;">
                <div class="col-sm-3 col-xs-6" style="margin-bottom:20px;">
                    <div class="thumbnail" style="border-radius:6px;">
                        <div class="thumbnail-img" style="height:150px; overflow:hidden;">
                            <img src="uploads/informasi/<?= htmlspecialchars($p['gambar']); ?>" 
                                 alt="<?= htmlspecialchars($p['judul']); ?>" 
                                 class="img-responsive"
                                 style="width:100%;">
                        </div>
                        <div class="caption" style="padding:10px 5px;">
                            <h4 style="font-size:14px; font-weight:bold; margin:0;">
                                <?= htmlspecialchars($p['judul']); ?>
                            </h4>
                        </div>
                    </div>
                </div>
            </a>
            <?php
                        }
                    } else {
            ?>
                <div class="col-xs-12">
                    <p>Belum ada data informasi.</p>
                </div>
            <?php
                    }
                } catch (PDOException $e) {
                    echo "<p>Error: " . $e->getMessage() . "</p>";
                }
            ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
