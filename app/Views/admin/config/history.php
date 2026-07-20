<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des modifications</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>

<div class="container mt-4">
    <h2>Historique des modifications</h2>
    
    <div class="mb-3">
        <a href="<?= base_url('admin/config') ?>" class="btn btn-secondary">Retour</a>
    </div>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID Config</th>
                <th>Opérateur</th>
                <th>Type</th>
                <th>Tranche</th>
                <th>Frais</th>
                <th>Action</th>
                <th>Modifié par</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($history) && count($history) > 0): ?>
                <?php foreach ($history as $item): ?>
                    <tr>
                        <td><?= $item['idConfigFrais'] ?></td>
                        <td><?= $item['operator_name'] ?? 'N/A' ?></td>
                        <td><?= $item['transaction_type'] ?? 'N/A' ?></td>
                        <td><?= number_format($item['minAmount']) ?> - <?= number_format($item['maxAmount']) ?> Ar</td>
                        <td><strong><?= number_format($item['frais']) ?> Ar</strong></td>
                        <td>
                            <span class="badge <?= $item['action'] == 'CREATE' ? 'bg-success' : ($item['action'] == 'UPDATE' ? 'bg-warning' : 'bg-danger') ?>">
                                <?= $item['action'] ?>
                            </span>
                        </td>
                        <td><?= $item['user_name'] ?? 'N/A' ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($item['change_date'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Aucun historique</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>