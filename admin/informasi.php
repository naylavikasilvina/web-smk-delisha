<?php
    include 'hider.php';
    include '../koneksi.php';

    // PAGINATION
    $limit = 5;
    $page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page  = ($page < 1) ? 1 : $page;
    $start = ($page - 1) * $limit;

    // SEARCH
    $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
    $like = "%$keyword%";

    // TOTAL DATA
    $stmtTotal = $pdo->prepare(" SELECT COUNT(*) as total FROM informasi WHERE judul LIKE :keyword ");
    $stmtTotal->execute([':keyword' => $like]);
    $totalData = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPage = ($totalData > 0) ? ceil($totalData / $limit) : 1;

    // DATA INFORMASI
    $stmt = $pdo->prepare(" SELECT * FROM informasi WHERE judul LIKE :keyword  ORDER BY id DESC LIMIT :start, :limit ");
    $stmt->bindValue(':keyword', $like, PDO::PARAM_STR);
    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();

    $informasi = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="panel panel-success">
    <div class="panel-heading" style="background:#8bcd50; color:black">
        <h3 class="panel-title">📢INFORMASI</h3>
    </div>
    <div class="panel-body">
        <a href="tambahinformasi.php" class="btn btn-success btn-sm">
            <i class="glyphicon glyphicon-plus"></i> Tambah Informasi
        </a>
        <hr>

        <!-- SEARCH -->
        <form method="GET" class="form-inline" style="margin-bottom:15px;">
            <input type="text" name="keyword" class="form-control" placeholder="Cari Judul" value="<?= htmlspecialchars($keyword); ?>">
            <button type="submit" class="btn btn-primary">🔍Search</button>
            <a href="informasi.php" class="btn btn-default">🔄Reset</a>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="success">
                        <th width="50">No</th>
                        <th>Judul</th>
                        <th>Keterangan</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    $no = $start + 1;
    if ($informasi) {
        foreach ($informasi as $p) {
    ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars($p['judul']); ?></td>
        <!-- ganti ini -->
        <td><?= nl2br(strip_tags($p['keterangan'])); ?></td>
        <td>
            <img src="../uploads/informasi/<?= htmlspecialchars($p['gambar']); ?>" width="100">
        </td>
        <td>
            <div style="display:flex; gap:5px;">
                <a href="editinformasi.php?id=<?= $p['id']; ?>" class="btn btn-warning btn-sm">✏️Edit</a>
                <a href="hapusinformasi.php?id=<?= $p['id']; ?>" 
                class="btn btn-danger btn-sm"
                onclick="return confirm('Yakin hapus data ini?');">🗑️Hapus
                </a>
            </div>
        </td>
    </tr>
    <?php
        }
    } else {
        echo '<tr><td colspan="5" class="text-center">Data informasi belum tersedia</td></tr>';
    }
    ?>
</tbody>

            </table>
        </div>

        <!-- PAGINATION -->
        <ul class="pagination">
            <?php if ($page > 1) { ?>
                <li><a href="?page=<?= $page-1 ?>&keyword=<?= htmlspecialchars($keyword) ?>">&laquo;</a></li>
            <?php } ?>

            <?php for ($i=1; $i<=$totalPage; $i++) { ?>
                <li class="<?= ($page==$i)?'active':'' ?>">
                    <a href="?page=<?= $i ?>&keyword=<?= htmlspecialchars($keyword) ?>"><?= $i ?></a>
                </li>
            <?php } ?>

            <?php if ($page < $totalPage) { ?>
                <li>
                    <a href="?page=<?= $page+1 ?>&keyword=<?= htmlspecialchars($keyword) ?>">&raquo;</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<?php include 'footer.php'; ?>
