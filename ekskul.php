<?php include 'hider.php'; ?>

<div class="section" style="margin:40px 0;">
    <div class="container text-center">

        <h3 style="margin-bottom:5px;">🏆Ekstrakurikuler</h3>
        <div style="width:80px;height:3px;background:#e74c3c;margin:10px auto 25px auto;"></div>

        <div class="row">
        <?php
        try {
            $stmt = $pdo->query("SELECT * FROM ekskul ORDER BY id ASC");
            $ekskul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e){
            $ekskul = [];
        }

        if ($ekskul):
            foreach($ekskul as $j):
        ?>
        
        <a href="detail-ekskul.php?id=<?= htmlspecialchars($j['id']); ?>" 
           style="text-decoration:none; color:inherit;">
            <div class="col-sm-3 col-xs-6" style="margin-bottom:20px;">
                <div class="thumbnail" style="border-radius:6px;">
                    <div class="thumbnail-img" style="height:150px; overflow:hidden;">
                        <img src="uploads/ekskul/<?= htmlspecialchars($j['gambar']); ?>" 
                             alt="<?= htmlspecialchars($j['nama']); ?>" 
                             class="img-responsive"
                             style="width:100%;">
                    </div>
                    <div class="caption" style="padding:10px 5px;">
                        <h4 style="font-size:14px; font-weight:bold; margin:0;">
                            <?= htmlspecialchars($j['nama']); ?>
                        </h4>
                    </div>
                </div>
            </div>
        </a>

        <?php 
            endforeach;
        else:
        ?>
            <div class="col-xs-12">
                <p>Belum ada data ekskul.</p>
            </div>
        <?php endif; ?>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>
