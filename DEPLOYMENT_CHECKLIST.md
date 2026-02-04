# 🚀 AgriPulse Deployment Checklist

## Quick Deployment Steps for InfinityFree

### Before You Start
- [ ] Sign up at https://infinityfree.net (free)
- [ ] Download FileZilla FTP client (free)
- [ ] Have your project files ready

---

## Step-by-Step Deployment

### 1️⃣ Create Hosting Account (5 minutes)
- [ ] Go to https://infinityfree.net
- [ ] Click "Sign Up Now"
- [ ] Verify your email
- [ ] Log in to control panel
- [ ] Click "Create Account"
- [ ] Choose subdomain (e.g., `agripulse.rf.gd`)
- [ ] Note down your credentials:
  - FTP Host: `_________________`
  - FTP Username: `_________________`
  - FTP Password: `_________________`
  - MySQL Host: `_________________`
  - MySQL Database: `_________________`
  - MySQL Username: `_________________`
  - MySQL Password: `_________________`

### 2️⃣ Prepare Files (2 minutes)
- [ ] Run `deploy.bat` in your project folder
- [ ] Or manually prepare:
  - [ ] Run `npm run build`
  - [ ] Copy all project files

### 3️⃣ Configure Environment (2 minutes)
- [ ] Open `.env.production` file
- [ ] Update with your hosting credentials:
  ```
  APP_URL=https://your-subdomain.rf.gd
  DB_HOST=your-mysql-host
  DB_DATABASE=your-database-name
  DB_USERNAME=your-username
  DB_PASSWORD=your-password
  ```
- [ ] Rename to `.env`

### 4️⃣ Upload Files via FTP (10-15 minutes)
- [ ] Open FileZilla
- [ ] Connect to your hosting:
  - Host: `ftpupload.net`
  - Username: Your FTP username
  - Password: Your FTP password
  - Port: `21`
- [ ] Navigate to `htdocs` folder on server
- [ ] Upload ALL files from your project
- [ ] Wait for upload to complete

### 5️⃣ Set Up Database (2 minutes)
- [ ] Visit: `https://your-subdomain.rf.gd/install.php`
- [ ] Wait for installation to complete
- [ ] Note the default login credentials

### 6️⃣ Security Cleanup (1 minute)
- [ ] Delete `install.php` from server
- [ ] Delete `fix-permissions.php` from server
- [ ] Change default admin password

### 7️⃣ Test Your Site
- [ ] Visit your website
- [ ] Log in with admin credentials
- [ ] Test all features:
  - [ ] Dashboard loads
  - [ ] Can add animals
  - [ ] Can record milk production
  - [ ] Can add health records
  - [ ] Can manage breeding
  - [ ] Can track finances
  - [ ] Reports work

---

## 🎉 Congratulations!

Your AgriPulse dairy farm management system is now live!

**Your Website:** `https://your-subdomain.rf.gd`

**Default Login:**
- Admin: `admin@agripulse.com` / `password`
- Worker: `worker@agripulse.com` / `password`

⚠️ **IMPORTANT:** Change these passwords immediately!

---

## 🆘 Troubleshooting

### Site shows blank page or 500 error
1. Check `.htaccess` file exists
2. Visit `/fix-permissions.php`
3. Check error logs in cPanel

### Database connection error
1. Verify credentials in `.env`
2. Check MySQL host (not always `localhost`)
3. Ensure database exists

### CSS/JS not loading
1. Check `public/build` folder was uploaded
2. Verify `APP_URL` in `.env`
3. Clear browser cache

### Login not working
1. Run `/install.php` again
2. Check database has users table
3. Verify password hash is correct

---

## 📞 Support Resources

- InfinityFree Forums: https://forum.infinityfree.net
- Laravel Documentation: https://laravel.com/docs
- FileZilla Guide: https://wiki.filezilla-project.org

---

**Total Estimated Time: 20-30 minutes**
