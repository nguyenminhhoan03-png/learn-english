#!/bin/sh
set -e

echo "🚀 Starting EduLearn Production Container..."

# Ensure storage directories exist and have proper permissions
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create public storage symlink if not present
if [ ! -L /var/www/html/public/storage ]; then
    echo "🔗 Creating storage symlink..."
    php /var/www/html/artisan storage:link || true
fi

# Ensure APP_KEY is set
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application encryption key..."
    php /var/www/html/artisan key:generate --force || true
fi

# Setup Laravel scheduler cron
echo "* * * * * cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1" > /etc/crontabs/root

# Wait for MySQL database if configured
if [ "$DB_CONNECTION" = "mysql" ] && [ -n "$DB_HOST" ]; then
    echo "⏳ Waiting for MySQL ($DB_HOST:$DB_PORT) to become available..."
    MAX_TRIES=30
    COUNT=0
    until php -r "try { new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . (getenv('DB_PORT') ?: '3306') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), [PDO::ATTR_TIMEOUT => 2]); echo 'Connected'; exit(0); } catch (Exception \$e) { exit(1); }" > /dev/null 2>&1; do
        COUNT=$((COUNT + 1))
        if [ $COUNT -ge $MAX_TRIES ]; then
            echo "⚠️ Warning: Database connection timed out after $MAX_TRIES attempts. Proceeding anyway..."
            break
        fi
        echo "Database is initializing... attempt ($COUNT/$MAX_TRIES). Retrying in 2s..."
        sleep 2
    done
    echo "✅ Database connection established!"
fi

# Run database migrations if enabled
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "📦 Running database migrations..."
    php /var/www/html/artisan migrate --force || true
fi

# Run database seeders if enabled
if [ "$SEED_DATABASE" = "true" ]; then
    echo "🌱 Seeding database with full test sets, roadmaps, and vocabulary..."
    php /var/www/html/artisan db:seed --force || true
fi

# Optimize Laravel for production if APP_ENV is production
if [ "$APP_ENV" = "production" ]; then
    echo "⚡ Optimizing Laravel caches for production..."
    php /var/www/html/artisan config:cache || true
    php /var/www/html/artisan route:cache || true
    php /var/www/html/artisan view:cache || true
    php /var/www/html/artisan event:cache || true
fi

echo "✅ Container initialization complete. Launching Supervisor..."
exec "$@"
