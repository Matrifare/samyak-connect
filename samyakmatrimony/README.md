# Samyak Matrimony - Deployment Guide

A modern Buddhist Matrimonial Platform built with PHP 8+, Bootstrap 5, and Glassmorphism design.

---

## 📋 Table of Contents

1. [Requirements](#requirements)
2. [Download Files](#download-files)
3. [Database Setup](#database-setup)
4. [Upload to Server](#upload-to-server)
5. [Configure Database Connection](#configure-database-connection)
6. [Set File Permissions](#set-file-permissions)
7. [Configure Web Server](#configure-web-server)
8. [Final Steps](#final-steps)
9. [Troubleshooting](#troubleshooting)

---

## 🔧 Requirements

Before deploying, ensure your hosting server meets these requirements:

| Requirement | Minimum Version |
|-------------|-----------------|
| PHP | 8.0 or higher |
| MySQL | 5.7 or higher (or MariaDB 10.3+) |
| Apache/Nginx | Latest stable |
| PHP Extensions | PDO, PDO_MySQL, mbstring, openssl, json |

### Verify PHP Version
```bash
php -v
```

### Verify Required Extensions
```bash
php -m | grep -E "(pdo|mbstring|openssl|json)"
```

---

## 📥 Download Files

1. **Download** the entire `samyakmatrimony` folder from Lovable
2. **Extract** the files to your local computer
3. Verify you have this folder structure:
   ```
   samyakmatrimony/
   ├── app/
   │   ├── Controllers/
   │   ├── Core/
   │   └── Models/
   ├── config/
   │   ├── app.php
   │   └── database.php
   ├── public/
   │   ├── assets/
   │   ├── uploads/
   │   ├── index.php
   │   └── .htaccess
   ├── templates/
   ├── composer.json
   ├── .htaccess
   └── .gitignore
   ```

---

## 🗄️ Database Setup

### Option A: Using phpMyAdmin (Recommended for Shared Hosting)

1. **Login** to your hosting control panel (cPanel, Plesk, etc.)
2. Open **phpMyAdmin**
3. Create a new database:
   - Click "New" on the left sidebar
   - Enter database name: `samyakmatrimony` (or your preferred name)
   - Select collation: `utf8mb4_unicode_ci`
   - Click "Create"

4. **Create a database user:**
   - Go to cPanel → MySQL Databases
   - Create new user with a strong password
   - Add user to database with **ALL PRIVILEGES**

5. **Import existing data** (if migrating from old site):
   - Export your old database using phpMyAdmin
   - Import into the new database

### Option B: Using Command Line (VPS/Dedicated Server)

```bash
# Login to MySQL
mysql -u root -p

# Create database
CREATE DATABASE samyakmatrimony CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Create user
CREATE USER 'samyak_user'@'localhost' IDENTIFIED BY 'YourStrongPassword123!';

# Grant privileges
GRANT ALL PRIVILEGES ON samyakmatrimony.* TO 'samyak_user'@'localhost';
FLUSH PRIVILEGES;

# Exit
EXIT;
```

### Database Tables

If you're starting fresh (no existing database), you'll need to create the required tables. Contact me for the SQL schema or use the existing database from your old site.

---

## 📤 Upload to Server

### Using FTP (FileZilla, WinSCP, etc.)

1. **Connect** to your server via FTP/SFTP
2. Navigate to your **web root** directory:
   - For main domain: `public_html/` or `www/`
   - For subdomain: `public_html/subdomain/` or `subdomains/subdomain/`
3. **Upload** all files from `samyakmatrimony/` folder

### Using cPanel File Manager

1. Login to **cPanel**
2. Open **File Manager**
3. Navigate to `public_html/` (or your subdomain folder)
4. Click **Upload** and upload a ZIP of the `samyakmatrimony` folder
5. **Extract** the ZIP file
6. Move contents to the correct location

### Using SSH (Advanced)

```bash
# Connect to server
ssh user@your-domain.com

# Navigate to web root
cd /var/www/html/  # or public_html

# Upload via SCP or rsync
scp -r /local/path/samyakmatrimony/* user@your-domain.com:/var/www/html/
```

---

## ⚙️ Configure Database Connection

### Step 1: Create Local Configuration File

1. Navigate to the `config/` folder on your server
2. **Copy** `database.php` to `database.local.php`
3. **Edit** `database.local.php` with your database credentials:

```php
<?php
/**
 * Local Database Configuration
 * This file should NOT be committed to version control
 */

return [
    'host' => 'localhost',           // Usually 'localhost' for shared hosting
    'port' => 3306,                  // Default MySQL port
    'database' => 'samyakmatrimony', // Your database name
    'username' => 'samyak_user',     // Your database username
    'password' => 'YourPassword123', // Your database password
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
];
```

### Step 2: Update App Configuration (Optional)

Edit `config/app.php` to set your site URL:

```php
<?php
return [
    'name' => 'Samyak Matrimony',
    'url' => 'https://your-domain.com',  // Your actual domain
    'debug' => false,                     // Set to false in production!
    'timezone' => 'Asia/Kolkata',
];
```

---

## 🔐 Set File Permissions

### Using SSH

```bash
# Navigate to your site root
cd /path/to/samyakmatrimony

# Set directory permissions
find . -type d -exec chmod 755 {} \;

# Set file permissions
find . -type f -exec chmod 644 {} \;

# Make uploads folder writable
chmod 777 public/uploads
chmod 777 public/uploads/photos

# Protect config files
chmod 600 config/database.local.php
```

### Using cPanel File Manager

1. Right-click on `public/uploads` folder → **Change Permissions**
2. Set to `777` (Read, Write, Execute for all)
3. Check "Recurse into subdirectories"
4. Click "Change Permissions"

---

## 🌐 Configure Web Server

### Apache (.htaccess) - Usually Automatic

The `.htaccess` files are already included. Verify that:

1. **mod_rewrite** is enabled
2. **AllowOverride All** is set in Apache config

To enable mod_rewrite (if needed):
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Nginx Configuration

If using Nginx, add this to your server block:

```nginx
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    root /var/www/html/public;
    index index.php;

    # Handle all requests through index.php
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP processing
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Deny access to sensitive files
    location ~ /\.(ht|git) {
        deny all;
    }

    location ~ ^/(config|app|templates)/ {
        deny all;
    }
}
```

Restart Nginx:
```bash
sudo systemctl restart nginx
```

---

## ✅ Final Steps

### 1. Install Composer Dependencies (If Not Already)

```bash
cd /path/to/samyakmatrimony
composer install --no-dev --optimize-autoloader
```

If composer is not available:
```bash
curl -sS https://getcomposer.org/installer | php
php composer.phar install --no-dev --optimize-autoloader
```

### 2. Create Uploads Directory

```bash
mkdir -p public/uploads/photos
chmod 777 public/uploads/photos
```

### 3. Test Your Site

1. Visit `https://your-domain.com`
2. You should see the homepage with:
   - Header with navigation
   - Hero section with search
   - Featured profiles
   - Success stories
   - Footer

### 4. Test Registration & Login

1. Click "Register Free"
2. Create a test account
3. Verify you receive a Profile ID
4. Try logging in

### 5. Set Production Mode

Edit `config/app.php`:
```php
'debug' => false,
```

---

## 🔒 Security Checklist

Before going live, ensure:

- [ ] `database.local.php` has correct permissions (600)
- [ ] Debug mode is OFF in production
- [ ] HTTPS/SSL certificate is installed
- [ ] Strong database password is set
- [ ] `public/uploads` is the only writable folder
- [ ] `.htaccess` files are properly blocking sensitive directories

---

## ❗ Troubleshooting

### Error: "500 Internal Server Error"

1. Check PHP error logs: `tail -f /var/log/apache2/error.log`
2. Verify `.htaccess` is uploaded correctly
3. Ensure mod_rewrite is enabled
4. Check file permissions

### Error: "Database connection failed"

1. Verify database credentials in `config/database.local.php`
2. Check if database user has proper permissions
3. Ensure MySQL server is running
4. Try connecting via phpMyAdmin to verify credentials

### Error: "Class not found"

1. Run `composer dump-autoload -o`
2. Verify `vendor/` folder exists
3. Check file paths in autoloader

### Blank Page / No CSS Loading

1. Check browser console for 404 errors
2. Verify `public/assets/` folder is uploaded
3. Clear browser cache
4. Check `.htaccess` rewrite rules

### Images Not Showing

1. Verify `public/assets/images/` folder is uploaded
2. Check file permissions on images folder
3. Clear browser cache

---

## 📞 Support

For technical support or questions:

- **Email**: info@samyakmatrimony.com
- **Website**: https://samyakmatrimony.com

---

## 📄 File Structure Reference

```
samyakmatrimony/
├── app/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── HomeController.php
│   │   ├── InterestController.php
│   │   ├── MessageController.php
│   │   ├── ProfileController.php
│   │   ├── SearchController.php
│   │   └── ShortlistController.php
│   ├── Core/
│   │   ├── Controller.php
│   │   ├── Database.php
│   │   ├── Model.php
│   │   ├── Router.php
│   │   ├── Security.php
│   │   ├── Session.php
│   │   └── Validator.php
│   └── Models/
│       ├── Interest.php
│       ├── Message.php
│       ├── ProfileView.php
│       ├── Shortlist.php
│       └── User.php
├── config/
│   ├── app.php
│   ├── database.php
│   └── database.local.php (create this!)
├── public/
│   ├── assets/
│   │   ├── css/style.css
│   │   ├── js/main.js
│   │   └── images/
│   ├── uploads/photos/
│   ├── index.php
│   └── .htaccess
├── templates/
│   ├── auth/
│   ├── components/
│   ├── dashboard/
│   ├── errors/
│   ├── home/
│   ├── interests/
│   ├── layouts/
│   ├── messages/
│   ├── pages/
│   ├── profile/
│   ├── search/
│   └── shortlist/
├── vendor/ (created by composer)
├── composer.json
├── .htaccess
└── README.md
```

---

**🎉 Congratulations!** Your Samyak Matrimony website should now be live!
