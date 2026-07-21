<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administration</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboardAdmin.css') ?>">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">

</head>

<body>
    <!-- SIDEBAR -->
    <nav class="sidebar">
        <div class="sidebar-brand">
            <h3>
                <span>MobileMoney</span>
            </h3>
            <small>Administration</small>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="<?= base_url('admin/dashboard') ?>">
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/clients">
                    Comptes clients
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/gains">
                    Gains (situation)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/config') ?>">
                    <span>Configuration frais</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/operators') ?>">
                    <span>Opérateurs</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/transaction-types">
                    Types d'opérations
                </a>
            </li>
            <li class="nav-divider"></li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('logout') ?>">
                    <span>Déconnexion</span>
                </a>
            </li>
        </ul>
    </nav>


    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- Top Bar -->
        <div class="top-bar">
            <h2>
                Tableau de bord
            </h2>
            <div class="top-bar-right">
                <span class="date">
                    <?= date('d/m/Y H:i') ?>
                </span>
                <span class="badge-admin">
                    Admin
                </span>
            </div>
        </div>
        <!-- STATISTICS CARDS -->
        <div class="row g-4 mb-4">

            <!-- Clients -->
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card">

                    <div class="stat-label">Clients</div>
                    <div class="stat-number"><?= number_format($totalClients ?? 0) ?></div>
                </div>
            </div>

            <!-- Transactions -->
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card">
                    <div class="stat-label">Transactions</div>
                    <div class="stat-number"><?= number_format($totalTransactions ?? 0) ?></div>
                </div>
            </div>

            <!-- Revenus -->
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card">
                    <div class="stat-label">Revenus</div>
                    <div class="stat-number"><?= number_format($totalRevenue ?? 0) ?> Ar</div>
                </div>
            </div>

        </div>

        <!-- RECENT TRANSACTIONS -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="table-container">
                    <div class="table-header">
                        <h5>
                            Dernières transactions
                        </h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Client</th>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Frais</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recentTransactions) && count($recentTransactions) > 0): ?>
                                    <?php foreach ($recentTransactions as $transaction): ?>
                                        <tr>
                                            <td><strong>#<?= $transaction['id'] ?></strong></td>
                                            <td>
                                                <?= $transaction['client_name'] ?? 'Client' ?>
                                                <br>
                                                <small class="text-muted"><?= $transaction['client_number'] ?? '' ?></small>
                                            </td>
                                            <td>
                                                <?php
                                                $typeName = $transaction['transaction_type_name'] ?? '';
                                                $badgeClass = 'badge-deposit';
                                                if ($typeName == 'Withdrawal') $badgeClass = 'badge-withdrawal';
                                                elseif ($typeName == 'Transfer') $badgeClass = 'badge-transfer';
                                                ?>
                                                <span class="badge <?= $badgeClass ?>">
                                                    <?= $typeName ?: 'Inconnu' ?>
                                                </span>
                                            </td>
                                            <td><strong><?= number_format($transaction['amount']) ?> Ar</strong></td>
                                            <td><?= number_format($transaction['frais'] ?? 0) ?> Ar</td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= date('d/m/Y H:i', strtotime($transaction['transaction_date'])) ?>
                                                </small>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            Aucune transaction récente
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- RECENT CLIENTS & CONFIG -->
        <div class="row g-4">

            <!-- Recent Clients -->
            <div class="col-xl-6 col-lg-6">
                <div class="client-list">
                    <div class="list-header">
                        <h5>
                            Nouveaux clients
                        </h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php if (!empty($recentClients) && count($recentClients) > 0): ?>
                            <?php foreach ($recentClients as $client): ?>
                                <div class="list-group-item">
                                    <div class="client-info">
                                        <div class="avatar">
                                            <?= strtoupper(substr($client['name'] ?? 'C', 0, 1)) ?>
                                        </div>
                                        <div class="client-details">
                                            <span class="client-name"><?= $client['name'] ?? 'Client' ?></span>
                                            <span class="client-number">
                                                <?= $client['number'] ?>
                                            </span>
                                        </div>
                                    </div>
                                    <span class="client-date">
                                        <?= date('d/m/Y', strtotime($client['created_at'] ?? 'now')) ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="list-group-item text-center text-muted py-4">
                                Aucun nouveau client
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Configuration -->
            <div class="col-xl-6 col-lg-6">
                <div class="config-card">
                    <div class="config-header">
                        <h5>
                            Configuration des frais
                        </h5>
                    </div>
                    <div>
                        <?php if (!empty($activeConfigs) && count($activeConfigs) > 0): ?>
                            <?php
                            $displayed = array_slice($activeConfigs, 0, 5);
                            $typeNames = ['Dépôt', 'Retrait', 'Transfert'];
                            foreach ($displayed as $config):
                            ?>
                                <div class="config-item">
                                    <div class="config-info">
                                        <span class="config-operator">
                                            <?php
                                            $opName = $config['operator_name'];
                                            echo $opName ?: 'N/A';
                                            ?>
                                        </span>
                                        <span class="config-detail">
                                            <?= $typeNames[$config['transaction_type_id'] - 1] ?? 'N/A' ?>
                                            • <?= number_format($config['minAmount']) ?> - <?= number_format($config['maxAmount']) ?> Ar
                                        </span>
                                    </div>
                                    <span class="config-frais">
                                        <?= number_format($config['frais']) ?> Ar
                                    </span>
                                </div>
                            <?php endforeach; ?>
                            <?php if (count($activeConfigs) > 5): ?>
                                <div class="config-item text-center text-muted">
                                    <small>Et <?= count($activeConfigs) - 5 ?> autres configurations...</small>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="text-center text-muted py-4">
                                Aucune configuration active
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="text-center p-3 border-top">
                        <a href="/admin/config" class="btn btn-outline-primary btn-sm">
                            Gérer les frais
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Bootstrap JS -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>

</body>

</html>