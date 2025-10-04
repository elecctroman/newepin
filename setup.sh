#!/usr/bin/env bash

set -euo pipefail

# --- Helper functions -------------------------------------------------------
log() {
    echo -e "\033[1;32m==>\033[0m $1"
}

error() {
    echo -e "\033[1;31m[ERROR]\033[0m $1" >&2
}

update_env() {
    local key="$1"
    local value="$2"
    value="${value//\\/\\\\}"
    value="${value//&/\\&}"
    value="${value//\//\\/}"
    if grep -q "^${key}=" .env; then
        sed -i "s/^${key}=.*/${key}=${value}/" .env
    else
        echo "${key}=${value}" >> .env
    fi
}

# --- Preconditions ----------------------------------------------------------
if [[ $(id -u) -ne 0 ]]; then
    error "Bu betiği root kullanıcısı veya sudo ile çalıştırmalısınız."
    exit 1
fi

export DEBIAN_FRONTEND=noninteractive
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_DIR="$SCRIPT_DIR"

APP_ENVIRONMENT="${APP_ENV:-production}"
APP_URL_VALUE="${APP_URL:-https://example.com}"
DB_DATABASE_VALUE="${DB_DATABASE:-newepin}"
DB_USERNAME_VALUE="${DB_USERNAME:-newepin_user}"
DB_PASSWORD_VALUE="${DB_PASSWORD:-}"
QUEUE_CONNECTION_VALUE="${QUEUE_CONNECTION:-database}"
REDIS_HOST_VALUE="${REDIS_HOST:-127.0.0.1}"
REDIS_PASSWORD_VALUE="${REDIS_PASSWORD:-null}"
REDIS_PORT_VALUE="${REDIS_PORT:-6379}"
ENABLE_UFW="${ENABLE_UFW:-true}"

if [[ -z "$DB_PASSWORD_VALUE" ]]; then
    DB_PASSWORD_VALUE="$(openssl rand -hex 16)"
fi

log "Apt paket kaynakları güncelleniyor"
apt-get update -y

log "Temel paketler yükleniyor"
apt-get install -y software-properties-common apt-transport-https ca-certificates lsb-release curl unzip git gnupg build-essential ufw

log "Ondřej PHP deposu ekleniyor"
add-apt-repository -y ppa:ondrej/php
apt-get update -y

log "PHP 8.2 ve gerekli uzantılar yükleniyor"
apt-get install -y \
    php8.2 php8.2-cli php8.2-fpm php8.2-common php8.2-mysql php8.2-mbstring \
    php8.2-xml php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath php8.2-intl php8.2-soap php8.2-readline

log "MySQL sunucusu kuruluyor"
if ! dpkg -s mysql-server >/dev/null 2>&1; then
    apt-get install -y mysql-server
fi
systemctl enable --now mysql

log "Redis sunucusu kuruluyor"
if ! dpkg -s redis-server >/dev/null 2>&1; then
    apt-get install -y redis-server
fi
systemctl enable --now redis-server

log "Node.js 18 deposu ekleniyor"
if ! command -v node >/dev/null 2>&1 || [[ $(node -v | sed 's/v//' | cut -d'.' -f1) -lt 18 ]]; then
    curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
    apt-get install -y nodejs
fi

log "Composer kurulumu kontrol ediliyor"
if ! command -v composer >/dev/null 2>&1; then
    EXPECTED_SIGNATURE="$(curl -fsSL https://composer.github.io/installer.sig)"
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    ACTUAL_SIGNATURE="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"
    if [[ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]]; then
        rm composer-setup.php
        error "Composer kurulum dosyasının imzası doğrulanamadı."
        exit 1
    fi
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    rm composer-setup.php
fi

log "Supervisor kuruluyor (queue yönetimi için)"
if ! dpkg -s supervisor >/dev/null 2>&1; then
    apt-get install -y supervisor
fi
systemctl enable --now supervisor

if [[ "$ENABLE_UFW" == "true" ]]; then
    log "Firewall temel ayarları uygulanıyor"
    ufw allow OpenSSH || true
    ufw allow 'Nginx Full' || true
    if ufw status | grep -qi inactive; then
        ufw --force enable || true
    fi
fi

log "PHP-FPM servisi etkinleştiriliyor"
systemctl enable --now php8.2-fpm

log "Nginx kuruluyor"
if ! dpkg -s nginx >/dev/null 2>&1; then
    apt-get install -y nginx
fi
systemctl enable --now nginx

log "Proje dizinine geçiliyor: $PROJECT_DIR"
cd "$PROJECT_DIR"

if [[ ! -f .env ]]; then
    log ".env dosyası oluşturuluyor"
    cp .env.example .env
fi

log "MySQL veritabanı ve kullanıcı yapılandırılıyor"
MYSQL_ROOT_PASSWORD="${MYSQL_ROOT_PASSWORD:-}"
if [[ -n "$MYSQL_ROOT_PASSWORD" ]]; then
    export MYSQL_PWD="$MYSQL_ROOT_PASSWORD"
fi
mysql -u root <<SQL
CREATE DATABASE IF NOT EXISTS \`$DB_DATABASE_VALUE\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '$DB_USERNAME_VALUE'@'localhost' IDENTIFIED WITH mysql_native_password BY '$DB_PASSWORD_VALUE';
GRANT ALL PRIVILEGES ON \`$DB_DATABASE_VALUE\`.* TO '$DB_USERNAME_VALUE'@'localhost';
FLUSH PRIVILEGES;
SQL
if [[ -n "$MYSQL_ROOT_PASSWORD" ]]; then
    unset MYSQL_PWD
fi

log ".env dosyası güncelleniyor"
update_env "APP_ENV" "$APP_ENVIRONMENT"
update_env "APP_URL" "$APP_URL_VALUE"
update_env "DB_DATABASE" "$DB_DATABASE_VALUE"
update_env "DB_USERNAME" "$DB_USERNAME_VALUE"
update_env "DB_PASSWORD" "$DB_PASSWORD_VALUE"
update_env "QUEUE_CONNECTION" "$QUEUE_CONNECTION_VALUE"
update_env "REDIS_HOST" "$REDIS_HOST_VALUE"
update_env "REDIS_PASSWORD" "$REDIS_PASSWORD_VALUE"
update_env "REDIS_PORT" "$REDIS_PORT_VALUE"

log "Composer bağımlılıkları yükleniyor"
composer install --no-interaction --prefer-dist --optimize-autoloader

if [[ -f package.json ]]; then
    log "NPM bağımlılıkları yükleniyor"
    npm install --legacy-peer-deps

    log "Ön yüz varlıkları derleniyor"
    if npm run build; then
        :
    else
        error "npm run build komutu başarısız oldu"
        exit 1
    fi
else
    log "package.json bulunamadı, npm adımları atlanıyor"
fi

log "Laravel uygulaması yapılandırılıyor"
php artisan key:generate --force
php artisan migrate --force --seed
php artisan storage:link || true

log "İzinler düzenleniyor"
chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache

log "Queue worker için Supervisor örnek yapılandırması oluşturuluyor"
SUPERVISOR_CONF="/etc/supervisor/conf.d/newepin-worker.conf"
cat <<'SUPERVISOR' > "$SUPERVISOR_CONF"
[program:newepin-worker]
process_name=%(program_name)s_%(process_num)02d
command=php $PROJECT_DIR/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/log/newepin-queue.log
stopwaitsecs=3600
SUPERVISOR
sed -i "s|\$PROJECT_DIR|$PROJECT_DIR|g" "$SUPERVISOR_CONF"
supervisorctl reread
supervisorctl update

log "Nginx site yapılandırması oluşturuluyor"
NGINX_CONF="/etc/nginx/sites-available/newepin.conf"
cat <<'NGINX' > "$NGINX_CONF"
server {
    listen 80;
    server_name _;
    root $PROJECT_DIR/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
NGINX
sed -i "s|\$PROJECT_DIR|$PROJECT_DIR|g" "$NGINX_CONF"

ln -sf "$NGINX_CONF" /etc/nginx/sites-enabled/newepin.conf
rm -f /etc/nginx/sites-enabled/default
nginx -t
systemctl reload nginx

log "Kurulum tamamlandı."
log "Veritabanı kullanıcı bilgileri:"
echo "  DB_DATABASE=$DB_DATABASE_VALUE"
echo "  DB_USERNAME=$DB_USERNAME_VALUE"
echo "  DB_PASSWORD=$DB_PASSWORD_VALUE"

exit 0
