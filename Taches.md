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


