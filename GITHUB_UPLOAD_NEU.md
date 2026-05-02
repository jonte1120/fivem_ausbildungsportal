# Neu auf GitHub hochladen und dauerhaft hosten

## 1. Projekt auf GitHub neu hochladen

Oeffne PowerShell und fuehre aus:

```powershell
cd "C:\Users\jonte\Documents\New project\fivem_ausbildungsportal"
git status
git add .
git commit -m "Prepare Railway deployment"
git branch -M main
git push -u origin main
```

Falls du das GitHub-Repository komplett neu erstellt hast, setze vorher den neuen Remote-Link:

```powershell
git remote remove origin
git remote add origin https://github.com/DEINNAME/DEIN-REPO.git
git push -u origin main
```

## 2. Railway einrichten

1. https://railway.com/new oeffnen
2. `Deploy from GitHub repo` waehlen
3. Dein Repository auswaehlen
4. Im Railway-Projekt `New` -> `Database` -> `PostgreSQL` hinzufuegen
5. App-Service anklicken, also die Kachel mit deinem Repository-Namen
6. `Variables` oeffnen
7. Variablen aus `.env.railway.example` eintragen
8. Deploy starten oder `Redeploy` klicken

## 3. Nach dem ersten Deploy

1. App-Service anklicken
2. `Settings` -> `Networking`
3. `Generate Domain`
4. Die neue Domain kopieren
5. In `Variables` die Variable `APP_URL` auf diese Domain setzen
6. Noch einmal `Redeploy`

## 4. Wichtig bei Discord Login

Wenn Discord Login genutzt wird, muss in der Discord Developer Console diese Redirect URL stehen:

```text
https://DEINE-DOMAIN/discord/callback
```

## 5. Wichtige Railway Variablen

Diese Variable behebt den Build-Fehler mit fehlender ZIP-Extension:

```env
RAILPACK_PHP_EXTENSIONS=zip,pdo_pgsql,pgsql
```

Diese Datenbankvariablen nutzen die Railway PostgreSQL-Datenbank:

```env
DB_CONNECTION=pgsql
DB_URL=${{Postgres.DATABASE_URL}}
```
