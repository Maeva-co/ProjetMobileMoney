<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des opérateurs</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>

<div class="container mt-4">
    <h2>Gestion des opérateurs (préfixes)</h2>
    
    <div class="mb-3">
        <a href="<?= base_url('/admin/operators/create') ?>" class="btn btn-primary">+ Ajouter un opérateur</a>
        <a href="<?= base_url('/admin/dashboard') ?>" class="btn btn-secondary">Retour dashboard</a>
    </div>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Préfixe</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($operators) && count($operators) > 0): ?>
                <?php foreach ($operators as $operator): ?>
                    <tr>
                        <td><?= $operator['id'] ?></td>
                        <td><?= $operator['name'] ?></td>
                        <td><strong><?= $operator['type'] ?></strong></td>
                        <td>
                            <a href="<?= base_url('/admin/operators/edit/' . $operator['id']) ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="<?= base_url('/admin/operators/delete/' . $operator['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Aucun opérateur</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>