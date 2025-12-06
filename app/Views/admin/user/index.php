<?= $this->extend('admin/layout'); ?>
<?= $this->section('content'); ?>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
        <h2 style="margin:0;">Users</h2>
        <a href="/admin/users/tambah"
            style="background:#ffdf3c;padding:10px 15px;border-radius:8px;color:#000;font-weight:600;text-decoration:none;">
            + Add User
        </a>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
    <div style="background:#4caf50;color:#fff;padding:12px;border-radius:8px;margin-bottom:12px;">
        <?= session()->getFlashdata('success'); ?>
    </div>
    <?php endif; ?>

    <?php if(empty($users)): ?>
    <div style="text-align:center;color:#999;padding:30px;">Belum ada user.</div>
    <?php else: ?>
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#1f2732;color:#ffdf3c;">
                <th style="padding:12px;text-align:left;">Nama</th>
                <th style="padding:12px;text-align:left;">Email</th>
                <th style="padding:12px;text-align:left;">Role</th>
                <th style="padding:12px;text-align:center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $u): ?>
            <tr style="border-bottom:1px solid rgba(255,255,255,0.06);">
                <td style="padding:12px;"><?= htmlspecialchars($u['full_name']); ?></td>
                <td style="padding:12px;"><?= htmlspecialchars($u['email']); ?></td>
                <td style="padding:12px;"><?= htmlspecialchars($u['role']); ?></td>
                <td style="padding:12px;text-align:center;">
                    <a href="/admin/users/ubah/<?= $u['user_id']; ?>"
                        style="color:#ffdf3c;margin-right:8px;text-decoration:none;">✎ Edit</a>
                    <a href="/admin/users/delete/<?= $u['user_id']; ?>"
                        onclick="return confirm('Yakin hapus user ini?')" style="color:#ff6b6b;text-decoration:none;">✕
                        Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>