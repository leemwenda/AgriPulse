# AgriPulse - Quick Start Guide

## 🚀 Get Started in 5 Minutes!

### Step 1: Install Dependencies
```bash
composer install
npm install
```

### Step 2: Setup Environment
```bash
# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### Step 3: Configure Database
Open `.env` file and set database to SQLite for quick setup:
```env
DB_CONNECTION=sqlite
```

Create SQLite database file:
```bash
# Windows
type nul > database/database.sqlite

# Linux/Mac
touch database/database.sqlite
```

### Step 4: Setup Database
```bash
# Run migrations
php artisan migrate

# Seed with admin user
php artisan db:seed
```

### Step 5: Build Assets & Start Server
```bash
# Build frontend assets
npm run build

# Start Laravel server
php artisan serve
```

### Step 6: Login
Open your browser and go to: **http://localhost:8000**

**Login Credentials:**
- Email: `admin@agripulse.com`
- Password: `password`

---

## 🎯 What You Can Do Now

### 1. Dashboard
- View farm statistics
- See today's milk production
- Check upcoming births
- Monitor financial summary

### 2. Manage Animals
- Go to **Animals** menu
- Click "Add Animal" to create your first dairy cow
- Fill in: name, tag number, breed, gender, date of birth

### 3. Record Milk Production
- Go to **Milk Production** menu
- Click "Quick Record" for batch entry
- Or add individual production records

### 4. Track Health
- Go to **Health** menu
- Record health conditions
- Track vaccinations
- Monitor treatments

### 5. Manage Breeding
- Go to **Breeding** menu
- Record service dates
- Track pregnancies
- View upcoming births

### 6. Financial Tracking
- Go to **Financial** menu
- Record income (milk sales, etc.)
- Record expenses (feed, vet, etc.)
- View profit/loss

### 7. Generate Reports
- Go to **Reports** menu
- View milk production reports
- Check breeding success rates
- Analyze financial performance

### 8. Manage Workers (Admin Only)
- Go to **Workers** menu
- Add worker accounts
- Assign roles and permissions

---

## 📊 Sample Data (Optional)

Want to test with sample data? Create a sample data seeder:

```bash
php artisan make:seeder SampleDataSeeder
```

Then add sample animals, production records, etc.

---

## 🔧 Common Commands

```bash
# Clear all caches
php artisan optimize:clear

# Fresh start (WARNING: Deletes all data)
php artisan migrate:fresh --seed

# View routes
php artisan route:list

# Run in development mode with hot reload
npm run dev
# Then in another terminal:
php artisan serve
```

---

## 💡 Tips

1. **Use Quick Record** for daily milk production - it's faster!
2. **Set up workers** to track who records what
3. **Check dashboard daily** for alerts and upcoming events
4. **Use filters** in list views to find specific records
5. **Export reports** for record keeping

---

## 🆘 Need Help?

- Check `SETUP.md` for detailed setup instructions
- Check `TODO.md` for implementation status
- Review Laravel documentation: https://laravel.com/docs

---

## 🎉 You're All Set!

Your AgriPulse Dairy Farm Management System is ready to use. Start managing your dairy farm efficiently!

**Happy Farming! 🐄🥛**
