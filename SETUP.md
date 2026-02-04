# AgriPulse - Dairy Farm Management System
## Setup Instructions

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL or SQLite database
- XAMPP (if using on Windows)

### Installation Steps

#### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

#### 2. Environment Configuration

```bash
# Copy the environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

#### 3. Database Configuration

Edit the `.env` file and configure your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agripulse
DB_USERNAME=root
DB_PASSWORD=
```

Or use SQLite for simplicity:

```env
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=agripulse
# DB_USERNAME=root
# DB_PASSWORD=
```

If using SQLite, create the database file:
```bash
# For Windows
type nul > database/database.sqlite

# For Linux/Mac
touch database/database.sqlite
```

#### 4. Run Migrations and Seeders

```bash
# Run migrations to create database tables
php artisan migrate

# Seed the database with admin and worker users
php artisan db:seed
```

#### 5. Build Frontend Assets

```bash
# Build assets for development
npm run dev

# Or build for production
npm run build
```

#### 6. Start the Development Server

```bash
# Start Laravel development server
php artisan serve
```

The application will be available at: `http://localhost:8000`

### Default Login Credentials

**Admin Account:**
- Email: `admin@agripulse.com`
- Password: `password`

**Worker Account:**
- Email: `worker@agripulse.com`
- Password: `password`

### Features Overview

#### 1. Dashboard
- Overview of total animals
- Today's milk production statistics
- Active pregnancies and upcoming births
- Monthly financial summary
- Health alerts
- Top producing animals
- Quick action buttons

#### 2. Animal Management
- Add, edit, view, and delete animals
- Track: name, tag number, breed, gender, date of birth, color, notes
- Filter by gender, breed, and status
- Search functionality

#### 3. Milk Production Tracking
- Record daily milk production per animal
- Quick record feature for batch entry
- View production history and trends
- Filter by date range and animal
- Production statistics and reports

#### 4. Health Records Management
- Record health conditions and treatments
- Track vaccinations
- Doctor/vet information
- Medical history per animal
- Filter and search capabilities

#### 5. Breeding Management
- Track service dates and expected birth dates
- Monitor pregnancy status
- View upcoming births
- Breeding success rate statistics
- Overdue birth alerts

#### 6. Financial Management
- Track income (milk sales, animal sales, etc.)
- Track expenses (feed, veterinary, labor, etc.)
- View profit/loss
- Financial reports and summaries
- Category-based filtering

#### 7. Worker Management (Admin Only)
- Add and manage worker accounts
- Track worker information
- View worker activity
- Reset worker passwords
- Activate/deactivate workers

#### 8. Reports & Analytics
- Milk production reports
- Animal health reports
- Breeding success reports
- Financial summaries
- Export capabilities

### User Roles

#### Admin
- Full access to all features
- Can add/remove workers
- Can delete records
- Access to all reports

#### Worker
- Can record milk production
- Can record health records
- Can record breeding information
- Can record financial transactions
- Limited deletion rights

### Technology Stack

- **Backend:** Laravel 12
- **Frontend:** Blade Templates, Tailwind CSS, Alpine.js
- **Database:** MySQL/SQLite
- **Authentication:** Laravel Breeze

### Development Commands

```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run tests
php artisan test
```

### Troubleshooting

#### Issue: "Class not found" errors
**Solution:** Run `composer dump-autoload`

#### Issue: Database connection errors
**Solution:** Check your `.env` file database credentials

#### Issue: Permission errors
**Solution:** Ensure storage and bootstrap/cache directories are writable
```bash
# Windows (run as administrator)
icacls storage /grant Users:F /T
icacls bootstrap/cache /grant Users:F /T
```

#### Issue: Assets not loading
**Solution:** Run `npm run build` and clear browser cache

### Support

For issues or questions, please refer to the Laravel documentation:
- https://laravel.com/docs

### License

This project is open-sourced software licensed under the MIT license.
