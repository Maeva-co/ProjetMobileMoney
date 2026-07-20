<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Situation des gains</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <style>
        .gain-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.2s;
        }
        .gain-card:hover {
            transform: translateY(-5px);
        }
        .gain-number {
            font-size: 2rem;
            font-weight: bold;
            color: #1a237e;
        }
        .gain-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .gain-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .gain-card.total .gain-icon { color: #1a237e; }
        .gain-card.today .gain-icon { color: #28a745; }
        .gain-card.month .gain-icon { color: #ffc107; }
        .gain-card.year .gain-icon { color: #dc3545; }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2>Situation des gains</h2>
    
    <div class="mb-3">
        <a href="/admin/dashboard" class="btn btn-secondary">Retour dashboard</a>
    </div>
    
    <!-- CARTES DES GAINS                          -->
    <div class="row g-4 mb-4">
        
        <div class="col-md-3">
            <div class="gain-card total">
                <div class="gain-label">Gains totaux</div>
                <div class="gain-number"><?= number_format($totalGains ?? 0) ?> Ar</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="gain-card today">
                <div class="gain-label">Gains du jour</div>
                <div class="gain-number"><?= number_format($todayGains ?? 0) ?> Ar</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="gain-card month">
                <div class="gain-label">Gains du mois</div>
                <div class="gain-number"><?= number_format($monthGains ?? 0) ?> Ar</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="gain-card year">
                <div class="gain-label">Gains de l'année</div>
                <div class="gain-number"><?= number_format($yearGains ?? 0) ?> Ar</div>
            </div>
        </div>
        
    </div>
    
    <!-- GAINS PAR OPÉRATEUR                       -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Gains par opérateur</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($gainsByOperator) && count($gainsByOperator) > 0): ?>
                        <?php foreach ($gainsByOperator as $item): ?>
                            <?php 
                                $opName = '';
                                foreach ($operators ?? [] as $op) {
                                    if ($op['id'] == $item['operator_type_id']) {
                                        $opName = $op['name'];
                                        break;
                                    }
                                }
                            ?>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><strong><?= $opName ?: 'N/A' ?></strong></span>
                                <span><?= number_format($item['total_fees'] ?? 0) ?> Ar</span>
                            </div>
                            <div class="progress mb-3">
                                <div class="progress-bar bg-primary" 
                                     style="width: <?= $totalGains > 0 ? ($item['total_fees'] / $totalGains * 100) : 0 ?>%">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-muted">Aucune donnée</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        

        <!-- GAINS PAR TYPE                            -->

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Gains par type</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($gainsByType) && count($gainsByType) > 0): ?>
                        <?php 
                            $typeNames = ['Dépôt', 'Retrait', 'Transfert'];
                            foreach ($gainsByType as $item): 
                        ?>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><strong><?= $typeNames[$item['transaction_type_id'] - 1] ?? 'N/A' ?></strong></span>
                                <span><?= number_format($item['total_fees'] ?? 0) ?> Ar</span>
                            </div>
                            <div class="progress mb-3">
                                <div class="progress-bar bg-success" 
                                     style="width: <?= $totalGains > 0 ? ($item['total_fees'] / $totalGains * 100) : 0 ?>%">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-muted">Aucune donnée</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ÉVOLUTION MENSUELLE                       -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Évolution mensuelle des gains</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($monthlyGains) && count($monthlyGains) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Mois</th>
                                <th>Transactions</th>
                                <th>Gains (Ar)</th>
                                <th>Évolution</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $previousGains = null;
                                foreach ($monthlyGains as $item): 
                                    $evolution = '';
                                    $evolutionClass = '';
                                    if ($previousGains !== null && $previousGains > 0) {
                                        $diff = $item['gains'] - $previousGains;
                                        $percent = ($diff / $previousGains) * 100;
                                        if ($percent > 0) {
                                            $evolution = '↑ +' . number_format($percent, 1) . '%';
                                            $evolutionClass = 'text-success';
                                        } elseif ($percent < 0) {
                                            $evolution = '↓ ' . number_format($percent, 1) . '%';
                                            $evolutionClass = 'text-danger';
                                        } else {
                                            $evolution = '→ 0%';
                                            $evolutionClass = 'text-muted';
                                        }
                                    }
                                    $previousGains = $item['gains'];
                            ?>
                                <tr>
                                    <td><strong><?= $item['month_label'] ?></strong></td>
                                    <td><?= $item['count'] ?></td>
                                    <td><strong><?= number_format($item['gains']) ?> Ar</strong></td>
                                    <td class="<?= $evolutionClass ?>"><?= $evolution ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">Aucune donnée disponible</p>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>