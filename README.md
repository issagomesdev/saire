<h1 align="center" style="font-weight: bold;">🏛️ Prefeitura de Sairé — Institutional CMS</h1>

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![Docker](https://img.shields.io/badge/docker-%232496ED.svg?style=for-the-badge&logo=docker&logoColor=white)
![JavaScript](https://img.shields.io/badge/javascript-%23000000.svg?style=for-the-badge&logo=javascript)
![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white)

![Preview do site](https://saire.byissa.dev/midia/img/preview.png)

> 📍 Developed as a freelance project for the Municipality of Sairé-PE, used officially for about 6 months in 2023.

<p align="center">
  <a href="#about">About</a> •
  <a href="#features">Features</a> •
  <a href="#technologies">Technologies</a> •
  <a href="#routes">App Routes</a> •
  <a href="#started">Getting Started</a> •
  <a href="#docker">Docker Environment</a> •
  <a href="#seeding">Database Seeding</a> •
  <a href="#testing">Testing</a> •
  <a href="#structure">Project Structure</a> •
  <a href="#troubleshooting">Troubleshooting</a> •
  <a href="#notes">Final Notes</a>
</p>

<h2 id="about">📌 About</h2>

This project is a municipal institutional website that includes a **dynamic CMS**, allowing administrators to manage menus, pages, publications, photo galleries, and other informational content through a friendly admin panel. The site is public-facing and was tailored for a local government audience.

[![project](https://img.shields.io/badge/📱Visit_this_project-000?style=for-the-badge&logo=project)](https://saire.byissa.dev/)

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

- **Laravel 10** — Robust PHP framework for backend and admin panel
- **Blade** — Laravel templating engine for dynamic HTML rendering
- **Spatie Media Library** — File/media uploads and conversions
- **JavaScript** — For dynamic frontend interactions (gallery, toggles, etc.)
- **CKEditor** — Rich text editing for publications and pages
- **jQuery & Vanilla JS** — Used throughout the admin and public site
- **Bootstrap** (customized) — Layout and UI consistency
- **Audit Logs** — Full change tracking for all major resources
- **Docker / Docker Compose** — Containerized development and production environments (Nginx, PHP-FPM, MySQL, Redis)

> ⚙️ The system was designed to be modular and easily expandable for other municipalities or small content-based platforms.

<h2 id="routes">📍 Application Routes</h2>

### 🌐 Public

| Path                          | Description                          |
|-------------------------------|--------------------------------------|
| `/`                           | Homepage                             |
| `/galeria`                    | Gallery page                         |
| `/noticias`                   | News/publications list               |
| `/noticias/{title}`           | Single publication details           |
| `/pagina/{title}`             | Static content page view             |
| `/pesquisa`                   | Global search                        |
| `/pesquisa/publications`      | Fetch search for publications        |
| `/pesquisa/pages`             | Fetch search for static pages        |
| `/pesquisa/galleries`         | Fetch search for galleries           |

### Admin (`/admin`)

| Path                   | Description                                 |
|------------------------|---------------------------------------------|
| `/admin/permissions`   | Manage access control permissions           |
| `/admin/roles`         | Define user roles and assign permissions    |
| `/admin/users`         | Admin user management                       |
| `/admin/audit-logs`    | System activity tracking                    |
| `/admin/menus`         | Main navigation structure                   |
| `/admin/submenus`      | Secondary navigation structure              |
| `/admin/pages`         | Static institutional pages                  |
| `/admin/publications`  | Create, edit, delete news articles          |
| `/admin/categories`    | Tag management                              |
| `/admin/galleries`     | Manage photo collections                    |
| `/admin/profile`       | Password update and profile management      |

> 🔐 All admin routes are protected by authentication middleware.

<h2 id="started">▶️ Getting Started</h2>

### Requirements

**Option A — Native (no Docker)**
- PHP >= 8.1
- Composer
- MySQL or compatible DB
- Node.js + npm (for asset compilation)

**Option B — Docker (recommended)**
- Docker Engine >= 24
- Docker Compose v2 (`docker compose`, already bundled with Docker Desktop)

Everything else (PHP, Nginx, MySQL, Redis, Node) runs inside containers — nothing else needs to be installed on your machine.

---

### Option A: Native installation

```bash
# Clone the project
git clone https://github.com/issagomesdev/saire.git
cd saire

# Install PHP dependencies
composer install

# Copy environment config and generate app key
cp .env.example .env
php artisan key:generate

# .env.example ships ready for Docker. Since you're running natively,
# edit .env and switch these two lines (see the "sem Docker:" comments
# right above each one):
#   DB_HOST=127.0.0.1
#   REDIS_HOST=127.0.0.1

# Create an empty database, then run
# migrations + seeders — this populates the whole site (menus, pages,
# categories, ~150 publications and ~100 galleries with real sample
# photos from database/fake_media/) in one reproducible step. See
# "Database Seeding" below for details.
php artisan migrate --seed

# Install JS dependencies and build assets
npm install
npm run build

# Link media storage
php artisan storage:link

# Serve locally
php artisan serve

# Access /admin with:
# Email: admin@admin.com
# Password: password
```
---

### Option B: Docker (development)

```bash
# Clone the project
git clone https://github.com/issagomesdev/saire.git
cd saire

# Copy the environment template (ready to use with Docker as-is)
cp .env.example .env

# Build and start the containers
docker compose up -d

# The "app" container's entrypoint automatically runs composer install,
# key:generate and storage:link on first boot (see
# docker/php/entrypoint.dev.sh) — wait for it to finish before running
# anything else:
docker compose logs -f app
# ... watch until you see "NOTICE: ready to handle connections", then Ctrl+C

# Only the database migration/seed is a manual step, run once the app
# container is ready. This populates the whole site (menus, pages,
# categories, ~150 publications and ~100 galleries with real sample
# photos) in one reproducible step — see "Database Seeding" below.
docker compose exec app php artisan migrate --seed
```

The application will be available at **http://localhost:8000** (or whatever `APP_PORT` you set in `.env`), and the Vite dev server (hot reload) at **http://localhost:5173**.

> **Never run `composer install`, `key:generate` or `storage:link` manually while the container is still starting up** — the entrypoint already runs them, and two invocations racing on the same `.env` file can corrupt `APP_KEY` (two keys end up concatenated on the same line, causing "Unsupported cipher or incorrect key length"). If that happens, fix it with a single `docker compose exec app php artisan key:generate --force` once the container is idle, then `docker compose up -d --force-recreate app` — a plain `restart` is not enough, since environment variables from `.env` are only re-read when the container is (re)created, not restarted.

<h2 id="docker">🐳 Docker</h2>

The project includes two Docker Compose configurations:

| File | Purpose |
|------|---------|
| `docker-compose.yml` | Development (hot reload, Vite, bind mounts) |
| `docker-compose.prod.yml` | Production (optimized, immutable images) |

Both environments share the same Dockerfiles and `.env`, making it easy to switch between development and production.

### Architecture

The application is split into independent containers:

- PHP-FPM
- Nginx
- MySQL
- Redis
- Node (development only)

PHP uses a multi-stage Dockerfile, producing optimized images for development and production without duplicating configuration.

### Directory

```text
docker/
├── php/
├── nginx/
└── mysql/
```

### Environment

Copy the example file:

```bash
cp .env.example .env
```

Main variables:

```env
APP_PORT=8000
DB_DATABASE=saire
DB_USERNAME=saire
DB_PASSWORD=secret
```

---

## Development

Start:

```bash
docker compose up -d
```

Open:

```
http://localhost:${APP_PORT}
```

---

## Production

Build and start:

```bash
docker compose -f docker-compose.prod.yml up -d --build
```

Run migrations:

```bash
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force
```

---

## Useful commands

```bash
docker compose up -d
docker compose down
docker compose up -d --build

docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
docker compose exec app php artisan optimize:clear

docker compose logs -f app
```

<h2 id="seeding">🌱 Database Seeding</h2>

`php artisan migrate:fresh --seed` (or plain `migrate --seed` on an empty database) reproducibly populates the entire public site — no manual SQL import needed. `database/seeders/DatabaseSeeder.php` runs, in order:

| Seeder | What it creates |
|--------|------------------|
| `PermissionsTableSeeder`, `RolesTableSeeder`, `PermissionRoleTableSeeder` | Permission catalog and the default Admin role, with every permission attached |
| `UsersTableSeeder`, `RoleUserTableSeeder` | The default admin user (see credentials above) |
| `PagesSeeder`, `MenusSeeder` | The site's static pages and navigation (menus/submenus), using the Prefeitura's original content |
| `CategoriesSeeder` | Realistic PT-BR content categories (Saúde, Educação, Infraestrutura, etc.) |
| `PublicationsSeeder` | ~150 news publications with generated PT-BR body text and real sample photos |
| `GalleriesSeeder` | ~100 photo galleries, also backed by real sample photos |

`PublicationsSeeder` and `GalleriesSeeder` pull their images from `database/fake_media/` — a real acervo of sample municipal photos — via `database/seeders/Support/MediaCatalog.php`, which classifies each file into a theme by filename keywords so images stay contextually consistent with the generated content (e.g. sports photos attach to sports-themed publications). Text content is generated by `database/seeders/Support/NewsContentGenerator.php` from topic templates defined in `database/seeders/Support/MunicipalTopics.php`, and dated by `database/seeders/Support/SeedDateGenerator.php` (always within 2023–today, never in the future).

<h2 id="testing">🧪 Testing</h2>

The project has three PHPUnit test suites, covering every admin module (Users, Roles, Permissions, Categories, Publications, Galleries, Menus, Submenus, Pages, Audit Logs) and the public site:

| Suite | Location | What it covers |
|-------|----------|-----------------|
| **Unit** | `tests/Unit/` | Models (fillable, relationships, casts) and the seeder `Support/` classes (content generation, media classification, date ranges) in isolation — no database |
| **Integration** | `tests/Feature/Admin/` | Each admin controller end-to-end: HTTP request → `AuthGates` permission check → controller → DB, including media uploads, category sync, and the audit log trail |
| **System** | `tests/Feature/System/` | Full user journeys on the public site — homepage, listings, search, publication/page show pages, login/logout, and a cross-module flow (admin creates content → content appears correctly on the public site) |

System tests run as full-stack Feature tests (real HTTP through the framework, real Blade rendering, an in-memory SQLite database) rather than through a browser — no Dusk/chromedriver dependency required.

```bash
# Run everything
docker compose exec app php artisan test
# or
docker compose exec app vendor/bin/phpunit

# Run a single suite
docker compose exec app vendor/bin/phpunit --testsuite=Unit
docker compose exec app vendor/bin/phpunit --testsuite=Integration
docker compose exec app vendor/bin/phpunit --testsuite=System

# Run a single test file or method
docker compose exec app vendor/bin/phpunit --filter=PublicationsControllerTest
```

Tests run against an isolated in-memory SQLite database (configured in `tests/bootstrap.php`), never against the real MySQL database defined in `.env` — running the suite is always safe on a dev or production container.

<h2 id="structure">🗂️ Project Structure</h2>

Standard Laravel structure, plus the Docker layer described above:

```
app/            Application code (Models, Http, Services, ...)
bootstrap/      Framework bootstrap files and cache
config/         Laravel configuration
database/       Migrations, seeders (incl. realistic fake data), factories, database/fake_media/ (sample photo acervo)
docker/         Docker build context (php, nginx, mysql) — see "Docker Environment"
public/         Web server document root (entry point, compiled assets)
resources/      Views (Blade), JS, and CSS sources
routes/         Route definitions
storage/        Logs, cache, and user-uploaded media
tests/          PHPUnit tests (Unit/, Feature/Admin/ = Integration, Feature/System/ = System) — see "Testing"
docker-compose.yml         Development stack
docker-compose.prod.yml    Production stack
.env.example                Single environment template (Docker-ready, see "Environment variables")
```
<h2 id="notes"> 📌 Final Notes</h2>

- This project was developed as a custom CMS for a municipal institution in Pernambuco.
- It was maintained for 6 months under a PJ contract and later discontinued by the client.
- The Docker environment described above was added afterwards to make the project easy to run locally and to deploy professionally on a VPS, without changing any existing application behavior.
