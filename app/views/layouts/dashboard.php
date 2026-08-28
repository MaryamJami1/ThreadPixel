<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard — ThreadPixel' ?></title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/assets/images/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <style>
        .dashboard-header {
            background-color: var(--secondary-bg);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background-color: var(--secondary-bg);
            padding: 1.5rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-text);
            margin-top: 0.5rem;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th, .data-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        .badge {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .badge-pending { background: rgba(245, 158, 11, 0.2); color: var(--warning); }
        .badge-success { background: rgba(16, 185, 129, 0.2); color: var(--success); }
        .badge-primary { background: rgba(37, 99, 235, 0.2); color: var(--accent-blue); }
    </style>
</head>
<body>

    <header class="dashboard-header">
        <a href="<?= BASE_URL ?>/" class="navbar-brand"><img src="<?= BASE_URL ?>/assets/images/logo.png" alt="ThreadPixel Digitizing logo"></a>
        <div>
            <span style="margin-right: 15px;">Welcome, <?= Session::userName() ?></span>
            <a href="<?= BASE_URL ?>/auth/logout" class="btn btn-outline" style="padding: 0.4rem 1rem;">Logout</a>
        </div>
    </header>

    <div class="dashboard-layout">
        <aside class="sidebar">
            <ul class="sidebar-nav">
                <?php if (Session::isAdmin()): ?>
                    <li><a href="<?= BASE_URL ?>/admin">Dashboard</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/quotes">Quotes</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/orders">Orders</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/messages">Messages</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/customers">Customers</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/portfolio">Portfolio</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/services">Services & Pricing</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/faqs">FAQs</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/settings">Settings</a></li>
                <?php else: ?>
                    <li><a href="<?= BASE_URL ?>/dashboard">Dashboard</a></li>
                    <li><a href="<?= BASE_URL ?>/dashboard/quotes">My Quotes</a></li>
                    <li><a href="<?= BASE_URL ?>/dashboard/orders">My Orders</a></li>
                    <li><a href="<?= BASE_URL ?>/dashboard/files">My Files</a></li>
                    <li><a href="<?= BASE_URL ?>/dashboard/messages">Messages</a></li>
                    <li><a href="<?= BASE_URL ?>/dashboard/profile">Profile</a></li>
                <?php endif; ?>
            </ul>
        </aside>

        <main class="dashboard-content">
            <?php if (Session::hasFlash('success')): ?>
                <div class="alert alert-success"><?= Session::getFlash('success') ?></div>
            <?php endif; ?>
            <?php if (Session::hasFlash('error')): ?>
                <div class="alert alert-error"><?= Session::getFlash('error') ?></div>
            <?php endif; ?>

            <?= $viewContent ?>
        </main>
    </div>

    <script src="<?= BASE_URL ?>/assets/js/main.js"></script>
</body>
</html>
