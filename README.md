# Mini Social Network — Full-Stack Architecture

> **Architecture, Design & Engineering by Mohammed AICHOUR**  
> *Full-Stack Software Engineer & Solutions Architect*

[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![React](https://img.shields.io/badge/React-18+-61DAFB?style=flat&logo=react&logoColor=black)](https://react.dev/)
[![Status](https://img.shields.io/badge/Status-Architected%20%26%20Implemented-success)](#)

---

## 📌 Présentation du Projet

**Mini Social Network** est une architecture full-stack modulaire conçue pour offrir les fonctionnalités essentielles d'un réseau social moderne avec une séparation stricte des responsabilités (Separation of Concerns) et une performance optimale.

Le projet combine :
1. **Frontend moderne** : Application React réactive pour l'interaction utilisateur et le flux en temps réel.
2. **Backend RESTful** : API en PHP natif orientée objet (PDO, MVC / Controller-Model, Middleware d'authentification).
3. **Persistance relationnelle** : Base MySQL relationnelle normalisée (3NF) avec clés étrangères en cascade et index optimisés pour la recherche rapide.

---

## 🏗️ Structure du Projet

```text
mini-social-network/
│
├── client/                     # Application Frontend React
│   ├── src/
│   │   ├── App.jsx             # Flux d'actualités & publication
│   │   ├── index.css           # Thème & typographie
│   │   └── main.jsx            # Point de montage DOM
│   ├── index.html
│   └── package.json
│
├── server/                     # API RESTful Backend (PHP)
│   ├── config/
│   │   └── database.php        # Singleton de connexion PDO MySQL
│   ├── controllers/
│   │   ├── AuthController.php  # Authentification & tokens
│   │   ├── UserController.php  # Profils utilisateurs
│   │   ├── PostController.php  # CRUD publications & flux
│   │   ├── CommentController.php # Commentaires liés
│   │   └── FollowController.php  # Relations d'abonnements
│   ├── models/
│   │   ├── User.php            # Requêtes SQL utilisateurs
│   │   ├── Post.php            # Requêtes SQL publications
│   │   ├── Comment.php         # Requêtes SQL commentaires
│   │   └── Follow.php          # Requêtes SQL follows
│   ├── middleware/
│   │   └── authMiddleware.php  # Vérification Bearer token
│   ├── routes/
│   │   └── api.php             # Routeur HTTP RESTful
│   ├── uploads/                # Stockage des médias utilisateurs
│   ├── index.php               # Point d'entrée de l'API & CORS
│   └── .env.example            # Configuration d'environnement
│
├── database/
│   └── schema.sql              # Schéma SQL DDL normalisé
│
└── tests/
    └── test_architecture.js    # Suite de tests automatisés d'intégrité
```

---

## 🗄️ Modèle Relationnel (Database Schema)

- **`users`** : Gestion des comptes (`id`, `username`, `email`, `password_hash`, `avatar_url`, `bio`, timestamps).
- **`posts`** : Publications avec support d'image (`id`, `user_id`, `content`, `image_url`, timestamps).
- **`comments`** : Commentaires rattachés aux publications (`id`, `post_id`, `user_id`, `content`, timestamps).
- **`likes`** : Likes avec contrainte d'unicité `(user_id, post_id)` pour prévenir les doublons.
- **`follows`** : Relations asymétriques `(follower_id, following_id)` pour le suivi de comptes.

---

## 🚀 Démarrage Rapide

### 1. Base de Données
Importez le schéma dans votre serveur MySQL :
```bash
mysql -u root -p < database/schema.sql
```

### 2. Démarrage de l'API Backend
```bash
cd server
php -S localhost:8000
```

### 3. Démarrage du Client Frontend
```bash
cd client
npm install
npm run dev
```

---

## 🧪 Tests Automatisés

Pour valider l'intégrité architecturale :
```bash
node tests/test_architecture.js
```

---

## 👨‍💻 Concepteur & Développeur

**Mohammed AICHOUR**  
- GitHub : [@Mohammed-aichour](https://github.com/Mohammed-aichour)  
- Profil & Portfolio : Intégré au portfolio professionnel officiel.
