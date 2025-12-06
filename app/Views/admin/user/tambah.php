<?= $this->extend('admin/layout'); ?>
<?= $this->section('content'); ?>

<div class="card">
    <h2 style="margin-top:0;">Add New User</h2>

    <form action="/admin/users/simpan" method="post" style="max-width:600px;">
        <?= csrf_field(); ?>

        <div style="margin-bottom:12px;">
            <label style="color:#ffdf3c;">Full Name</label>
            <input type="text" name="full_name" value="<?= old('full_name'); ?>" class="input"
                style="width:100%;padding:10px;margin-top:6px;background:#2c3440;border:1px solid rgba(255,255,255,0.08);color:#fff;border-radius:6px;">
            <small style="color:#ff6b6b;"><?= isset($validation) ? $validation->getError('full_name') : ''; ?></small>
        </div>

        <div style="margin-bottom:12px;">
            <label style="color:#ffdf3c;">Email</label>
            <input type="email" name="email" value="<?= old('email'); ?>" class="input"
                style="width:100%;padding:10px;margin-top:6px;background:#2c3440;border:1px solid rgba(255,255,255,0.08);color:#fff;border-radius:6px;">
            <small style="color:#ff6b6b;"><?= isset($validation) ? $validation->getError('email') : ''; ?></small>
        </div>

        <div style="margin-bottom:12px;">
            <label style="color:#ffdf3c;">Password</label>
            <input type="password" name="password" class="input"
                style="width:100%;padding:10px;margin-top:6px;background:#2c3440;border:1px solid rgba(255,255,255,0.08);color:#fff;border-radius:6px;">
            <small style="color:#ff6b6b;"><?= isset($validation) ? $validation->getError('password') : ''; ?></small>
        </div>

        <div style="margin-bottom:12px;">
            <label style="color:#ffdf3c;">Role</label>
            <select name="role" class="input"
                style="width:100%;padding:10px;margin-top:6px;background:#2c3440;border:1px solid rgba(255,255,255,0.08);color:#fff;border-radius:6px;">
                <option value="customer" <?= old('role') === 'customer' ? 'selected' : ''; ?>>Customer</option>
                <option value="admin" <?= old('role') === 'admin' ? 'selected' : ''; ?>>Admin</option>
            </select>
            <small style="color:#ff6b6b;"><?= isset($validation) ? $validation->getError('role') : ''; ?></small>
        </div>

        <div style="text-align:right;">
            <a href="/admin/users"
                style="margin-right:8px;color:#fff;background:#666;padding:10px 14px;border-radius:6px;text-decoration:none;">Batal</a>
            <button type="submit"
                style="background:#ffdf3c;color:#000;padding:10px 16px;border-radius:6px;border:none;font-weight:600;">Simpan</button>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>