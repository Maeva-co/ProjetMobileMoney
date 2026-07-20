<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un type d'opération</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>

<div class="container mt-4">
    <h2>Ajouter un type d'opération</h2>
    
    <div class="mb-3">
        <a href="<?= base_url('admin/transaction-types') ?>" class="btn btn-secondary">Retour</a>
    </div>
    
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('errors') ?></div>
    <?php endif; ?>
    
    <form method="post" action="<?= base_url('admin/transaction-types/store') ?>">
        <div class="mb-3">
            <label>Type d'opération</label>
            <input type="text" name="type" class="form-control" placeholder="Ex: Dépôt, Retrait, Transfert" required>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>

</body>
</html>