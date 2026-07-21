<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la tranche de frais</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>

<div class="container mt-4">
    <h2>Modifier la tranche de frais</h2>
    
    <div class="mb-3">
        <a href="<?= base_url('admin/config') ?>" class="btn btn-secondary">Retour</a>
    </div>
    
    <form method="post" action="<?= base_url('admin/config/update/' . $config['id']) ?>">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Opérateur</label>
                    <select name="operator_type_id" class="form-control" required>
                        <?php foreach ($operators as $operator): ?>
                            <option value="<?= $operator['id'] ?>" <?= $operator['id'] == $config['operator_type_id'] ? 'selected' : '' ?>>
                                <?= $operator['name'] ?> (<?= $operator['type'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Type d'opération</label>
                    <select name="transaction_type_id" class="form-control" required>
                        <?php foreach ($types as $type): ?>
                            <option value="<?= $type['id'] ?>" <?= $type['id'] == $config['transaction_type_id'] ? 'selected' : '' ?>>
                                <?= $type['type'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label>Montant minimum (Ar)</label>
                    <input type="number" name="minAmount" class="form-control" value="<?= $config['minAmount'] ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label>Montant maximum (Ar)</label>
                    <input type="number" name="maxAmount" class="form-control" value="<?= $config['maxAmount'] ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label>Frais (Ar)</label>
                    <input type="number" name="frais" class="form-control" value="<?= $config['frais'] ?>" required>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>



</body>
</html>