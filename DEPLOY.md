# Deployment

This project is deployed from GitHub to the cPanel production app at:

- Repo: `https://github.com/kasujjaisaac/devrootsacademy.git`
- Branch: `main`
- Production path: `/home/devruzww/public_html`

## Standard Deploy Flow

1. Push code to GitHub:

```bash
git push origin main
```

2. SSH into the server and move to the live app:

```bash
cd /home/devruzww/public_html
```

3. Check for unexpected local server changes before pulling:

```bash
git status
```

4. Pull the latest code:

```bash
git pull origin main
```

5. Run the Laravel deployment steps:

```bash
bash scripts/deploy-production.sh
```

## What The Deploy Script Does

The deploy script runs:

- `php artisan migrate --force`
- `php artisan storage:link`
- `php artisan view:clear`
- `php artisan view:cache`
- `php artisan config:clear`
- `php artisan config:cache`

## Safe Deploy Checklist

- Back up the production database before risky changes.
- Do not run `php artisan migrate:fresh` in production.
- Do not run `php artisan db:seed` in production unless intentionally required.
- Confirm `APP_ENV=production` and `APP_DEBUG=false` in production `.env`.
- Test the critical flows after deploy:
  - admin login
  - add/edit course
  - featured image rendering
  - homepage course listing
  - all courses page

## Troubleshooting

If `git pull` is blocked by local tracked changes:

```bash
git diff
git restore composer.lock
git pull --rebase origin main
```

If images do not render:

```bash
php artisan storage:link
ls -l public/storage
```

If the app throws runtime errors:

```bash
tail -n 100 storage/logs/laravel.log
```
