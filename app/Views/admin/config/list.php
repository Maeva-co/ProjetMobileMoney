<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration des frais</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>

<div class="container mt-4">
    <h2>Configuration des frais</h2>
    
    <div class="mb-3">
        <a href="<?= base_url('admin/config/create') ?>" class="btn btn-primary">+ Ajouter une tranche</a>
        <a href="<?= base_url('admin/config/history') ?>" class="btn btn-info">Historique des modifications</a>
        <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">Retour dashboard</a>
    </div>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Opérateur</th>
                <th>Type</th>
                <th>Montant min</th>
                <th>Montant max</th>
                <th>Frais</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($configs) && count($configs) > 0): ?>
                <?php foreach ($configs as $config): ?>
                    <tr>
                        <td><?= $config['id'] ?></td>
                        <td><?= $config['operator_name'] ?? 'N/A' ?></td>
                        <td><?= $config['transaction_type'] ?? 'N/A' ?></td>
                        <td><?= number_format($config['minAmount']) ?> Ar</td>
                        <td><?= number_format($config['maxAmount']) ?> Ar</td>
                        <td><strong><?= number_format($config['frais']) ?> Ar</strong></td>
                        <td>
                            <span class="badge <?= $config['isActive'] ? 'bg-success' : 'bg-danger' ?>">
                                <?= $config['isActive'] ? 'Actif' : 'Inactif' ?>
                            </span>
                        </td>
                        <td>
                            <a href="/admin/config/edit/<?= $config['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="/admin/config/delete/<?= $config['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Désactiver ?')">Désactiver</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Aucune configuration</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>