#!/bin/bash

# ============================================================
#  Script de setup — Desafío Técnico Laravel
#  Ejecutar UNA SOLA VEZ para configurar el proyecto
# ============================================================

set -e

echo ""
echo "=== Desafío Técnico — Setup ==="
echo ""

# 1. Instalar dependencias
echo "→ Instalando dependencias..."
composer install --no-interaction --quiet

# 2. Copiar .env si no existe
if [ ! -f .env ]; then
    cp .env.example .env
    echo "→ Archivo .env creado."
fi

# 3. Generar app key
php artisan key:generate --quiet
echo "→ App key generada."

# 4. Crear base de datos SQLite (para simplicidad)
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
    echo "→ Base de datos SQLite creada."
fi

# Asegurarse que .env use SQLite
sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env
sed -i '/DB_HOST/d' .env
sed -i '/DB_PORT/d' .env
sed -i '/DB_DATABASE/d' .env
sed -i '/DB_USERNAME/d' .env
sed -i '/DB_PASSWORD/d' .env

# 5. Migraciones y seeders
echo "→ Ejecutando migraciones y seeders..."
php artisan migrate:fresh --seed --quiet

# 6. Instalar dependencias npm y compilar assets
echo "→ Instalando dependencias npm..."
npm install --silent
npm run build --silent

echo ""
echo "✅ Setup completo."
echo ""
echo "Usuarios de prueba:"
echo "  ana@test.com    / password"
echo "  carlos@test.com / password"
echo ""
echo "Iniciá el servidor con:"
echo "  php artisan serve"
echo ""
