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


### Cote client: Elie
- Filter par roles
  - alias app/Config/Filters.php : 'auth' => \App\Filters\AuthFilter::class,
- Models des correspondentes avec la base + les methodes
- Dashboard admin