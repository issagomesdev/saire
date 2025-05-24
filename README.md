<h1 align="center" style="font-weight: bold;">🏛️ Prefeitura de Sairé — Institutional CMS</h1>

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![JavaScript](https://img.shields.io/badge/javascript-%23000000.svg?style=for-the-badge&logo=javascript)
![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white)

![Preview do site](https://saire.byissa.tech/midia/img/preview.png)

> 📍 Developed as a freelance project for the Municipality of Sairé-PE, used officially for about 6 months in 2021.

<p align="center">
  <a href="#about">About</a> •
  <a href="#features">Features</a> •
  <a href="#technologies">Technologies</a> • 
  <a href="#routes">App Routes</a> • 
  <a href="#started">Getting Started</a> •
  <a href="#notes">Final Notes</a>
</p>

<h2 id="about">📌 About</h2>

This project is a municipal institutional website that includes a **dynamic CMS**, allowing administrators to manage menus, pages, publications, photo galleries, and other informational content through a friendly admin panel. The site is public-facing and was tailored for a local government audience.

[![project](https://img.shields.io/badge/📱Visit_this_project-000?style=for-the-badge&logo=project)](https://saire.byissa.tech/)


<h2 id="features">✨ Features</h2>

### 🧑‍💼 Public Area

- Dynamic homepage with featured posts and gallery highlights
- News section with full article navigation
- Interactive photo gallery with modal preview and details
- Global search by term (news, galleries, and pages)
- Custom header, footer, and menu

### 🔒 Admin Panel

- Role and permission management (Admin/User)
- User CRUD with filters and export options
- Audit logs for tracking system actions
- Menu and submenu manager (links to internal or external pages)
- Dynamic pages with content editor and image attachment
- Categories for tagging galleries and news
- News publication manager (content, tags, images)
- Gallery manager (photo upload, tags, descriptions)
- Password update and profile management

<h2 id="technologies">🛠️ Technologies</h2>

This CMS was built with a custom Laravel stack, using:

- **Laravel** — Robust PHP framework for backend and admin panel
- **Blade** — Laravel templating engine for dynamic HTML rendering
- **Spatie Media Library** — File/media uploads and conversions
- **JavaScript** — For dynamic frontend interactions (gallery, toggles, etc.)
- **CKEditor** — Rich text editing for publications and pages
- **jQuery & Vanilla JS** — Used throughout the admin and public site
- **Bootstrap** (customized) — Layout and UI consistency
- **Audit Logs** — Full change tracking for all major resources

> ⚙️ The system was designed to be modular and easily expandable for other municipalities or small content-based platforms.

 <h2 id="routes">📍 Application Routes</h2>

 ### 🌐 Public

| Method | Path                          | Description                          |
|--------|-------------------------------|--------------------------------------|
| GET    | `/`                           | Homepage                             |
| GET    | `/galeria`                    | Gallery page                         |
| GET    | `/noticias`                   | News/publications list               |
| GET    | `/noticias/{title}`           | Single publication details           |
| GET    | `/pagina/{title}`             | Static content page view             |
| GET    | `/pesquisa`                   | Global search                        |
| GET    | `/pesquisa/publications`      | Fetch search for publications        |
| GET    | `/pesquisa/pages`             | Fetch search for static pages        |
| GET    | `/pesquisa/galleries`         | Fetch search for galleries           |

### Admin (`/admin`)

| Resource      | Description                            |
|---------------|----------------------------------------|
| Permissions   | Manage access control permissions      |
| Roles         | Define user roles and assign permissions |
| Users         | Admin user management                  |
| Audit Logs    | System activity tracking               |
| Menus         | Main navigation structure              |
| Submenus      | Secondary navigation structure         |
| Pages         | Static institutional pages             |
| Publications  | Create, edit, delete news articles     |
| Categories    | Tag management                         |
| Galleries     | Manage photo collections               |
| Profile       | Password update and profile management |

> 🔐 All admin routes are protected by authentication middleware.

<h2 id="started">▶️ Getting Started</h2>

### Requirements

- PHP >= 8.1
- Laravel >= 10
- Composer
- MySQL or compatible DB

### Installation

```bash
# Clone the project
git clone https://github.com/issagomesdev/saire.git

cd saire

# Install PHP dependencies
composer install

# Copy environment config and generate app key
cp .env.example .env
php artisan key:generate

# Import the database
# Go to the "database/db" folder and import the "base.sql" file into your database.
# Configure your .env variables

# Link media storage
php artisan storage:link

# Serve locally
php artisan serve

# Access /admin with:
# Email: admin@admin.com
# Password: password
```

<h2 id="notes"> 📌 Final Notes</h2>

- This project was developed as a custom CMS for a municipal institution in Pernambuco.
- It was maintained for 6 months under a PJ contract and later discontinued by the client.


