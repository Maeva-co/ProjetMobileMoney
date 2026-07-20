<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Types d'opérations</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>

<div class="container mt-4">
    <h2>Types d'opérations</h2>
    
    <div class="mb-3">
        <a href="<?= base_url('admin/transaction-types/create') ?>" class="btn btn-primary">+ Ajouter un type</a>
        <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">Retour dashboard</a>
    </div>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type d'opération</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($types) && count($types) > 0): ?>
                <?php foreach ($types as $type): ?>
                    <tr>
                        <td><?= $type['id'] ?></td>
                        <td><strong><?= $type['type'] ?></strong></td>
                        <td>
                            <a href="<?= base_url('admin/transaction-types/edit/' . $type['id']) ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="<?= base_url('admin/transaction-types/delete/' . $type['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce type ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">Aucun type d'opération</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>