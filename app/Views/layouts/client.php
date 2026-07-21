<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= $this->renderSection('title') ?> - Mobile Money</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Segoe UI, Tahoma, sans-serif;
        }

        body {
            background: #f4f7fb;
        }

        .header {
            height: 70px;
            background: #1565C0;
            color: white;
            display: flex;
            align-items: center;
            padding: 0 30px;
            font-size: 26px;
            font-weight: bold;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .12);
        }

        .container {
            display: flex;
            min-height: calc(100vh - 70px);
        }

        .sidebar {
            width: 250px;
            background: #1565C0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
        }

        .menu {
            padding-top: 20px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 18px 25px;
            color: white;
            text-decoration: none;
            transition: .25s;
        }

        .menu a:hover {
            background: #0D47A1;
            border-left: 5px solid white;
            padding-left: 20px;
        }

        .logout {
            border-top: 1px solid rgba(255, 255, 255, .25);
        }

        .logout a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 18px 25px;
            color: white;
            text-decoration: none;
            transition: .25s;
        }

        .logout a:hover {
            background: #C62828;
        }

        .content {
            flex: 1;
            padding: 40px;
        }

        .card {
            background: white;
            border-radius: 18px;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
            min-height: 500px;
        }

        h1 {
            color: #1565C0;
            margin-bottom: 10px;
        }

        p {
            color: #666;
            margin-bottom: 35px;
        }
    </style>

</head>

<body>

    <header class="header">

        Mobile Money

    </header>

    <div class="container">

        <aside class="sidebar">

            <div class="menu">

                <a href="<?= site_url('client/solde') ?>">

                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="white" viewBox="0 0 16 16">
                        <path d="M8 3l6 5v5H2V8l6-5z" />
                    </svg>

                    Voir le solde

                </a>
                <a href="<?= site_url('client/epargne') ?>">

                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="white" viewBox="0 0 16 16">
                        <path d="M8 3l6 5v5H2V8l6-5z" />
                    </svg>

                    Configurer mon epargne

                </a>

                <a href="<?= site_url('client/depot') ?>">

                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="white" viewBox="0 0 16 16">
                        <path d="M8 1v14M1 8h14" stroke="white" stroke-width="2" />
                    </svg>

                    Faire un dépôt

                </a>

                <a href="<?= site_url('client/retrait') ?>">

                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="white" viewBox="0 0 16 16">
                        <path d="M1 8h14" stroke="white" stroke-width="2" />
                    </svg>

                    Faire un retrait

                </a>

                <a href="<?= site_url('client/transfert') ?>">

                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="white" viewBox="0 0 16 16">
                        <path d="M3 5h10M9 1l4 4-4 4M13 11H3M7 15l-4-4 4-4" stroke="white" stroke-width="1.8" fill="none" />
                    </svg>

                    Faire un transfert

                </a>

                <a href="<?= site_url('client/historiques') ?>">

                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="white" viewBox="0 0 16 16">
                        <path d="M8 3v5l3 2" stroke="white" stroke-width="2" fill="none" />
                        <circle cx="8" cy="8" r="6" stroke="white" stroke-width="2" fill="none" />
                    </svg>

                    Voir les historiques

                </a>

            </div>

            <div class="logout">

                <a href="<?= site_url('/logout') ?>">

                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="white" viewBox="0 0 16 16">
                        <path d="M6 2H2v12h4M10 12l4-4-4-4M4 8h10" stroke="white" stroke-width="2" fill="none" />
                    </svg>

                    Déconnexion

                </a>

            </div>

        </aside>

        <main class="content">

            <div class="card">

                <?= $this->renderSection('content') ?>

            </div>

        </main>

    </div>

</body>

</html>