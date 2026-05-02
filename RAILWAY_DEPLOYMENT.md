# Railway Deployment

Dieses Laravel-Projekt kann direkt aus GitHub auf Railway deployed werden.

## Railway-Projekt anlegen

1. Gehe zu https://railway.com/new
2. Waehle `Deploy from GitHub repo`
3. Waehle dieses Repository aus
4. Fuege im selben Railway-Projekt eine `Postgres` Datenbank hinzu
5. Oeffne den App-Service und setze die Environment-Variablen unten
6. Deploy starten
7. Danach im App-Service unter `Settings > Networking` auf `Generate Domain` klicken

## Wichtige Variablen

Setze diese Variablen im App-Service:

```env
APP_NAME="Ausbildungsportal"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://DEINE-RAILWAY-DOMAIN.up.railway.app
APP_TIMEZONE=Europe/Berlin
APP_LOCALE=de
APP_FALLBACK_LOCALE=de
APP_FAKER_LOCALE=de_DE

APP_KEY=

DB_CONNECTION=pgsql
DB_URL=${{Postgres.DATABASE_URL}}

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

LOG_CHANNEL=stderr
LOG_LEVEL=info

LOGIN_ALLOWED=true
REGISTRATION_ALLOWED=true
APP_PREVENT_LAZY_LOADING=false
APP_THEME=dark
CDN_URL=

SUPERADMIN_USERS=
DEFAULT_MEETING_POINT=
PRIMARY_GUILD_NAME=""

P12_KEY_NAME=""
P12_PASSWORD=""
PDF_CERTIFICATE_ORGANISATION_NAME=""
PDF_CERTIFICATE_SUB_NAME=""
```

`APP_KEY` muss ein Laravel-Key sein. Lokal erzeugst du ihn mit:

```bash
php artisan key:generate --show
```

Falls du lokal kein PHP hast, kannst du kurz `APP_KEY` leer lassen, deployen, dann in Railway eine Shell/Command nutzen oder lokal PHP installieren und den Key nachtragen. Ohne gueltigen `APP_KEY` laeuft Laravel nicht korrekt.

## Build- und Migrationsablauf

Die Datei `railway.toml` sagt Railway:

- Railpack verwenden
- Frontend-Assets mit `npm run build` bauen
- vor dem Start `php artisan migrate --force` ausfuehren
- Laravel-Caches fuer Produktion aufbauen

Railway erkennt Laravel automatisch und startet es mit PHP-FPM/Caddy.

## Nach dem ersten Deploy

1. Domain generieren
2. `APP_URL` auf die generierte Domain setzen
3. Erneut deployen
4. Falls Discord-Login genutzt wird, Discord OAuth Redirect URL setzen:

```text
https://DEINE-DOMAIN/discord/callback
```
