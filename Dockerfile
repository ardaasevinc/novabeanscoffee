# ŞABLON KOPYASI (selquor/ci-sablon@ce3677a) — bu dosyayı projede düzenlemeyin; şablon değişince sablon-dagit.sh hepsini günceller.
# syntax=docker/dockerfile:1
# Laravel — Kubernetes image'ı (FrankenPHP: PHP + web sunucusu tek konteynerde).
# Ortak şablon: selquor/ci-sablon (laravel/Dockerfile). Projede kendi Dockerfile'ı varsa o kullanılır.
# Hedefler:  uygulama (canlı/test ortamı image'ı) · test (geliştirme paketleri; testleri pipeline çalıştırır)

# --- PHP paketleri (önyüz derlemesi Filament/Flux gibi vendor dosyalarına bakabilir) ---
FROM dunglas/frankenphp:1-php8.5 AS taban
RUN install-php-extensions bcmath exif gd intl opcache pcntl pdo_mysql pdo_pgsql redis zip \
 && cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
WORKDIR /app

FROM taban AS paketler
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction --no-progress

# --- Önyüz (Vite) ---
FROM node:22-alpine AS onyuz
WORKDIR /app
COPY . .
COPY --from=paketler /app/vendor ./vendor
RUN if grep -q '"build"' package.json 2>/dev/null; then (npm ci --no-audit --no-fund || npm install --no-audit --no-fund) && npm run build; \
    else mkdir -p public/build; fi

# --- Uygulama ---
FROM taban AS uygulama
COPY docker/php.ini "$PHP_INI_DIR/conf.d/zz-uygulama.ini"
# Gerçek ziyaretçi IP'si (Cloudflare/Traefik) ve sadece index.php çalıştırma: docker/Caddyfile
COPY docker/Caddyfile /etc/frankenphp/Caddyfile
# HTTP 8080 (TLS Traefik'te); loglar konteyner çıktısına.
ENV SERVER_NAME=:8080 \
    APP_ENV=production \
    LOG_CHANNEL=stderr
COPY --from=paketler /app/vendor ./vendor
COPY . .
COPY --from=onyuz /app/public/build ./public/build
# package:discover burada çalışmaz: açılışta veritabanına bakan uygulamalar derlemede düşer.
# Laravel paket listesini (bootstrap/cache/packages.php) ilk açılışta kendisi oluşturur.
RUN composer dump-autoload --optimize --no-dev --no-scripts \
 && rm -f bootstrap/cache/packages.php bootstrap/cache/services.php \
 && mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache public/uploads \
 && ln -sfn /app/storage/app/public public/storage \
 && chown -R www-data:www-data storage bootstrap/cache public/uploads /data/caddy /config/caddy

USER www-data
EXPOSE 8080

# Varsayılan hedef: uygulama
FROM uygulama
