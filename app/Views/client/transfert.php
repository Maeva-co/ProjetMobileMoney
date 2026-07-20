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
        <input
            type="text"
            name="number"
            value="<?= old('number') ?>"
            placeholder="0341234567">

        <label style="margin-top:20px;display:block;"> Montant (Ar) </label>

        <!-- <input
            type="number"
            name="amount"
            value="<?= old('amount') ?>"
            placeholder="10000"> -->

        <div id="numbers-container">
            <div class="number-row">
                <input
                    type="text"
                    name="numbers[]"
                    placeholder="034XXXXXXX"
                    required>

                <button type="button" class="remove">−</button>
            </div>
        </div>
        <button type="button" id="addNumber"> + </button>


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

    </style>

    <script>
        const container = document.getElementById('numbers-container');
        document.getElementById('addNumber').addEventListener('click', () => {
            const div = document.createElement('div');
            div.className = 'number-row';
            div.innerHTML = `
                <input type="text" name="numbers[]" required>
                <button type="button" class="remove">−</button>
            `;
            container.appendChild(div);
        });

        document.addEventListener('click', function(e){
            if(e.target.classList.contains('remove')){
                if(document.querySelectorAll('.number-row').length > 1){
                    e.target.parentElement.remove();
                }
            }
        });
    </script>

<?= $this->endSection() ?>
