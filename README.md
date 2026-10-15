# Mini Social Network — Full-Stack Architecture

> **Architecture, Design & Engineering by Mohammed AICHOUR**  
> *Full-Stack Software Engineer & Solutions Architect*

[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![React](https://img.shields.io/badge/React-18+-61DAFB?style=flat&logo=react&logoColor=black)](https://react.dev/)
[![Status](https://img.shields.io/badge/Status-Architected%20%26%20Implemented-success)](#)

<p align="center">
  <img src="screenshots/mini_social_network_preview.png" alt="Aperçu Mini Social Network" width="100%">
</p>

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

---

## 📡 Points d'Accès de l'API RESTful (PHP)

| Méthode | Route | Contrôleur / Action | Authentification |
|---|---|---|---|
| `POST` | `/api/auth/register` | `AuthController@register` | Publique |
| `POST` | `/api/auth/login` | `AuthController@login` | Publique |
| `GET` | `/api/posts` | `PostController@index` | Bearer Token |
| `POST` | `/api/posts` | `PostController@store` | Bearer Token |
| `GET` | `/api/posts/{id}` | `PostController@show` | Bearer Token |
| `POST` | `/api/posts/{id}/comments` | `CommentController@store` | Bearer Token |
| `POST` | `/api/users/{id}/follow` | `FollowController@toggle` | Bearer Token |

---

## 🏛️ Architecture & Modèle Relationnel

### Diagramme de Séquence : Flux d'Authentification & Publication

```mermaid
sequenceDiagram
    autonumber
    actor User as Utilisateur
    participant React as Frontend React (Vite)
    participant PHP as API PHP (server/routes/api.php)
    participant Auth as Middleware d'Authentification
    participant MySQL as Base MySQL 8.0

    User->>React: Saisie identifiants & Connexion
    React->>PHP: POST /api/auth/login
    PHP->>MySQL: Vérification hash mot de passe (password_verify)
    MySQL-->>PHP: Tuple utilisateur validé
    PHP-->>React: Token d'authentification JSON
    User->>React: Rédiger publication & valider
    React->>PHP: POST /api/posts (Bearer Token)
    PHP->>Auth: Vérification intégrité Token
    Auth-->>PHP: Utilisateur autorisé
    PHP->>MySQL: INSERT INTO posts (user_id, content, created_at)
    MySQL-->>PHP: Post ID généré
    PHP-->>React: 201 Created (Post payload)
    React-->>User: Mise à jour immédiate du fil d'actualité
```

### Schéma Entité-Association (ERD)

```mermaid
erDiagram
    USERS ||--o{ POSTS : "publie"
    USERS ||--o{ COMMENTS : "rédige"
    POSTS ||--o{ COMMENTS : "contient"
    USERS ||--o{ LIKES : "aime"
    POSTS ||--o{ LIKES : "reçoit"
    USERS ||--o{ FOLLOWS : "suit"

    USERS {
        int id PK
        string username
        string email
        string password_hash
        string avatar_url
        text bio
        datetime created_at
    }

    POSTS {
        int id PK
        int user_id FK
        text content
        string image_url
        datetime created_at
    }

    COMMENTS {
        int id PK
        int post_id FK
        int user_id FK
        text content
        datetime created_at
    }

    LIKES {
        int user_id PK, FK
        int post_id PK, FK
        datetime created_at
    }

    FOLLOWS {
        int follower_id PK, FK
        int following_id PK, FK
        datetime created_at
    }
```

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
