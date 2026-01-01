<?php
    include 'hider.php';
    include '../koneksi.php'; 

    // PAGINATION
    $limit = 5;
    $page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $start = ($page - 1) * $limit;

    // SEARCH
    $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
    $param = "%$keyword%";

    // ================= TOTAL DATA ==================
    $totalQuery = $pdo->prepare(" SELECT COUNT(*) AS total FROM galeri WHERE judul LIKE :kw OR keterangan LIKE :kw ");
    $totalQuery->execute([':kw' => $param]);
    $totalData = $totalQuery->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPage = $totalData > 0 ? ceil($totalData / $limit) : 1;

    // ================= DATA PAGINATED ==================
    $query = $pdo->prepare(" SELECT * FROM galeri WHERE judul LIKE :kw OR keterangan LIKE :kw ORDER BY id DESC LIMIT :start, :limit ");
    $query->bindValue(':kw', $param, PDO::PARAM_STR);
    $query->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $query->execute();

    $galeri = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="panel panel-success">
    <div class="panel-heading" style="background:#8bcd50; color:black"><h3 class="panel-title">🖼️GALERI</h3></div>
    <div class="panel-body">
        <a href="tambahgaleri.php" class="btn btn-success btn-sm">
            <i class="glyphicon glyphicon-plus"></i> Tambah Galeri
        </a>
        <hr>

        <!-- SEARCH -->
        <form method="GET" class="form-inline" style="margin-bottom:15px;">
            <input type="text" name="keyword" class="form-control"
                   placeholder="Cari judul / keterangan"
                   value="<?= htmlspecialchars($keyword) ?>">

            <button type="submit" class="btn btn-primary">🔍Search </button>
            <a href="galeri.php" class="btn btn-default">🔄Reset</a>
        </form>

        <div class="table-responsive">
            <table id="tabeljurusan" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="success">
                        <th>No</th>
                        <th>Judul</th>
                        <th>Foto</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $no = $start + 1;
                    if ($galeri) {foreach ($galeri as $p) {
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($p['judul']); ?></td>
                        <td>
                            <?php if (!empty($p['foto'])) { ?>
                                <img src="../uploads/galeri/<?= htmlspecialchars($p['foto']); ?>"
                                style="width:80px;height:80px;object-fit:cover;border-radius:4px;">
                            <?php } else { ?>
                                <span class="text-danger">Tidak ada Foto</span>
                            <?php } ?>
                        </td>

                        <td><?= htmlspecialchars($p['keterangan']); ?></td>
                        <td>
                            <div style="display:flex; gap:5px;">
                                <a href="editgaleri.php?id=<?= $p['id']; ?>" class="btn btn-warning btn-sm">✏️Edit</a>
                                <a href="hapusgaleri.php?id=<?= $p['id']; ?>" class="btn btn-danger btn-sm"onclick="return confirm('Yakin hapus data ini?');">🗑️Hapus</a>
                            </div>
                        </td>
                    </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="7" class="text-center">Belum ada data jurusan</td></tr>';
                }
                ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <nav aria-label="Page navigation">
            <ul class="pagination">

                <!-- PREV -->
                <?php if ($page > 1) { ?>
                    <li><a href="?page=<?= $page - 1 ?>&keyword=<?= $keyword ?>">&laquo; Prev</a></li>
                <?php } else { ?>
                    <li class="disabled"><a>&laquo; Prev</a></li>
                <?php } ?>

                <!-- PAGES -->
                <?php for ($i = 1; $i <= $totalPage; $i++) { ?>
                    <li class="<?= ($page == $i) ? 'active' : '' ?>">
                        <a href="?page=<?= $i ?>&keyword=<?= $keyword ?>"><?= $i ?></a>
                    </li>
                <?php } ?>

                <!-- NEXT -->
                <?php if ($page < $totalPage) { ?>
                    <li><a href="?page=<?= $page + 1 ?>&keyword=<?= $keyword ?>">Next &raquo;</a></li>
                <?php } else { ?>
                    <li class="disabled"><a>Next &raquo;</a></li>
                <?php } ?>

            </ul>
        </nav>
    </div>
</div>

<?php include 'footer.php'; ?>
