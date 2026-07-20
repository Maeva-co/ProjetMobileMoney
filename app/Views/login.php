<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mobile Money</title>
    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Segoe UI,sans-serif;
        }
        body{
            background:#eef5ff;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }
        .card{
            width:380px;
            background:white;
            border-radius:18px;
            box-shadow:0 10px 35px rgba(0,0,0,.12);
            padding:40px;
        }
        h1{
            color:#0066ff;
            text-align:center;
            margin-bottom:10px;
        }
        p{
            color:#666;
            text-align:center;
            margin-bottom:35px;
        }
        label{
            display:block;
            margin-bottom:8px;
            color:#333;
            font-weight:600;
        }
        input{
            width:100%;
            padding:14px;
            border:1px solid #d6d6d6;
            border-radius:10px;
            outline:none;
            font-size:16px;
            transition:.3s;
        }
        input:focus{
            border-color:#0066ff;
            box-shadow:0 0 8px rgba(0,102,255,.25);
        }
        button{
            width:100%;
            margin-top:25px;
            border:none;
            background:#0066ff;
            color:white;
            padding:14px;
            border-radius:10px;
            cursor:pointer;
            font-size:16px;
            transition:.3s;
        }
        button:hover{
            background:#0050d0;
        }
        .error{
            margin-top:6px;
            color:red;
            font-size:14px;
        }
        .message{
            margin-bottom:20px;
            padding:12px;
            border-radius:8px;
            background:#ffdcdc;
            color:#b40000;
        }
        .logo{
            width:75px;
            height:75px;
            background:#0066ff;
            border-radius:50%;
            color:white;
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:32px;
            margin:auto;
            margin-bottom:20px;
        }
    </style>
</head>

<body>
<div class="card">
    <!-- <div class="logo">
    </div> -->
    <h1>Mobile Money</h1>
    <p>Connexion</p>

    <?php if(session()->getFlashdata('error')) { ?>
        <div class="message">
            <?= session()->getFlashdata('error') ?>
        </div>

    <?php } ?>

    <form action="<?= site_url('/login') ?>" method="post">
        <?= csrf_field() ?>
        <label>Numéro de téléphone</label>
        <input
            type="text"
            name="number"
            maxlength="10"
            placeholder="034123456"
            value="<?= old('number') ?>"
        >

        <?php if(session()->getFlashdata('errors')) { ?>
            <?php if(isset(session()->getFlashdata('errors')['number'])) { ?>
                <div class="error">
                    <?= session()->getFlashdata('errors')['number'] ?>
                </div>
            <?php } ?>
        <?php } ?>

        <button type="submit">
            Se connecter
        </button>

    </form>

</div>

</body>

</html>
