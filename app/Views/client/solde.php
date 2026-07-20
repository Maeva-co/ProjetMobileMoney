<?= $this->extend('layouts/client') ?>

    <?= $this->section('title') ?>
        Solde
    <?= $this->endSection() ?>

    <?= $this->section('content') ?>

        <h1>Bienvenue !</h1>
        <p>
            Consultez le montant actuellement disponible sur votre portefeuille Mobile Money.
        </p>
        <div style="margin-top:60px;text-align:center;">
            <div style="font-size:16px;color:#888;margin-bottom:10px;">
                Solde disponible
            </div>
            <div style="font-size:56px;font-weight:bold;color:#1565C0;">
                <?= number_format($solde, 2, ',', ' ') ?> Ar
            </div>

        </div>

    <?= $this->endSection() ?>
