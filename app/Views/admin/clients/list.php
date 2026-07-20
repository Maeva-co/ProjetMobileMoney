<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Situation des comptes clients</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>

<div class="container mt-4">
    <h2>Situation des comptes clients</h2>
    
    <div class="mb-3">
        <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">Retour dashboard</a>
    </div>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    
    <!-- Statistiques -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total clients</h5>
                    <h2><?= $totalClients ?? 0 ?></h2>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Liste des clients -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Liste des clients</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Numéro</th>
                            <th>Solde</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($clients) && count($clients) > 0): ?>
                            <?php foreach ($clients as $client): ?>
                                <tr>
                                    <td><?= $client['id'] ?></td>
                                    <td><?= $client['name'] ?? 'Client' ?></td>
                                    <td><?= $client['number'] ?></td>
                                    <td>
                                        <strong class="<?= ($client['solde'] ?? 0) >= 0 ? 'text-success' : 'text-danger' ?>">
                                            <?= number_format($client['solde'] ?? 0) ?> Ar
                                        </strong>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/clients') ?>/<?= $client['id'] ?>" class="btn btn-info btn-sm">
                                            Voir détails
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Aucun client
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