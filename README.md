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
|---------------|-----------------------------------------|
| Permissions   | Manage access control permissions      |
| Roles         | Define user roles and assign permissions |
| Users         | Admin user management                  |
| Audit Logs    | System activity tracking               |
| Menus         | Main navigation structure               |
| Submenus      | Secondary navigation structure          |
| Pages         | Static institutional pages              |
| Publications  | Create, edit, delete news articles      |
| Categories    | Tag management                          |
| Galleries     | Manage photo collections                |
| Profile       | Password update and profile management  |

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

# Create an empty database matching your .env DB_* variables, then run
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

<h2 id="docker">🐳 Docker Environment</h2>

The project ships with two independent Docker Compose files, so the exact same codebase can run in either a fully-featured **development** setup or a lean, optimized **production** setup — switching between them never requires touching a Dockerfile or Nginx config, only environment variables.

### Why this structure

- **Separation of concerns**: PHP-FPM, Nginx, MySQL and Redis each run in their own container/image, following the single-responsibility principle at the infrastructure level.
- **One Dockerfile, two targets**: `docker/php/Dockerfile` uses Docker multi-stage builds (`development` and `production` targets) instead of two separate Dockerfiles, so shared setup (system packages, PHP extensions, FPM pool config) lives in a single `base` stage — avoiding duplicated, drifting configuration (DRY).
- **A dedicated `frontend-builder` stage** compiles Vite assets during the production image build, so the final runtime image never needs Node.js installed (keeps the production image lean).
- **A single `.env`** is read by both Laravel and Docker Compose (Compose auto-loads a `.env` file placed next to `docker-compose.yml`). This is why `APP_PORT`, `DB_DATABASE`, etc. only need to be defined once and are shared by the app and the infrastructure.
- **`docker/mysql/my.cnf` is baked into a small custom image (`docker/mysql/Dockerfile`) instead of bind-mounted.** MySQL silently ignores config files it considers world-writable, which is exactly how bind-mounted files are presented on Docker Desktop for Windows/macOS — the container would boot with the custom charset/tuning quietly never applied. Building it into the image sidesteps host-dependent file permissions entirely.
- **The development PHP-FPM pool (`docker/php/www.dev.conf`) runs as root; production (`docker/php/www.conf`) runs as a real non-root user.** In development the code is bind-mounted from the host, and `chown` has no real effect on bind-mounted files under Docker Desktop, so a non-root pool would be unable to write to `storage/`. In production the code is copied into the image at build time with correct ownership, so a real non-root user works without caveats.

### Directory layout

```
docker/
├── php/
│   ├── Dockerfile          # multi-stage: base -> development / frontend-builder / production
│   ├── php.ini              # PHP settings for development
│   ├── php.prod.ini         # PHP settings for production (OPcache tuned)
│   ├── www.conf             # PHP-FPM pool for production (real non-root user)
│   ├── www.dev.conf         # PHP-FPM pool for development (runs as root, see note below)
│   ├── entrypoint.dev.sh    # composer install / key:generate / storage:link on boot
│   └── entrypoint.prod.sh   # cache:config/route/view + publishes public/ for Nginx
├── nginx/
│   ├── Dockerfile            # production image (bakes default.conf in)
│   └── default.conf          # shared Nginx vhost (gzip, security headers, PHP-FPM upstream)
└── mysql/
    ├── Dockerfile             # bakes my.cnf into the image (see note below)
    └── my.cnf                 # utf8mb4 charset/collation, connection tuning

docker-compose.yml         # development stack (app, webserver, node, mysql, redis)
docker-compose.prod.yml    # production stack (app, webserver, mysql, redis)
.env.example                # single template, ready for Docker; comments mark what to change without Docker
.dockerignore
```

### Development stack (`docker-compose.yml`)

| Service     | Description                                              | Exposed port (host)         |
|-------------|-----------------------------------------------------------|------------------------------|
| `app`       | PHP 8.3-FPM (Alpine), code bind-mounted for live reload    | —                             |
| `webserver` | Nginx, serves the app and proxies `.php` to `app`          | `${APP_PORT:-8000}` → 80     |
| `node`      | Vite dev server (hot module replacement)                   | `${VITE_PORT:-5173}` → 5173  |
| `mysql`     | MySQL 8.0                                                   | `${FORWARD_DB_PORT:-3306}` → 3306 |
| `redis`     | Redis 7 (available for future use, see below)               | `${FORWARD_REDIS_PORT:-6379}` → 6379 |

The project's code is bind-mounted into `app` and `webserver`, so changes to PHP/Blade files are reflected immediately — no rebuild needed. `vendor/` and `node_modules/` use **named volumes** instead of the bind mount, so dependencies installed inside the container (Linux binaries) are never shadowed or overwritten by whatever exists on the host.

### Production stack (`docker-compose.prod.yml`)

| Service     | Description                                                        |
|-------------|----------------------------------------------------------------------|
| `app`       | PHP 8.3-FPM, built from the `production` target: `composer install --no-dev --optimize-autoloader`, compiled Vite assets baked in, runs as a non-root user |
| `webserver` | Nginx, built from `docker/nginx/Dockerfile`                          |
| `mysql`     | MySQL 8.0 (no port published to the host by default)                 |
| `redis`     | Redis 7 (no port published to the host by default)                   |

No bind mounts in production — the image is immutable and contains everything it needs. Since `app` and `webserver` are separate containers, they don't share a filesystem by default; `docker/php/entrypoint.prod.sh` publishes `public/` into the named volume `public_assets` **on every container start** (not only once), specifically so that a redeploy with new Vite-hashed filenames always reaches Nginx — a named volume is otherwise only auto-seeded by Docker the first time it's created. User-uploaded media (`storage/app/public`) lives in its own persistent volume (`storage_public`), mounted read-write in `app` and read-only in `webserver`.

### Dynamic HTTP port

Because this VPS hosts multiple Docker projects, the HTTP port is never hardcoded. Both compose files map:

```yaml
ports:
    - "${APP_PORT:-8000}:80"
```

Change it by editing a single line in `.env` — no Docker file needs to change:

```env
APP_PORT=8085
```

If `APP_PORT` is not set, it defaults to **8000**. The same pattern is used for the other host-facing ports (`FORWARD_DB_PORT`, `FORWARD_REDIS_PORT`, `VITE_PORT`) to avoid collisions with other projects on the same server.

### Environment variables

There is a single `.env.example`, copied to `.env` regardless of how you run the project. It ships ready for Docker; every line that needs a different value without Docker has a `# sem Docker:` comment right above it (currently `DB_HOST` and `REDIS_HOST`, since those must point to Docker service names — `mysql`/`redis` — instead of `127.0.0.1`).

Key variables:

```env
APP_NAME=Saire
APP_ENV=local            # local | production
APP_KEY=                 # generated by `artisan key:generate`
APP_DEBUG=true            # false in production
APP_URL=http://localhost:${APP_PORT}

APP_PORT=8000             # Nginx host port (see "Dynamic HTTP port" above)
FORWARD_DB_PORT=3306       # MySQL host port (dev only)
FORWARD_REDIS_PORT=6379    # Redis host port (dev only)
VITE_PORT=5173             # Vite dev server host port (dev only)

DB_CONNECTION=mysql
DB_HOST=mysql              # the MySQL *service name*, not localhost, inside Docker — 127.0.0.1 without Docker
DB_PORT=3306
DB_DATABASE=saire
DB_USERNAME=saire
DB_PASSWORD=secret
MYSQL_ROOT_PASSWORD=root_secret   # only read by the mysql container

REDIS_HOST=redis           # same idea — 127.0.0.1 without Docker
```

> The Redis container is included so the project **can** use it, without changing current behavior: `CACHE_DRIVER`, `SESSION_DRIVER` and `QUEUE_CONNECTION` stay on `file`/`sync` by default. To adopt Redis, run `composer require predis/predis` and switch the relevant driver(s) to `redis`.

### Useful commands

```bash
# Start containers (development)
docker compose up -d

# Start containers (production)
docker compose -f docker-compose.prod.yml up -d --build

# Stop containers
docker compose down

# Rebuild after Dockerfile/dependency changes
docker compose up -d --build

# Open a shell inside the app container
docker exec -it saire_app bash

# Run migrations
docker compose exec app php artisan migrate

# Run seeders
docker compose exec app php artisan db:seed

# Clear all caches
docker compose exec app php artisan optimize:clear

# Generate the application key
docker compose exec app php artisan key:generate

# Tail logs
docker compose logs -f app
docker compose logs -f webserver
```

### Deploying 

1. **Install Docker** (if not already present):
    ```bash
    curl -fsSL https://get.docker.com | sh
    sudo usermod -aG docker $USER
    ```
2. **Clone the repository** into the server:
    ```bash
    git clone https://github.com/issagomesdev/saire.git
    cd saire
    ```
3. **Configure the environment**:
    ```bash
    cp .env.example .env
    ```
    Edit `.env` and set at least:
    ```env
    APP_ENV=production
    APP_DEBUG=false
    APP_URL=https://your-domain.gov.br
    APP_PORT=8000            # pick a free port if this VPS already runs other Docker apps
    APP_KEY=                 # leave empty, generated in the next step
    DB_DATABASE=saire
    DB_USERNAME=saire
    DB_PASSWORD=<strong-password>
    MYSQL_ROOT_PASSWORD=<strong-password>
    ```
4. **Build and start the production stack**:
    ```bash
    docker compose -f docker-compose.prod.yml up -d --build
    ```
5. **Generate the application key** (first deploy only):
    ```bash
    docker compose -f docker-compose.prod.yml exec app php artisan key:generate --force
    ```
6. **Run migrations** (first deploy, or set `RUN_MIGRATIONS=true` in `.env` to run them automatically on every container start):
    ```bash
    docker compose -f docker-compose.prod.yml exec app php artisan migrate --force
    ```
7. Put the server behind a reverse proxy with TLS (e.g. an existing Nginx/Traefik/Caddy on the host, or Certbot) pointing at `127.0.0.1:${APP_PORT}` — the container itself only serves plain HTTP, which is the standard setup when a VPS hosts several Dockerized sites behind one HTTPS-terminating proxy.

**Updating a running deployment:**

```bash
git pull
docker compose -f docker-compose.prod.yml up -d --build
```

Rebuilding recreates the `app` and `webserver` images with the new code, recompiled assets, and republishes `public/` to the shared volume automatically (see [Production stack](#docker) above) — the database and uploaded media persist untouched in their volumes.

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
