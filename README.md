# Mycamstars
## Project structure

### Backend 
The API written in Laravel is here, local build in backend/README.md file. Uses MongoDb for parsing the cam feeds and saving them, then pusting them to mysql with commands.

For deployment:
backend/docker-compose.yml and backend/.env.prod can be used as a starting point to see what all is needed

### Frontend
The UI is written in Vuejs and uses Vite, local build in frontend/README.md file.


## Deployment

### Set up server

1. `git pull` on the server /var/www/...
2. set up nginx/sites-enabled to point to backend/public/index.php and frontend/dist/index.html, generate letsencrypt certificates, add them to the config
3. set up DNS A record for subdomain in cloudflare

### Backend - only first time deploy
1. run commands 
```bash
cd backend
cp .env.prod .env
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
php artisan key:generate
php artisan storage:link
chgrp -R www-data storage bootstrap/cache && chmod -R ug+rwx storage bootstrap/cache && chmod -R 775 storage && chmod -R 775 bootstrap/cache && chown -R $USER:www-data storage && chown -R $USER:www-data bootstrap/cache && chmod -R gu+w storage && chmod -R guo+w storage
```
2. set .env variable `APP_URL=<domain-set-in-step-2-nginx>`,
3. set up mysql, mongodb, set up .env variables
4. the app should be visible on the backend domain, next time only use deployment through composer scriptf

### Frotend - only first time deploy
1. create .env and inside put `VITE_APP_API_URL=<domain-set-in-step-2-nginx>`
2. run commands 
```bash
cd frontend
npm install && npm run build
```
3. the app should be visible on the frontend domain, next time only use deployment through composer scriptf


### Deploying both FE and BE with composer script
1. `git pull`
2. `cd backend && composer deploy` - runs instalation/build for both BE and FE and sets correct permissions
3. the app should be updated with changes from commits

