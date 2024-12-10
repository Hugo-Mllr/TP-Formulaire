# Formulaire Multi-étapes avec Gestion de Partenaires

Ce projet est une application web PHP permettant de gérer un formulaire multi-étapes. Le formulaire permet la création et l'enregistrement de contrats associés à des partenaires dans une base de données. Chaque étape recueille des informations spécifiques et propose une navigation intuitive.

## Fonctionnalités principales

- **Formulaire multi-étapes :**
  - Collecte d'informations sur le contrat (nom, adresse, date, répartition, etc.).
  - Saisie des partenaires et de leurs contributions.

- **Gestion des partenaires :**
  - Affichage dynamique des partenaires disponibles.
  - Association de contributions spécifiques à chaque partenaire.

- **Système d'alertes :**
  - Affichage d'un message de succès pendant 2 secondes après l'envoi du formulaire.

- **Navigation intuitive :**
  - Boutons pour naviguer entre les étapes du formulaire.

## Technologies utilisées

- **Frontend :**
  - HTML5 / CSS3 pour la structure et le style.
  - [Bootstrap 5](https://getbootstrap.com/) pour un design réactif.
  - JavaScript pour la gestion de la navigation entre les étapes.

- **Backend :**
  - PHP pour le traitement des données et la logique serveur.
  - MySQL pour la gestion des données.

- **Autres outils :**
  - Sessions PHP pour la gestion des utilisateurs connectés et des messages temporaires.

## Prérequis

- Serveur web local avec PHP (comme [XAMPP](https://www.apachefriends.org/index.html) ou [WAMP](https://www.wampserver.com/)).
- Base de données MySQL configurée avec les tables nécessaires.

## Installation

1. **Cloner le projet :**
   ```bash
   git clone https://github.com/votre-utilisateur/nom-du-repo.git
   ```

2. **Configurer la base de données :**
   - Importez le fichier `BDD.sql` dans votre serveur MySQL pour créer les tables requises.

3. **Configurer la connexion à la base de données :**
   - Modifiez les identifiants de connexion dans `BDD.php` :
     ```php
     $bdd = new PDO('mysql:host=localhost;dbname=nom_de_la_base', 'utilisateur', 'mot_de_passe');
     ```

4. **Démarrer le serveur local :**
   - Placez le projet dans le répertoire `htdocs` de votre serveur local.
   - Accédez au projet via `http://localhost/nom-du-repo`.

## Utilisation

1. **Accéder au formulaire :**
   - Remplissez les différents champs à chaque étape.
   - Utilisez les boutons "Suivant" et "Précédent" pour naviguer.

2. **Soumettre le formulaire :**
   - Une fois toutes les étapes remplies, cliquez sur "Soumettre" pour enregistrer les données.

3. **Vérifier les alertes :**
   - Une alerte de succès s'affiche pendant 2 secondes pour confirmer l'envoi.

## Aperçu du projet

[image](https://github.com/user-attachments/assets/0cd07903-c210-419a-a3e8-16cb0253e1fc)


## Structure du projet

- `formulaire2.php` : Page principale du formulaire multi-étapes.
- `BDD.php` : Fichier de connexion à la base de données.
- `mode.css` et `form.css` : Styles pour le thème et le formulaire.
- `fonction.js` et `bouton.js` : Scripts pour la navigation et les interactions utilisateur.

## Améliorations possibles

- Ajouter une validation côté serveur pour renforcer la sécurité.
- Implémenter une sauvegarde temporaire des étapes dans la session.
- Ajouter un système d'authentification pour restreindre l'accès.

## Auteur

- **Muller Hugo** - [Hugo-Mllr]([https://github.com/votre-utilisateur](https://github.com/Hugo-Mllr))

## Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

