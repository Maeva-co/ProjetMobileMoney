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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

        .gain-card.total .gain-icon {
            color: #1a237e;
        }

        .gain-card.today .gain-icon {
            color: #28a745;
        }

        .gain-card.month .gain-icon {
            color: #ffc107;
        }

        .gain-card.year .gain-icon {
            color: #dc3545;
        }
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
                        <h5 class="mb-0">Gains opérateur</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($gainsOperator) && count($gainsOperator) > 0): ?>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><strong><?= $gainsOperator['name'] ?: 'N/A' ?></strong></span>
                                <span><?= number_format($gainsOperator['total_gains'] ?? 0) ?> Ar</span>
                            </div>
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
                        <h5 class="mb-0">Gains autres opérateurs</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($gainsTotalOtherOperators) && count($gainsTotalOtherOperators) > 0): ?>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><strong>Autres opérateurs</strong></span>
                                <span><?= number_format($gainsTotalOtherOperators['total_gains'] ?? 0) ?> Ar</span>
                            </div>
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
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Operateur</th>
                                <th>Gains (Ar)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($operators as $operator): ?>
                                <tr>
                                    <td><strong><?= $operator['name'] ?></strong></td>
                                    <td><strong><?= number_format($gainsOperator['total_gains'] ?? 0) ?> Ar</strong></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>