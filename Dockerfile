# Laravel PHP 8.3 + Vite - Render
FROM php:8.3-cli

# Dépendances système + extensions PHP pour Laravel + Filament + SQLite/Postgres/MySQL
RUN apt-get update && apt-get install -y --no-install-recommends \
    git curl unzip zip sqlite3 libsqlite3-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libzip-dev libpq-dev libicu-dev libcurl4-openssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo_mysql pdo_pgsql pdo_sqlite mbstring exif pcntl bcmath gd zip intl opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Node 20 pour Vite
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm --version && node --version

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Dépendances PHP d'abord (cache Docker)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Code complet
COPY . .

# Build frontend + dépendances finales
RUN composer install --no-dev --optimize-autoloader \
    && npm install \
    && npm run build \
    && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache database \
    && touch database/database.sqlite \
    && chown -R www-data:www-data storage bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache \
    && php artisan storage:link || true

EXPOSE 10000

# Render fournit $PORT. Migration + seed si base vide + cache + serve
CMD sh -c "touch database/database.sqlite && php artisan migrate --force --seed && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=\${PORT:-10000}"
