composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader
npm install --production
npm run build
php artisan config:cache
php artisan view:cache
php artisan migrate