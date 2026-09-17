#!/bin/bash
set -e

echo "Iniciando deployment de RebelKMB..."

PROJECT_DIR="/var/www/rebelkmb"
cd "$PROJECT_DIR"

# Actualiza el código desde GitHub asegurando la rama de producción
# (reset --hard evita que un archivo generado localmente, como package-lock.json,
# bloquee el deploy con un conflicto de merge)
git fetch origin main
git reset --hard origin/main

# Instala dependencias PHP limpias
composer install --no-dev --optimize-autoloader

# Instala y compila los recursos de frontend (Node/Vite)
npm install
npm run build

# Actualiza la base de datos MariaDB
php artisan migrate --force

# Limpia y reconstruye toda la caché de Laravel 12
php artisan optimize:clear
php artisan optimize
php artisan view:cache

# Normaliza los permisos de seguridad (deploy ya es dueño, solo ajustamos modos)
# Se excluyen node_modules y vendor: contienen binarios (vite, etc.) que necesitan
# mantener su permiso de ejecución entre deploys
find "$PROJECT_DIR" -type f -not -path "*/node_modules/*" -not -path "*/vendor/*" -exec chmod 644 {} \;
find "$PROJECT_DIR" -type d -not -path "*/node_modules/*" -not -path "*/vendor/*" -exec chmod 755 {} \;
chmod +x "$PROJECT_DIR/artisan"

# Permisos de escritura estrictamente donde Nginx/PHP-FPM los necesita
chmod -R 775 "$PROJECT_DIR/storage"
chmod -R 775 "$PROJECT_DIR/bootstrap/cache"

echo "Deployment de RebelKMB completado exitosamente"