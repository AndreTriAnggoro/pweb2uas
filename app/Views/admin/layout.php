<?php
// app/Views/admin/layout.php
$uri = service('uri');
$seg2 = $uri->getSegment(2) ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Bangun Bangsa</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            background: #2c3440;
            color: #fff;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background: #1f2732;
            height: 100vh;
            position: fixed;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar .logo img {
            width: 60px;
        }

        .sidebar a {
            padding: 15px 25px;
            color: #bfc5d2;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            transition: .2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #ffdf3c;
            color: #000;
            font-weight: 600;
        }

        .main {
            margin-left: 250px;
            width: calc(100% - 250px);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            height: 60px;
            background: #1f2732;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .navbar .title {
            font-size: 20px;
            font-weight: 600;
        }

        .navbar .user {
            display: flex;
            gap: 10px;
            align-items: center;
            color: #ffdf3c;
        }

        .content {
            padding: 30px;
        }

        footer {
            text-align: center;
            padding: 15px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 12px;
            margin-top: auto;
        }

        .card {
            background: #3a444e;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .user-menu {
            position: relative;
            cursor: pointer;
        }

        .user-menu .user-name {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #ffdf3c;
            font-weight: 500;
        }

        .dropdown {
            position: absolute;
            top: 45px;
            right: 0;
            background: #2c3440;
            width: 180px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
            display: none;
            animation: fadeIn 0.2s ease;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .dropdown a {
            display: block;
            padding: 12px 18px;
            color: #fff;
            font-size: 14px;
            text-decoration: none;
            transition: 0.2s;
        }

        .dropdown a:hover {
            background: #ffdf3c;
            color: #000;
            font-weight: 600;
        }

        .user-menu.active .dropdown {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo">
            <img src="<?= base_url('assets/img/logo.svg'); ?>" alt="Logo">
        </div>

        <a href="/admin/index" class="<?= ($seg2 === 'index' ? 'active' : '') ?>"><i class="fa-solid fa-gauge"></i>
            Dashboard</a>
        <a href="/admin/produk" class="<?= ($seg2 === 'produk' ? 'active' : '') ?>"><i class="fa-solid fa-box"></i>
            Products</a>
        <a href="/admin/orders" class="<?= ($seg2 === 'orders' ? 'active' : '') ?>"><i
                class="fa-solid fa-cart-shopping"></i> Orders</a>
        <a href="/admin/users" class="<?= ($seg2 === 'users' ? 'active' : '') ?>"><i class="fa-solid fa-users"></i>
            Users</a>
    </div>

    <div class="main">
        <div class="navbar">
            <div class="title">Admin Bangun Bangsa</div>

            <div class="user-menu" onclick="toggleMenu()">
                <div class="user-name">
                    <i class="fa-solid fa-user-circle"></i>
                    <?= session()->get('full_name'); ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div>

                <div class="dropdown">
                    <a href="/logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                </div>
            </div>
        </div>

        <div class="content">
            <?= $this->renderSection('content'); ?>
        </div>

    </div>

    <script>
        function toggleMenu() {
            document.querySelector('.user-menu').classList.toggle('active');
        }

        document.addEventListener("click", function(e) {
            const menu = document.querySelector(".user-menu");
            if (!menu.contains(e.target)) {
                menu.classList.remove("active");
            }
        });
    </script>

</body>

</html>