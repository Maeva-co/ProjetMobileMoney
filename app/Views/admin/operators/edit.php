<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'opérateur</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>

<div class="container mt-4">
    <h2>Modifier l'opérateur</h2>
    
    <div class="mb-3">
        <a href="<?= base_url('/admin/operators') ?>" class="btn btn-secondary">Retour</a>
    </div>
    
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('errors') ?></div>
    <?php endif; ?>
    
    <form method="post" action="<?= base_url('/admin/operators/update/' . $operator['id']) ?>">
        <div class="mb-3">
            <label>Nom de l'opérateur</label>
            <input type="text" name="name" class="form-control" value="<?= $operator['name'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Préfixe (type)</label>
            <input type="text" name="type" class="form-control" value="<?= $operator['type'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>

</body>
</html>