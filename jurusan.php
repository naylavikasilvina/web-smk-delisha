<?php include 'hider.php'; ?>

<div class="section" style="margin:40px 0;">
    <div class="container text-center">

        <h3 style="margin-bottom:5px;">🎓KEJURUAN</h3>
        <div style="width:80px;height:3px;background:#e74c3c;margin:10px auto 25px auto;"></div>
        <div class="row">
            <?php
            try {
                $stmt = $pdo->query("SELECT * FROM jurusan ORDER BY id ASC");
                $jurusan = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e){
                $jurusan = [];
            }

            if ($jurusan):
                foreach($jurusan as $j):
            ?>
                
            <div class="col-sm-3 col-xs-6" style="margin-bottom:25px;">
                <div class="thumbnail" style="border-radius:6px; height: 280px;">
                    
                    <div style="height:170px; overflow:hidden; border-radius:6px 6px 0 0;">
                        <img src="uploads/jurusan/<?= htmlspecialchars($j['gambar']); ?>"
                            alt="<?= htmlspecialchars($j['nama']); ?>"
                            class="img-responsive gallery-img"
                            style="width:100%; height:100%; object-fit:cover;">
                    </div>

                    <div class="caption" style="padding:10px 5px; text-align:center;">
                        <h4 style="font-size:14px; font-weight:bold; margin:0;">
                            <?= htmlspecialchars($j['nama']); ?>
                        </h4>

                        <a href="detail-jurusan.php?id=<?= htmlspecialchars($j['id']); ?>" 
                        class="btn btn-primary btn-sm" 
                        style="margin-top:8px;">
                        Lihat detail
                        </a>
                    </div>

                </div>
            </div>

            <?php 
                endforeach;
            else:
            ?>
            <div class="col-xs-12">
                <p>Belum ada data jurusan.</p>
            </div>
            <?php endif; ?>
</div>


    </div>
</div>

<?php include 'footer.php'; ?>
