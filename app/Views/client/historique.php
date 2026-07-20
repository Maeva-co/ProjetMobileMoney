<?= $this->extend('layouts/client') ?>

<?= $this->section('title') ?>
    Historiques
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1>Historique des transactions</h1>
<p>
    Retrouvez l'ensemble des opérations effectuées sur votre portefeuille Mobile Money.
</p>

<?php if(empty($transactions)): ?>
    <div class="empty">
        Aucune transaction n'a encore été effectuée.
    </div>
<?php else: ?>
<table>
    <thead>
        <tr>
            <th>Date</th>

            <th>Type</th>

            <th>Opérateur</th>

            <th>Montant</th>

            <th>Frais</th>

            <th>Destinataire</th>

        </tr>

    </thead>

    <tbody>

    <?php foreach($transactions as $transaction): ?>

        <tr>

            <td>

                <?= date(
                    'd/m/Y H:i',
                    strtotime($transaction['transaction_date'])
                ) ?>

            </td>

            <td>

                <?php

                $class = '';

                switch($transaction['transaction_type']){

                    case 'depot':
                        $class = 'badge green';
                        break;

                    case 'retrait':
                        $class = 'badge red';
                        break;

                    default:
                        $class = 'badge blue';

                }

                ?>

                <span class="<?= $class ?>">

                    <?= ucfirst($transaction['transaction_type']) ?>

                </span>

            </td>

            <td>

                <?= esc($transaction['operator_name']) ?>

            </td>

            <td>

                <?= number_format(
                    $transaction['amount'],
                    2,
                    ',',
                    ' '
                ) ?> Ar

            </td>

            <td>

                <?= number_format(
                    $transaction['frais'],
                    2,
                    ',',
                    ' '
                ) ?> Ar

            </td>

            <td>

                <?php if($transaction['receiver_number']): ?>

                    <?php if($transaction['receiver_name']): ?>

                        <?= esc($transaction['receiver_name']) ?>

                        (<?= esc($transaction['receiver_number']) ?>)

                    <?php else: ?>

                        —

                        <?= esc($transaction['receiver_number']) ?>

                    <?php endif; ?>

                <?php else: ?>

                    —

                <?php endif; ?>

            </td>

        </tr>

    <?php endforeach; ?>

    </tbody>

</table>

<?php endif; ?>

<style>

table{

width:100%;

border-collapse:collapse;

margin-top:30px;

background:white;

}

th{

background:#1565C0;

color:white;

padding:15px;

text-align:left;

}

td{

padding:15px;

border-bottom:1px solid #ececec;

}

tr:hover{

background:#f7fbff;

}

.badge{

padding:6px 12px;

border-radius:20px;

color:white;

font-size:13px;

font-weight:600;

display:inline-block;

}

.green{

background:#2e7d32;

}

.red{

background:#c62828;

}

.blue{

background:#1565C0;

}

.empty{

padding:25px;

background:#eef5ff;

border-radius:12px;

text-align:center;

color:#1565C0;

margin-top:25px;

}

</style>

<?= $this->endSection() ?>
