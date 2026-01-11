# Quick Deployment Checklist

## Before Upload
- [ ] Download all files from Lovable
- [ ] Have database credentials ready
- [ ] Have FTP/SSH access to server

## Database Setup
- [ ] Create MySQL database: `samyakmatrimony`
- [ ] Create database user with ALL PRIVILEGES
- [ ] Note down: hostname, database name, username, password

## Upload Files
- [ ] Upload all files to `public_html/` (or subdomain folder)
- [ ] Verify folder structure is correct

## Configuration
- [ ] Create `config/database.local.php` with your credentials:
```php
<?php
return [
    'host' => 'localhost',
    'port' => 3306,
    'database' => 'YOUR_DATABASE_NAME',
    'username' => 'YOUR_DB_USER',
    'password' => 'YOUR_DB_PASSWORD',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
];
```
- [ ] Update `config/app.php` with your domain URL
- [ ] Set `debug => false` for production

## Permissions
- [ ] Run: `composer install --no-dev`
- [ ] Set `public/uploads/` to writable (chmod 777)
- [ ] Set `config/database.local.php` to chmod 600

## Testing
- [ ] Visit homepage - should load correctly
- [ ] Test registration - should get Profile ID
- [ ] Test login - should access dashboard
- [ ] Test search - should show profiles

## Security
- [ ] SSL certificate installed (HTTPS)
- [ ] Debug mode OFF
- [ ] Strong database password
- [ ] .htaccess blocking sensitive folders

## Done! 🎉
