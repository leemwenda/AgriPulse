# AgriPulse - Free Hosting Deployment Guide

## 🚀 Deploy to InfinityFree (Recommended Free Host)

This guide will help you deploy AgriPulse to **InfinityFree** - a reliable free hosting service that supports PHP and MySQL.

---

## 📋 Prerequisites

- InfinityFree account (free signup at https://infinityfree.net)
- FileZilla or any FTP client
- Your AgriPulse project files

---

## Step 1: Sign Up for InfinityFree

1. Go to https://infinityfree.net
2. Click "Sign Up Now"
3. Create a free account
4. Verify your email address

---

## Step 2: Create a New Website

1. Log in to InfinityFree Control Panel
2. Click "Create Account"
3. Choose a subdomain (e.g., `agripulse.rf.gd` or `agripulse.epizy.com`)
4. Or use your own domain if you have one
5. Set a password for your account
6. Click "Create Account"

**Note your credentials:**
- FTP Hostname: (will be provided)
- FTP Username: (will be provided)
- FTP Password: (the one you set)
- MySQL Hostname: (will be provided)
- MySQL Database Name: (will be provided)
- MySQL Username: (will be provided)
- MySQL Password: (will be provided)

---

## Step 3: Prepare Your Laravel Project

### 3.1 Build Frontend Assets

```bash
cd c:/xampp/htdocs/AgriPulse
npm run build
```

### 3.2 Optimize for Production

```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3.3 Update Environment File

Create a new `.env.production` file:

```env
APP_NAME=AgriPulse
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://yourdomain.rf.gd

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=YOUR_MYSQL_HOST
DB_PORT=3306
DB_DATABASE=YOUR_DATABASE_NAME
DB_USERNAME=YOUR_DATABASE_USERNAME
DB_PASSWORD=YOUR_DATABASE_PASSWORD

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## Step 4: Upload Files via FTP

### 4.1 Connect with FileZilla

1. Download FileZilla from https://filezilla-project.org
2. Open FileZilla
3. Enter your FTP credentials:
   - Host: `ftpupload.net` (or your provided FTP host)
   - Username: Your FTP username
   - Password: Your FTP password
   - Port: 21
4. Click "Quickconnect"

### 4.2 Upload Project Files

**Important:** Upload to the `htdocs` folder on the server

Upload these folders/files:
```
✅ app/
✅ bootstrap/
✅ config/
✅ database/
✅ public/ (contents will go to htdocs root)
✅ resources/
✅ routes/
✅ storage/
✅ vendor/ (if you have it, otherwise run composer install on server)
✅ .htaccess
✅ artisan
✅ composer.json
✅ composer.lock
```

**File Structure on Server:**
```
htdocs/
├── index.php (from public/)
├── .htaccess (from public/)
├── css/ (from public/build/assets/)
├── js/ (from public/build/assets/)
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
└── .env
```

---

## Step 5: Configure Database

### 5.1 Create MySQL Database

1. Go to InfinityFree Control Panel
2. Click "MySQL Databases"
3. Note your database credentials
4. Click "PhpMyAdmin"

### 5.2 Import Database Structure

**Option A: Run Migrations (Recommended)**

Create a file `install.php` in your htdocs:

```php
<?php
// install.php - Run this once to set up database
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Run migrations
$kernel->call('migrate', ['--force' => true]);

// Seed database
$kernel->call('db:seed', ['--force' => true]);

echo "Database setup complete!";
```

Visit: `https://yourdomain.rf.gd/install.php`

**Option B: Manual SQL Import**

Export your local database:
```bash
php artisan schema:dump
```

Import the SQL file via PhpMyAdmin.

---

## Step 6: Configure .htaccess

Create/update `.htaccess` in htdocs root:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
    
    # Redirect Trailing Slashes If Not A Folder
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]
    
    # Send Requests To Front Controller
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Disable directory browsing
Options -Indexes

# Protect sensitive files
<FilesMatch "^\.env">
    Order allow,deny
    Deny from all
</FilesMatch>
```

---

## Step 7: Set Permissions

Set proper permissions for storage and bootstrap/cache:

Create `fix-permissions.php`:

```php
<?php
// fix-permissions.php
chmod(__DIR__.'/storage', 0755);
chmod(__DIR__.'/storage/framework', 0755);
chmod(__DIR__.'/storage/framework/cache', 0755);
chmod(__DIR__.'/storage/framework/sessions', 0755);
chmod(__DIR__.'/storage/framework/views', 0755);
chmod(__DIR__.'/storage/logs', 0755);
chmod(__DIR__.'/bootstrap/cache', 0755);

echo "Permissions fixed!";
```

Visit: `https://yourdomain.rf.gd/fix-permissions.php`

---

## Step 8: Update Configuration

### 8.1 Update config/database.php

Ensure MySQL is default:

```php
'default' => env('DB_CONNECTION', 'mysql'),
```

### 8.2 Update .env file

Upload your `.env.production` as `.env` with correct database credentials.

---

## Step 9: Test Your Deployment

1. Visit your website: `https://yourdomain.rf.gd`
2. You should see the AgriPulse welcome page
3. Try logging in with default credentials:
   - Email: admin@agripulse.com
   - Password: password

---

## Step 10: Security Hardening

### 10.1 Change Default Passwords

```bash
# Create a new admin user via PhpMyAdmin or install.php
```

### 10.2 Disable Debug Mode

In `.env`:
```env
APP_DEBUG=false
```

### 10.3 Generate New APP_KEY

```bash
php artisan key:generate
```

---

## 🔧 Troubleshooting

### Issue: 500 Internal Server Error

**Solution:**
1. Check `.htaccess` file exists
2. Verify file permissions (755 for directories, 644 for files)
3. Check error logs in cPanel

### Issue: Database Connection Error

**Solution:**
1. Verify database credentials in `.env`
2. Ensure database exists in cPanel
3. Check MySQL hostname (usually `localhost` or specific host)

### Issue: CSS/JS Not Loading

**Solution:**
1. Run `npm run build` locally
2. Upload `public/build` folder
3. Check `APP_URL` in `.env`

### Issue: Storage Permission Errors

**Solution:**
1. Run `fix-permissions.php`
2. Or manually set permissions via FTP client

---

## 📊 InfinityFree Limitations

**Be aware of these free hosting limitations:**

- ❌ No SSH access (can't run artisan commands directly)
- ❌ Limited CPU/RAM resources
- ❌ Daily hit limits (~50,000 hits/day)
- ❌ No cron jobs (scheduled tasks won't work)
- ❌ Limited file upload size
- ✅ Unlimited bandwidth
- ✅ Unlimited disk space
- ✅ MySQL database support
- ✅ PHP 8.x support

---

## 🚀 Alternative Free Hosts

If InfinityFree doesn't work:

1. **000webhost** - https://www.000webhost.com
2. **Awardspace** - https://www.awardspace.com
3. **FreeHosting** - https://www.freehosting.com

---

## 📈 Upgrade Path

When ready for production:

1. **Shared Hosting** ($5-15/month)
   - Hostinger, Bluehost, SiteGround
   - Full cPanel access
   - Better performance

2. **VPS Hosting** ($10-50/month)
   - DigitalOcean, Linode, Vultr
   - Full server control
   - Scalable resources

3. **Cloud Platform** ($10-100/month)
   - AWS, Google Cloud, Azure
   - Enterprise-grade
   - Auto-scaling

---

## ✅ Post-Deployment Checklist

- [ ] Website accessible via domain
- [ ] Login working
- [ ] Database connected
- [ ] All pages loading
- [ ] Forms submitting correctly
- [ ] File uploads working
- [ ] Changed default passwords
- [ ] Debug mode disabled
- [ ] Error logging configured
- [ ] Backup strategy in place

---

## 🆘 Need Help?

If you encounter issues:

1. Check InfinityFree documentation
2. Review Laravel deployment docs
3. Check error logs in cPanel
4. Contact InfinityFree support

---

**Congratulations! Your AgriPulse system is now deployed! 🎉**
