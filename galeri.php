<?php include 'hider.php'; ?>

<div class="section" style="margin:40px 0;">
    <div class="container text-center">

        <h3 style="margin-bottom:5px;">🖼️GALERI</h3>
        <div style="width:80px;height:3px;background:#e74c3c;margin:10px auto 25px auto;"></div>
        <div class="row">
            <?php
            try {
                $stmt = $pdo->query("SELECT * FROM galeri ORDER BY id ASC");
                $galeri = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e){
                $galeri = [];
            }

            if ($galeri):
                foreach($galeri as $j):
            ?>
                
            <div class="col-sm-3 col-xs-6" style="margin-bottom:25px;">
                <div class="thumbnail" style="border-radius:6px; height: 280px;">
                    
                    <div style="height:170px; overflow:hidden; border-radius:6px 6px 0 0;">
                        <img src="uploads/galeri/<?= htmlspecialchars($j['foto']); ?>"
                            alt="<?= htmlspecialchars($j['judul']); ?>"
                            class="img-responsive gallery-img"
                            style="width:100%; height:100%; object-fit:cover;">
                    </div>

                    <div class="caption" style="padding:10px 5px; text-align:center;">
                        <h4 style="font-size:14px; font-weight:bold; margin:0;">
                            <?= htmlspecialchars($j['judul']); ?>
                        </h4>

                        <a href="detail-galeri.php?id=<?= htmlspecialchars($j['id']); ?>" 
                        class="btn btn-primary btn-sm" 
                        style="margin-top:8px;">
                        selengkapnya
                        </a>
                    </div>

                </div>
            </div>

            <?php 
                endforeach;
            else:
            ?>
            <div class="col-xs-12">
                <p>Belum ada data galeri.</p>
            </div>
            <?php endif; ?>
</div>


    </div>
</div>

<?php include 'footer.php'; ?>
