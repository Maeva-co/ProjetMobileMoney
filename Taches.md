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

