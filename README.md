# GiftBox — Installation
- Nacime Laghezali
- Fahim Meziani

url depot git : https://github.com/nacimeoo/Giftbox_v2_Coquin_Meziani_Laghezali

url docketu : http://docketu.iutnc.univ-lorraine.fr:32000/home

## Installation

1. **Cloner le dépôt**
```bash
   git clone <url-du-depot>
```

2. **Configurer la base de données**

   Copier `.database_env.dist` en `.database_env` et remplir les variables.

3. **Configurer l'application**

   Faire de même pour `gift.appli/src/conf/gift.db.conf.ini.dist` en `gift.appli/src/conf/gift.db.conf.ini`.


4. **Lancer les conteneurs**
```bash
   docker compose up
```

5. **Initialiser la base de données**

   Ouvrir Adminer sur [http://localhost:8081](http://localhost:8081) et exécuter dans l'ordre :
   - `sql/gift.schema.sql`
   - `sql/gift.data.sql`

6. **Accéder à l'application**

   [http://localhost:8080/home](http://localhost:8080/home)

## Ports utilisés

| Service     | URL                                            |
|-------------|------------------------------------------------|
| Application | [http://localhost:8080](http://localhost:8080) |
| Adminer     | [http://localhost:8081](http://localhost:8081) |


## Fonctionnalités réalisées

### Catalogue
- **1** — Affichage de la liste de toutes les prestations avec nom, prix, catégorie et photo (Nacime)
- **2** — Affichage du détail d'une prestation (Fahim)
- **3** — Affichage des prestations par catégorie (Nacime)
- **4** — Affichage de la liste des catégories (Fahim)
- **5** — Affichage des coffrets types classés par thème (Fahim)
- **6** — Affichage du détail d'un coffret type avec ses prestations (Nacime)

### Gestion des box
- **7** — Création d'une box vide (nom, description, option cadeau + message) (Nacime)
- **9** — Ajout de prestations dans la box courante (Fahim)
- **10** — Affichage de la box en cours de construction (liste des prestations, tarifs, total) (Fahim)
- **11** — Validation d'une box (minimum 2 prestations requises) (Nacime)
- **12** — Génération d'une URL d'accès unique après validation (Nacime)
- **13** — Accès à une box via son URL (affichage normal ou mode cadeau avec masquage des prix) (Nacime)

### Authentification
- **14** — Connexion (email + mot de passe) (Fahim)

### API REST
- **21** — `GET /api/categories` — liste des catégories en JSON (Nacime)
- **23** — `GET /api/box/{id}` — contenu d'une box en JSON (Fahim)

## Données de test

### Connexion à l'application

| Champ        | Valeur                  |
|--------------|-------------------------|
| Email        | aurore06@example.org    |
| Mot de passe | aurore06                |