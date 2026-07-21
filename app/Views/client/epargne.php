<?= $this->extend('layouts/client') ?>

    <?= $this->section('title') ?>
        Dépôt
    <?= $this->endSection() ?>

<?= $this->section('content') ?>

    <h1>Configuration epargne</h1>
    <p>
        Gerer le pourcentage de votre epargne
    </p>


    <?php if(session()->getFlashdata('error')) { ?>

    <div style="background:#ffdddd; padding:15px; border-radius:10px; color:#b30000; margin-bottom:20px;">

    <?= session()->getFlashdata('error') ?>

    </div>

    <?php } ?>

    <form method="post" action="<?= site_url('client/depot') ?>">
        <?= csrf_field() ?>

        <label> Votre pourcentage</label>

        <input type="number" name="epargne" max=100 placeholder="Exemple : 50" value="<?= $epargne ?>"
            style="width:100%; padding:15px; border-radius:10px; border:1px solid #ddd; font-size:16px; margin-top:10px;">

        <?php if(session()->getFlashdata('errors')) {  ?>
            <?php foreach(session()->getFlashdata('errors') as $error) { ?>
                <div style="color:red;margin-top:10px;">
                    <?= $error ?>
                </div>
            <?php } ?>
        <?php } ?>

        <button style="margin-top:25px; background:#1565C0; color:white; border:none; padding:15px 30px; border-radius:10px; font-size:16px; cursor:pointer;">
            Valider la configuration
        </button>

    </form>

<?= $this->endSection() ?>
