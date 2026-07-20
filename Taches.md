# Projet S4: Mobile Money
Systeme de simulation d'operateur de Mobile Money

## Version 1
### Cote client: Maeva
- login automatique avec le numero de telephone
    -> pas d'inscription

    - Creation de:
        - UsersModel: $tables, $primarykey, $allowedFields, $validationRules, $validationMessages
        - UsersControllers
            - fonction index(): retourne vers la view /login
            - fonction login(): login du client, insertion si pas encore en base, session, retourne dans la view solde
            - fonction logout(): destruction session, retourne vers la view /login
        - Routes
            - modification de /
            - ajout de /login, /logout et /client/solde
        - View: login
            - Formulaire + validation: messages si jamais y a un probleme


- Page d'affichage de solde
    - Creation de
        - SoldeMouvementModel: $tables, $primarykey, $allowedFields
            - fonction getSolde(user_id)
            -> solde = somme credit - somme debit
        - SoldeController: fonction index() -> appelle getSolde, retourne view /client/solde
        - routes: modification de /client/solde
        - View
            - layouts/client.php: sidebar
            - client/solde.php: affichage 

- Page de dépôt
    - Création de
        - TransactionsModel: $table, $primaryKey, $allowedFields
        - TransactionTypesModel: $table, $primaryKey, $allowedFields
        - DepotController
            - fonction index(): retourne vers la view /client/depot
            - fonction store(): validation du montant, insertion dans transactions et solde_mouvement (credit), redirection vers /client/solde
        - Routes
            - ajout de /client/depot (GET, POST)
        - View: client/depot
            - formulaire de dépôt + validation

- Page de retrait
    - Création de
        - ConfigFraisModel: $table, $primaryKey, $allowedFields
        - modification de TransactionsModel
            - ajout du champ frais dans $allowedFields
        - RetraitController
            - fonction index(): retourne vers la view /client/retrait
            - fonction store(): récupération des frais selon la configuration, vérification du solde, insertion dans transactions et solde_mouvement (débit montant + débit frais)
        - Routes
            - ajout de /client/retrait (GET, POST)
        - View: client/retrait
            - formulaire de retrait + validation

- Page de transfert
    - Création de
        - TransfertController
            - fonction index(): retourne vers la view /client/transfert
            - fonction store(): validation, vérification du destinataire, récupération des frais, vérification du solde, insertion dans transactions et solde_mouvement (débit montant, débit frais, crédit destinataire)
        - Routes
            - ajout de /client/transfert (GET, POST)
        - View: client/transfert
            - formulaire de transfert + validation

- Page des historiques
    - Modification de
        - TransactionsModel
            - fonction getHistorique(user_id)
        - Création de
            - HistoriqueController
                - fonction index(): récupération de l'historique et retour vers la view /client/historique
            - Routes
                - ajout de /client/historiques
            - View: client/historique
                - tableau des transactions (date, type, opérateur, montant, frais, destinataire)


### Cote client: Elie
- Filter par roles
  - alias app/Config/Filters.php : 'auth' => \App\Filters\AuthFilter::class,
- Models des correspondentes avec la base + les methodes
- Dashboard admin

## Fonctionnalité : Gestion des préfixes opérateurs

- Création du modèle OperatorTypesModel pour gérer la table des opérateurs
- Création du contrôleur OperatorsController avec les méthodes :
  - index() : Afficher la liste des opérateurs
  - create() : Afficher le formulaire d'ajout
  - store() : Enregistrer un nouvel opérateur
  - edit() : Afficher le formulaire de modification
  - update() : Mettre à jour un opérateur
  - delete() : Supprimer un opérateur
- Ajout des routes dans Routes.php pour les URLs :
  - /admin/operators : Liste
  - /admin/operators/create : Ajouter
  - /admin/operators/edit/{id} : Modifier
  - /admin/operators/delete/{id} : Supprimer
- Création des vues :
  - index.php : Liste des opérateurs
  - create.php : Formulaire d'ajout
  - edit.php : Formulaire de modification
- Ajout du lien dans le menu de la sidebar du dashboard

---

## Fonctionnalité : Gestion des types d'opérations

- Création du modèle TransactionTypesModel pour gérer la table des types
- Création du contrôleur TransactionTypesController avec les méthodes :
  - index() : Afficher la liste des types
  - create() : Afficher le formulaire d'ajout
  - store() : Enregistrer un nouveau type
  - edit() : Afficher le formulaire de modification
  - update() : Mettre à jour un type
  - delete() : Supprimer un type
- Ajout des routes dans Routes.php pour les URLs :
  - /admin/transaction-types : Liste
  - /admin/transaction-types/create : Ajouter
  - /admin/transaction-types/edit/{id} : Modifier
  - /admin/transaction-types/delete/{id} : Supprimer
- Création des vues :
  - index.php : Liste des types
  - create.php : Formulaire d'ajout
  - edit.php : Formulaire de modification
- Ajout du lien dans le menu de la sidebar du dashboard

---

## Fonctionnalité : Gestion des barèmes de frais

- Création du modèle ConfigFraisModel pour gérer la table des configurations
- Création du modèle ConfigFraisHistoryModel pour gérer l'historique
- Création du contrôleur ConfigController avec les méthodes :
  - index() : Afficher la liste des configurations
  - create() : Afficher le formulaire d'ajout
  - store() : Enregistrer une nouvelle configuration (avec historique)
  - edit() : Afficher le formulaire de modification
  - update() : Mettre à jour une configuration (désactivation + création + historique)
  - delete() : Désactiver une configuration
  - history() : Afficher l'historique des modifications
- Ajout des routes dans Routes.php pour les URLs :
  - /admin/config : Liste
  - /admin/config/create : Ajouter
  - /admin/config/edit/{id} : Modifier
  - /admin/config/delete/{id} : Désactiver
  - /admin/config/history : Historique
- Création des vues :
  - index.php : Liste des configurations
  - create.php : Formulaire d'ajout
  - edit.php : Formulaire de modification
  - history.php : Historique des modifications
- Gestion de la session pour le created_by dans l'historique
- Ajout du lien dans le menu de la sidebar du dashboard
- Logique de versionnement : désactiver l'ancienne, créer une nouvelle, enregistrer l'historique

---

## Fonctionnalité : Situation des gains

- Création du contrôleur GainsController avec la méthode :
  - index() : Afficher la situation des gains
- Récupération des données dans la base :
  - Gains totaux (somme de tous les frais)
  - Gains du jour
  - Gains du mois
  - Gains de l'année
  - Gains par opérateur (Airtel, Orange)
  - Gains par type de transaction (Retrait, Transfert)
  - Évolution mensuelle des gains sur 12 mois
- Ajout de la route dans Routes.php :
  - /admin/gains : Page des gains
- Création de la vue :
  - index.php : Cartes de gains, graphiques en barres, tableau d'évolution
- Ajout du lien dans le menu de la sidebar du dashboard
- Calcul des pourcentages de répartition
- Affichage des évolutions avec indicateurs de tendance (↑ ↓)

---

## Fonctionnalité : Situation des comptes clients

- Création du contrôleur ClientsController avec les méthodes :
  - index() : Afficher la liste des clients
  - show() : Afficher les détails d'un client
- Ajout des routes dans Routes.php :
  - /admin/clients : Liste des clients
  - /admin/clients/{id} : Détails d'un client
- Création des vues :
  - index.php : Liste des clients avec leur solde
  - show.php : Détails d'un client (informations, solde, transactions, mouvements)
- Ajout du lien dans le menu de la sidebar du dashboard
- Utilisation du modèle SoldeMouvementModel pour calculer le solde de chaque client
- Récupération des transactions d'un client avec les détails (type, opérateur)
- Récupération des mouvements de solde d'un client

