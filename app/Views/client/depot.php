<?= $this->extend('layouts/client') ?>

    <?= $this->section('title') ?>
        Dépôt
    <?= $this->endSection() ?>

<?= $this->section('content') ?>

    <h1>Faire un dépôt</h1>
    <p>
        Ajoutez de l'argent sur votre portefeuille Mobile Money.
    </p>


    <?php if(session()->getFlashdata('error')) { ?>

    <div style="background:#ffdddd; padding:15px; border-radius:10px; color:#b30000; margin-bottom:20px;">

    <?= session()->getFlashdata('error') ?>

    </div>

    <?php } ?>

    <form method="post" action="<?= site_url('client/depot') ?>">
        <?= csrf_field() ?>

        <label> Montant (Ar) </label>

        <input type="number" name="amount" placeholder="Exemple : 10000" value="<?= old('amount') ?>"
            style="width:100%; padding:15px; border-radius:10px; border:1px solid #ddd; font-size:16px; margin-top:10px;">

        <?php if(session()->getFlashdata('errors')) {  ?>
            <?php foreach(session()->getFlashdata('errors') as $error) { ?>
                <div style="color:red;margin-top:10px;">
                    <?= $error ?>
                </div>
            <?php } ?>
        <?php } ?>

        <button style="margin-top:25px; background:#1565C0; color:white; border:none; padding:15px 30px; border-radius:10px; font-size:16px; cursor:pointer;">
            Valider le dépôt
        </button>

    </form>

<?= $this->endSection() ?>
