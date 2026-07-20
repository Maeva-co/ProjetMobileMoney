<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du client</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>

<div class="container mt-4">
    
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Détails du client</h2>
        <div>
            <a href="<?= base_url('admin/clients') ?>" class="btn btn-secondary">Retour à la liste</a>
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">Dashboard</a>
        </div>
    </div>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    
    <!-- Informations client -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informations personnelles</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>ID</th>
                            <td><?= $client['id'] ?></td>
                        </tr>
                        <tr>
                            <th>Nom</th>
                            <td><?= $client['name'] ?? 'Non renseigné' ?></td>
                        </tr>
                        <tr>
                            <th>Numéro</th>
                            <td><strong><?= $client['number'] ?></strong></td>
                        </tr>
                        <tr>
                            <th>Rôle</th>
                            <td><span class="badge bg-info"><?= $client['role'] ?></span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Solde</h5>
                </div>
                <div class="card-body text-center">
                    <h2 class="<?= $solde >= 0 ? 'text-success' : 'text-danger' ?>">
                        <?= number_format($solde) ?> Ar
                    </h2>
                    <small class="text-muted">Total transactions : <?= $totalTransactions ?? 0 ?></small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Transactions du client -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Historique des transactions</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Opérateur</th>
                            <th>Montant</th>
                            <th>Frais</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($transactions) && count($transactions) > 0): ?>
                            <?php foreach ($transactions as $transaction): ?>
                                <tr>
                                    <td>#<?= $transaction['id'] ?></td>
                                    <td>
                                        <span class="badge <?= $transaction['transaction_type_name'] == 'Deposit' ? 'bg-success' : ($transaction['transaction_type_name'] == 'Withdrawal' ? 'bg-danger' : 'bg-primary') ?>">
                                            <?= $transaction['transaction_type_name'] ?? 'N/A' ?>
                                        </span>
                                    </td>
                                    <td><?= $transaction['operator_name'] ?? 'N/A' ?></td>
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
                                    Aucune transaction
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Mouvements de solde -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Mouvements de solde</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Montant</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($movements) && count($movements) > 0): ?>
                            <?php foreach ($movements as $movement): ?>
                                <tr>
                                    <td><?= $movement['id'] ?></td>
                                    <td>
                                        <span class="badge <?= $movement['type'] == 'credit' ? 'bg-success' : 'bg-danger' ?>">
                                            <?= ucfirst($movement['type']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong class="<?= $movement['type'] == 'credit' ? 'text-success' : 'text-danger' ?>">
                                            <?= $movement['type'] == 'credit' ? '+' : '-' ?>
                                            <?= number_format($movement['amount']) ?> Ar
                                        </strong>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?= date('d/m/Y H:i', strtotime($movement['movement_date'])) ?>
                                        </small>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Aucun mouvement
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>