# DevRoots Academy

Laravel application for the DevRoots Academy public website and admin dashboard.

## Local Development

1. Install dependencies.
2. Copy `.env.example` to `.env`.
3. Configure the database.
4. Run migrations.
5. Start the app.

Typical commands:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
php artisan serve
```

## Deployment

Production deployment notes live in [DEPLOY.md](DEPLOY.md).
