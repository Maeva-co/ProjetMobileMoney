<?= $this->extend('layouts/client') ?>

<?= $this->section('title') ?>
    Transfert
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <h1>Faire un transfert</h1>
    <p>
        Envoyez de l'argent vers un autre utilisateur Mobile Money.
    </p>

    <?php if(session()->getFlashdata('error')) { ?>
        <div class="alert-error">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php } ?>

    <form method="post" action="<?= site_url('client/transfert') ?>">
        <?= csrf_field() ?>
        <label>Numéro du destinataire</label>
        <div id="receivers">
            <div class="receiver-item">
                <input
                    type="text"
                    name="number[]"
                    value="<?= old('number.0') ?>"
                    placeholder="0341234567">
            </div>
        </div>
        <div class="receiver-buttons">
            <button type="button" id="addReceiver">+</button>
            <button type="button" id="removeReceiver">−</button>
        </div>

        <label style="margin-top:20px;display:block;"> Montant (Ar) </label>
        <input
            type="number"
            name="amount"
            value="<?= old('amount') ?>"
            placeholder="10000">

        


        <div class="checkbox-group">
        <label>
        <input
            type="checkbox"
            name="include_retrait_fee"
            value="1"
            <?= old('include_retrait_fee') ? 'checked' : '' ?>
        >
        Inclure les frais de retrait du destinataire
    </label>
</div>


        <?php if(session()->getFlashdata('errors')) { ?>
            <?php foreach(session()->getFlashdata('errors') as $error) { ?>
                <div class="error">
                    <?= $error ?>
                </div>
            <?php } ?>
        <?php } ?>

        <button type="submit"> Effectuer le transfert </button>

    </form>

    <style>
    input{
    width:100%;
    padding:15px;
    border:1px solid #ddd;
    border-radius:10px;
    margin-top:10px;
    font-size:16px;
    }

    button{
    margin-top:25px;
    background:#1565C0;
    color:white;
    padding:15px 30px;
    border:none;
    border-radius:10px;
    cursor:pointer;
    }

    .alert-error{
    background:#ffe4e4;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
    color:#b00020;
    }

    .error{
    margin-top:10px;
    color:red;
    }

    .checkbox-group{
        margin-top:20px;
    }

    .receiver-item{
        margin-top:10px;
    }

    .receiver-buttons{
        display:flex;
        gap:10px;
        margin-top:10px;
    }

    .receiver-buttons button{
        margin-top:0;
        width:45px;
        height:45px;
        padding:0;
        font-size:22px;
        font-weight:bold;
    }

    </style>

    <script>
        const receivers = document.getElementById('receivers');
        document.getElementById('addReceiver').addEventListener('click', function () {
            const div = document.createElement('div');
            div.className = 'receiver-item';
            div.innerHTML = `
                <input
                    type="text"
                    name="number[]"
                    placeholder="0341234567">
            `;
            receivers.appendChild(div);
        });

        document.getElementById('removeReceiver').addEventListener('click', function () {
            const items = document.querySelectorAll('.receiver-item');
            if (items.length > 1) {
                items[items.length - 1].remove();
            }
        });
    </script>

<?= $this->endSection() ?>
