# 🐄 AgriPulse - Dairy Farm Management System

> A comprehensive web-based solution for managing dairy farm operations, built with Laravel 12

[![Laravel](https://img.shields.io/badge/Laravel-12.0-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.0-38B2AC.svg)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Screenshots](#screenshots)
- [Quick Start](#quick-start)
- [Installation](#installation)
- [Usage](#usage)
- [Technology Stack](#technology-stack)
- [Project Structure](#project-structure)
- [Documentation](#documentation)
- [Contributing](#contributing)
- [License](#license)

---

## 🎯 Overview

**AgriPulse** is a modern, full-featured dairy farm management system designed to streamline farm operations. It helps farmers track animals, record milk production, manage health records, monitor breeding programs, and maintain financial records - all in one centralized platform.

### Why AgriPulse?

- ✅ **All-in-One Solution** - Manage every aspect of your dairy farm
- ✅ **User-Friendly** - Intuitive interface designed for farmers
- ✅ **Real-Time Insights** - Dashboard with live statistics and alerts
- ✅ **Role-Based Access** - Admin and Worker roles for team management
- ✅ **Mobile Responsive** - Access from any device
- ✅ **Secure** - Built with Laravel's robust security features

---

## ✨ Features

### 🐮 Animal Management
- Add, edit, and track dairy animals
- Unique tag number system
- Breed, gender, and age tracking
- Status management (active, sold, deceased)
- Comprehensive search and filtering

### 🥛 Milk Production Tracking
- Daily production recording
- Quick batch entry for multiple animals
- Production history and trends
- Statistics (daily, weekly, monthly)
- Per-animal production tracking

### 🏥 Health Records Management
- Health condition tracking
- Treatment and medication records
- Vaccination schedule management
- Veterinarian information
- Medical history per animal

### 💕 Breeding Management
- Service date tracking
- Automatic expected birth date calculation
- Pregnancy status monitoring
- Birth recording
- Success rate analytics
- Overdue birth alerts

### 💰 Financial Management
- Income tracking (milk sales, animal sales)
- Expense tracking (feed, veterinary, labor)
- Category-based organization
- Profit/loss calculations
- Monthly and yearly summaries

### 👥 Worker Management (Admin Only)
- Create and manage worker accounts
- Track worker activities
- Role-based permissions
- Password management

### 📊 Reports & Analytics
- Milk production reports
- Animal health reports
- Breeding success reports
- Financial summaries
- Customizable date ranges
- Export capabilities (planned)

### 📱 Dashboard
- Real-time farm statistics
- Today's production overview
- Health alerts
- Upcoming births
- Financial summary
- Top producing animals
- Quick action buttons

---

## 📸 Screenshots

### Dashboard
![Dashboard](docs/screenshots/dashboard.png)
*Comprehensive overview of your dairy farm operations*

### Animal Management
![Animals](docs/screenshots/animals.png)
*Easy-to-use animal tracking system*

### Milk Production
![Production](docs/screenshots/production.png)
*Quick and efficient production recording*

---

## 🚀 Quick Start

Get AgriPulse running in 5 minutes:

```bash
# 1. Install dependencies
composer install && npm install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Configure database (SQLite for quick start)
# Edit .env: DB_CONNECTION=sqlite
touch database/database.sqlite

# 4. Setup database
php artisan migrate --seed

# 5. Build assets and start
npm run build
php artisan serve
```

**Login:** admin@agripulse.com / password

📖 See [QUICKSTART.md](QUICKSTART.md) for detailed instructions.

---

## 💻 Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL or SQLite
- Web server (Apache/Nginx) or use Laravel's built-in server

### Step-by-Step Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/agripulse.git
   cd agripulse
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database configuration**
   
   Edit `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=agripulse
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

6. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Build frontend assets**
   ```bash
   npm run build
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

9. **Access the application**
   
   Open your browser and navigate to: `http://localhost:8000`

📖 See [SETUP.md](SETUP.md) for detailed installation guide.

---

## 📖 Usage

### Default Accounts

**Admin Account:**
- Email: `admin@agripulse.com`
- Password: `password`
- Full access to all features

**Worker Account:**
- Email: `worker@agripulse.com`
- Password: `password`
- Limited access (cannot delete major records)

### Basic Workflow

1. **Add Animals** - Start by adding your dairy animals
2. **Record Production** - Use quick record for daily milk production
3. **Track Health** - Record health events and vaccinations
4. **Manage Breeding** - Track breeding and pregnancies
5. **Financial Records** - Record income and expenses
6. **View Reports** - Analyze your farm's performance

---

## 🛠️ Technology Stack

### Backend
- **Framework:** Laravel 12
- **Language:** PHP 8.2+
- **Database:** MySQL / SQLite
- **Authentication:** Laravel Breeze

### Frontend
- **Template Engine:** Blade
- **CSS Framework:** Tailwind CSS 3.0
- **JavaScript:** Alpine.js
- **Build Tool:** Vite

### Features
- RESTful API architecture
- Eloquent ORM
- Database migrations
- Form validation
- CSRF protection
- Role-based access control

---

## 📁 Project Structure

```
agripulse/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── DashboardController.php
│   │       ├── AnimalController.php
│   │       ├── MilkProductionController.php
│   │       ├── HealthRecordController.php
│   │       ├── BreedingController.php
│   │       ├── FinancialController.php
│   │       ├── WorkerController.php
│   │       └── ReportController.php
│   └── Models/
│       ├── User.php
│       ├── Animal.php
│       ├── MilkProduction.php
│       ├── HealthRecord.php
│       ├── Breeding.php
│       ├── Worker.php
│       └── FinancialTransaction.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── dashboard.blade.php
│   │   └── layouts/
│   └── css/
├── routes/
│   └── web.php
├── SETUP.md
├── QUICKSTART.md
├── PROJECT_SUMMARY.md
└── README.md
```

---

## 📚 Documentation

- **[QUICKSTART.md](QUICKSTART.md)** - Get started in 5 minutes
- **[SETUP.md](SETUP.md)** - Detailed installation guide
- **[PROJECT_SUMMARY.md](PROJECT_SUMMARY.md)** - Complete project overview
- **[TODO.md](TODO.md)** - Implementation progress and roadmap

---

## 🤝 Contributing

Contributions are welcome! Here's how you can help:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Development Guidelines

- Follow PSR-12 coding standards
- Write meaningful commit messages
- Add tests for new features
- Update documentation as needed

---

## 🐛 Bug Reports

Found a bug? Please open an issue with:
- Description of the bug
- Steps to reproduce
- Expected behavior
- Screenshots (if applicable)
- Environment details

---

## 🗺️ Roadmap

### Version 1.0 (Current)
- ✅ Core animal management
- ✅ Milk production tracking
- ✅ Health records
- ✅ Breeding management
- ✅ Financial tracking
- ✅ Basic reporting
- ✅ User management

### Version 1.1 (Planned)
- [ ] Individual view files for all modules
- [ ] PDF export for reports
- [ ] Charts and graphs
- [ ] Image upload for animals
- [ ] Email notifications

### Version 2.0 (Future)
- [ ] Mobile app
- [ ] Advanced analytics
- [ ] API for integrations
- [ ] Multi-language support
- [ ] Inventory management

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👨‍💻 Author

**Your Name**
- GitHub: [@yourusername](https://github.com/yourusername)
- Email: your.email@example.com

---

## 🙏 Acknowledgments

- Laravel Framework
- Tailwind CSS
- Laravel Breeze
- All contributors and supporters

---

## 📞 Support

Need help? Here's how to get support:

- 📖 Check the [documentation](SETUP.md)
- 💬 Open an [issue](https://github.com/yourusername/agripulse/issues)
- 📧 Email: support@agripulse.com

---

## ⭐ Show Your Support

If you find this project helpful, please give it a ⭐ on GitHub!

---

<div align="center">

**Built with ❤️ for dairy farmers everywhere**

🐄 🥛 🌾

[Report Bug](https://github.com/yourusername/agripulse/issues) · [Request Feature](https://github.com/yourusername/agripulse/issues) · [Documentation](SETUP.md)

</div>
