<?= $this->extend('layouts/client') ?>

<?= $this->section('title') ?>
Retrait
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <h1>Faire un retrait</h1>

    <p>
        Retirez de l'argent depuis votre portefeuille Mobile Money.
    </p>



    <?php if(session()->getFlashdata('error')): ?>

    <div class="alert-error">

    <?= session()->getFlashdata('error') ?>

    </div>

    <?php endif; ?>



    <form method="post" action="<?= site_url('client/retrait') ?>">
        <?= csrf_field() ?>

        <label> Montant du retrait (Ar) </label>
        <input
            type="number"
            name="amount"
            placeholder="Exemple : 10000"
            value="<?= old('amount') ?>"
        >
        <?php if(session()->getFlashdata('errors')) { ?>
            <?php foreach(session()->getFlashdata('errors') as $error) { ?>
                <div class="error">
                    <?= $error ?>
                </div>
            <?php } ?>
        <?php } ?>

        <button type="submit"> Valider le retrait </button>
    </form>

    <style>
    input{
    width:100%;
    padding:15px;
    border-radius:10px;
    border:1px solid #ddd;
    margin-top:10px;
    font-size:16px;
    }
    button{
    margin-top:25px;
    padding:15px 30px;
    background:#1565C0;
    color:white;
    border:none;
    border-radius:10px;
    cursor:pointer;
    }
    .alert-error{
    background:#ffdddd;
    color:#b30000;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
    }

    .error{
        color:red;
        margin-top:10px;
    }

    </style>


<?= $this->endSection() ?>
