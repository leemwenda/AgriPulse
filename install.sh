#!/bin/bash

echo "========================================"
echo "AgriPulse - Dairy Farm Management System"
echo "Installation Script for Linux/Mac"
echo "========================================"
echo ""

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Function to print success message
success() {
    echo -e "${GREEN}✓ $1${NC}"
}

# Function to print error message
error() {
    echo -e "${RED}ERROR: $1${NC}"
    exit 1
}

# Check if composer is installed
if ! command -v composer &> /dev/null; then
    error "Composer is not installed. Please install Composer first."
fi

# Check if npm is installed
if ! command -v npm &> /dev/null; then
    error "NPM is not installed. Please install Node.js and NPM first."
fi

echo "[1/7] Installing Composer dependencies..."
composer install || error "Composer install failed!"
success "Composer dependencies installed"
echo ""

echo "[2/7] Installing NPM dependencies..."
npm install || error "NPM install failed!"
success "NPM dependencies installed"
echo ""

echo "[3/7] Setting up environment file..."
if [ ! -f .env ]; then
    cp .env.example .env
    success "Environment file created"
else
    success "Environment file already exists"
fi
echo ""

echo "[4/7] Generating application key..."
php artisan key:generate
success "Application key generated"
echo ""

echo "[5/7] Setting up SQLite database..."
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
    success "SQLite database file created"
else
    success "SQLite database file already exists"
fi
echo ""

echo "[6/7] Running migrations and seeders..."
php artisan migrate --seed || error "Migration failed!"
success "Database migrated and seeded"
echo ""

echo "[7/7] Building frontend assets..."
npm run build || error "Asset build failed!"
success "Frontend assets built"
echo ""

echo "========================================"
echo "Installation Complete! 🎉"
echo "========================================"
echo ""
echo "Your AgriPulse system is ready to use!"
echo ""
echo "To start the server, run:"
echo "  php artisan serve"
echo ""
echo "Then open your browser and go to:"
echo "  http://localhost:8000"
echo ""
echo "Login credentials:"
echo "  Email: admin@agripulse.com"
echo "  Password: password"
echo ""
echo "========================================"
