<?= $this->extend('admin/layout'); ?>
<?= $this->section('content'); ?>

<?php
// variabel aman (controller bisa mengirim products/users/orders/sales)
$products = $products ?? [];
$users    = $users ?? [];
$orders   = $orders ?? [];
$sales    = $sales ?? []; // array angka untuk grafik (dari lama ke baru)

function rupiah($n)
{
    return 'Rp ' . number_format((float)$n, 0, ',', '.');
}

// Nilai turunan
$totalProducts = count($products);
$totalUsers    = count($users);
$totalOrders   = count($orders);
$totalRevenue  = 0;

// Jika orders tersedia, jumlahkan total (toleran terhadap nama kolom berbeda)
if (!empty($orders)) {
    foreach ($orders as $o) {
        if (isset($o['total'])) $totalRevenue += (float)$o['total'];
        elseif (isset($o['grand_total'])) $totalRevenue += (float)$o['grand_total'];
        elseif (isset($o['amount'])) $totalRevenue += (float)$o['amount'];
    }
}

// Daftar untuk panel (maksimal 3 item)
$recentProducts = array_slice($products, 0, 3);
$lowStock = array_filter($products, function ($p) {
    return isset($p['stok']) && (int)$p['stok'] <= 5;
});
usort($products, function ($a, $b) {
    return ($b['rating'] ?? 0) <=> ($a['rating'] ?? 0);
});
$topRated = array_slice($products, 0, 3);

// Fallback grafik: jika controller tidak mengirim $sales, buat contoh 7 poin
if (empty($sales)) {
    $sales = [];
    $days = 7;
    for ($i = $days - 1; $i >= 0; $i--) {
        $sales[] = rand(0, 500000);
    }
}
// Buat label grafik dari kunci array sales (dari lama ke baru)
$chartLabels = [];
$keys = array_keys($sales);
foreach ($keys as $k) {
    $chartLabels[] = date('d M', strtotime("-" . (count($keys) - 1 - $k) . " days"));
}
?>

<div class="dashboard">
    <div class="dashboard-header">
        <div>
            <h1>Dasbor</h1>
            <p class="muted">Selamat datang, <?= htmlspecialchars(session()->get('full_name') ?? 'Admin'); ?> —
                <?= date('l, d F Y'); ?></p>
        </div>
        <div class="header-actions">
            <a href="/admin/produk/tambah" class="btn primary">+ Tambah Produk</a>
        </div>
    </div>

    <div class="kpi-grid">
        <div class="kpi card">
            <div class="kpi-title">Total Produk</div>
            <div class="kpi-value"><?= $totalProducts; ?></div>
            <div class="kpi-sub">Jumlah produk aktif</div>
        </div>

        <div class="kpi card">
            <div class="kpi-title">Total Pengguna</div>
            <div class="kpi-value"><?= $totalUsers; ?></div>
            <div class="kpi-sub">Customer dan admin terdaftar</div>
        </div>

        <div class="kpi card">
            <div class="kpi-title">Total Pesanan</div>
            <div class="kpi-value"><?= $totalOrders; ?></div>
            <div class="kpi-sub">Pesanan selesai dan tertunda</div>
        </div>

        <div class="kpi card">
            <div class="kpi-title">Perkiraan Pendapatan</div>
            <div class="kpi-value"><?= rupiah($totalRevenue); ?></div>
            <div class="kpi-sub">Jumlah dari pesanan terbaru</div>
        </div>
    </div>

    <div class="panels">
        <div class="left column">
            <div class="card panel">
                <div class="panel-head">
                    <h3>Penjualan (<?= count($sales); ?> titik terakhir)</h3>
                    <small class="muted">Ringkasan penjualan terbaru</small>
                </div>

                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <div class="card panel">
                <div class="panel-head">
                    <h3>Produk Terbaru</h3>
                    <small class="muted">Produk yang baru ditambahkan</small>
                </div>

                <?php if (empty($recentProducts)): ?>
                    <p class="muted">Belum ada produk. <a href="/admin/produk/tambah">Tambah produk</a></p>
                <?php else: ?>
                    <div class="table-wrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentProducts as $p): ?>
                                    <tr>
                                        <td class="thumb">
                                            <?php if (!empty($p['image'])): ?>
                                                <img src="/uploads/produk/<?= htmlspecialchars($p['image']); ?>"
                                                    alt="<?= htmlspecialchars($p['nama']); ?>">
                                            <?php else: ?>
                                                <div class="no-thumb">Tidak ada</div>
                                            <?php endif; ?>
                                        </td>
                                        <td><strong><?= htmlspecialchars($p['nama']); ?></strong><br><small
                                                class="muted"><?= htmlspecialchars($p['slug'] ?? '-'); ?></small></td>
                                        <td><?= htmlspecialchars($p['kategori'] ?? '-'); ?></td>
                                        <td class="center"><?= rupiah($p['harga'] ?? 0); ?></td>
                                        <td class="center"><?= intval($p['stok'] ?? 0); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <div class="card panel">
                <div class="panel-head">
                    <h3>Pesanan Terbaru</h3>
                    <small class="muted">Pesanan yang baru masuk</small>
                </div>

                <?php if (empty($orders)): ?>
                    <p class="muted">Belum ada pesanan.</p>
                <?php else: ?>
                    <div class="table-wrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No. Pesanan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($orders, 0, 3) as $ord): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($ord['order_id'] ?? $ord['id'] ?? '-'); ?></strong>
                                        </td>
                                        <td><?= rupiah($ord['total'] ?? $ord['grand_total'] ?? $ord['amount'] ?? 0); ?></td>
                                        <td>
                                            <span
                                                class="badge <?= ($ord['status'] ?? '') === 'completed' ? 'success' : 'warning'; ?>">
                                                <?= htmlspecialchars($ord['status'] ?? 'pending'); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="right column">
            <div class="card panel">
                <div class="panel-head">
                    <h3>Stok Rendah</h3>
                    <small class="muted">Produk yang perlu diisi ulang stoknya</small>
                </div>

                <?php if (empty($lowStock)): ?>
                    <p class="muted">Tidak ada produk dengan stok rendah.</p>
                <?php else: ?>
                    <ul class="list">
                        <?php foreach ($lowStock as $p): ?>
                            <li>
                                <div class="left">
                                    <strong><?= htmlspecialchars($p['nama']); ?></strong>
                                    <div class="muted"><?= htmlspecialchars($p['kategori'] ?? '-'); ?></div>
                                </div>
                                <div class="right">
                                    <span class="badge warning"><?= intval($p['stok']); ?></span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="card panel">
                <div class="panel-head">
                    <h3>Teratas (Rating)</h3>
                    <small class="muted">Produk dengan rating tertinggi</small>
                </div>

                <?php if (empty($topRated)): ?>
                    <p class="muted">Belum ada produk yang diberi rating.</p>
                <?php else: ?>
                    <ul class="list">
                        <?php foreach ($topRated as $p): ?>
                            <li>
                                <div class="left">
                                    <strong><?= htmlspecialchars($p['nama']); ?></strong>
                                    <div class="muted"><?= htmlspecialchars($p['kategori'] ?? '-'); ?></div>
                                </div>
                                <div class="right">
                                    <span class="badge success"><?= number_format((float)($p['rating'] ?? 0), 1); ?> ★</span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="card panel">
                <div class="panel-head">
                    <h3>Pengguna Terbaru</h3>
                    <small class="muted">Pengguna yang baru mendaftar</small>
                </div>

                <?php if (empty($users)): ?>
                    <p class="muted">Belum ada pengguna.</p>
                <?php else: ?>
                    <ul class="list small">
                        <?php foreach (array_slice($users, 0, 3) as $u): ?>
                            <li>
                                <div class="left">
                                    <strong><?= htmlspecialchars($u['full_name']); ?></strong>
                                    <div class="muted"><?= htmlspecialchars($u['email']); ?></div>
                                </div>
                                <div class="right">
                                    <span class="badge"><?= htmlspecialchars($u['role']); ?></span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    /* Gaya Dasbor (singkat dan responsif) */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 18px;
    }

    .dashboard-header h1 {
        margin: 0;
        font-size: 26px;
    }

    .muted {
        color: #bfc5d2;
        font-size: 13px;
    }

    .header-actions .btn {
        text-decoration: none;
        padding: 10px 14px;
        border-radius: 8px;
        display: inline-block;
    }

    .btn.primary {
        background: #ffdf3c;
        color: #000;
        font-weight: 600;
    }

    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 18px;
    }

    .kpi {
        padding: 18px;
        border-radius: 10px;
        background: #2f3a42;
    }

    .kpi-title {
        color: #ffdf3c;
        font-weight: 600;
        font-size: 13px;
    }

    .kpi-value {
        font-size: 22px;
        margin-top: 8px;
        font-weight: 700;
    }

    .kpi-sub {
        font-size: 12px;
        color: #bfc5d2;
        margin-top: 6px;
    }

    .panels {
        display: flex;
        gap: 16px;
    }

    .left {
        flex: 2;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .right {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .card.panel {
        padding: 16px;
        border-radius: 10px;
        background: #3a444e;
    }

    .panel-head {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 12px;
    }

    .table-wrap {
        overflow: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        color: #fff;
        font-size: 13px;
    }

    .table thead th {
        text-align: left;
        color: #ffdf3c;
        padding: 8px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .table tbody td {
        padding: 10px 8px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        vertical-align: middle;
    }

    .thumb img {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 6px;
    }

    .thumb .no-thumb {
        width: 48px;
        height: 48px;
        background: #2f3a42;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        border-radius: 6px;
    }

    .list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px;
        border-radius: 8px;
        background: rgba(0, 0, 0, 0.02);
    }

    .list.small li {
        font-size: 13px;
    }

    .left .muted {
        font-size: 12px;
        color: #bfc5d2;
    }

    .badge {
        padding: 6px 10px;
        border-radius: 12px;
        background: #444b52;
        color: #fff;
        font-weight: 600;
        font-size: 13px;
    }

    .badge.warning {
        background: #ff8a65;
        color: #000;
    }

    .badge.success {
        background: #ffdf3c;
        color: #000;
    }

    /* Kontainer chart: batasi tinggi agar tidak memanjang */
    .chart-container {
        width: 100%;
        max-height: 280px;
        height: 220px;
        overflow: hidden;
    }

    .chart-container canvas {
        width: 100%;
        height: 100% !important;
        display: block;
    }

    /* responsif */
    @media(max-width:1000px) {
        .kpi-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .panels {
            flex-direction: column;
        }
    }
</style>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = <?= json_encode(array_values($chartLabels)); ?>;
    const dataPoints = <?= json_encode(array_values($sales)); ?>;

    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Penjualan',
                data: dataPoints,
                borderColor: '#ffdf3c',
                backgroundColor: 'rgba(255,223,60,0.08)',
                fill: true,
                tension: 0.3,
                pointRadius: 2
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#bfc5d2'
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(255,255,255,0.03)'
                    },
                    ticks: {
                        color: '#bfc5d2'
                    }
                }
            },
            maintainAspectRatio: false
        }
    });
</script>

<?= $this->endSection(); ?>