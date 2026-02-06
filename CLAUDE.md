# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Symfony 8.0 one-page corporate website ("BusinessPro") for a professional services company. PHP 8.4+, MySQL 8.0, EasyAdmin for back-office, Stimulus/Turbo for frontend interactivity. Asset management uses Symfony AssetMapper (importmap), not Webpack/Vite.

## Commands

### Development Server
```bash
php -S localhost:8000 -t public/
```

### Code Quality (matches CI pipeline)
```bash
# PHP CS Fixer - check style
vendor/bin/php-cs-fixer fix --dry-run --diff

# PHP CS Fixer - auto-fix
vendor/bin/php-cs-fixer fix

# PHPStan static analysis (requires cache warmup first)
php bin/console cache:warmup --env=dev
vendor/bin/phpstan analyse --no-progress
```

### Tests
```bash
vendor/bin/phpunit              # all tests
vendor/bin/phpunit tests/path   # single test file
```

### Database
```bash
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:migrations:migrate
```

### Docker (PostgreSQL + Mailpit for local email)
```bash
docker compose up -d
```

## Architecture

**MVC + Repository pattern**, standard Symfony structure:

- `src/Entity/` — Doctrine ORM entities using PHP attributes (`Avis` = customer reviews, `Realisation` = project showcases). Both have an `actif` boolean field to toggle visibility.
- `src/Repository/` — Custom query methods (`findActifs()`, `findActives()`) return only active records ordered by newest first.
- `src/Controller/HomeController.php` — Single public route (`/`) rendering `home/index.html.twig` with active avis and realisations.
- `src/Controller/Admin/` — EasyAdmin CRUD controllers. `DashboardController` at `/admin` links to `AvisCrudController` and `RealisationCrudController`.
- `templates/base.html.twig` — Master layout (header, footer, scroll-to-top, CSS/JS includes).
- `templates/home/index.html.twig` — Full one-page with sections: hero, prestations, a-propos, avis, realisations, contact.
- `assets/app.js` — Entry point, loads Stimulus controllers and custom JS (scroll animations, counter effects).
- `assets/styles/app.css` — All custom CSS including animations and responsive design.

**Frontend stack:** Stimulus.js 3.2 + Turbo 7.3 via Symfony UX. JS dependencies managed through `importmap.php` (use `php bin/console importmap:require <package>` to add packages).

## Code Style

PHP CS Fixer enforces `@Symfony` rules with: short array syntax, alphabetical imports, no unused imports, single quotes, trailing commas in multiline. PHPStan runs at level 6 with the Symfony extension.

## CI

GitHub Actions on push/PR to master/main runs two jobs: PHP CS Fixer (dry-run check) and PHPStan (with cache warmup). No automated test execution in CI yet.

## Database

Local dev uses MySQL 8.0 at `mysql://root:@127.0.0.1:3306/onepage`. Docker Compose provides PostgreSQL 16 + Mailpit as an alternative. Adjust `DATABASE_URL` in `.env.local` accordingly.
