# SparklePro Cleaning Services Website

A complete, production-ready PHP/MySQL cleaning services website designed for Hostinger shared hosting.

## Features

- **Customer Features:**
  - User registration and authentication
  - Service browsing and quote requests
  - Callback request functionality
  - Personal account dashboard
  - View quote request history

- **Admin Features:**
  - Admin dashboard with statistics
  - Lead management (quote/callback requests)
  - Employee management
  - Schedule management
  - CV application management
  - Comprehensive reports (workload, tasks, leads)

- **Public Features:**
  - Modern, responsive design with Bootstrap
  - Service listings
  - CV upload for job applications
  - Contact and quote request forms

## Technology Stack

- **Backend:** PHP 8+ with PDO
- **Database:** MySQL
- **Frontend:** Bootstrap 5.3 (via CDN)
- **Architecture:** MVC-inspired structure

## File Structure

```
/
├── public/                 # Entry points (publicly accessible)
│   ├── index.php          # Home page
│   ├── services.php       # Services listing
│   ├── register.php      # User registration
│   ├── login.php          # User login
│   ├── logout.php         # User logout
│   ├── account.php        # User account dashboard
│   ├── request-quote.php # Quote/callback request
│   ├── join-our-team.php # CV upload page
│   └── admin/             # Admin area
│       ├── login.php      # Admin login
│       ├── index.php      # Admin dashboard
│       ├── leads.php      # Lead management
│       ├── employees.php  # Employee management
│       ├── schedules.php  # Schedule management
│       ├── cv-applications.php # CV management
│       └── reports.php    # Reports
├── includes/              # Core includes
│   ├── config.php         # Configuration (UPDATE THIS!)
│   ├── db.php             # Database connection
│   ├── auth.php           # Authentication functions
│   ├── helpers.php        # Helper functions
│   ├── header.php         # Site header
│   └── footer.php         # Site footer
├── models/                # Data models
│   ├── User.php
│   ├── Service.php
│   ├── Lead.php
│   ├── Employee.php
│   ├── Schedule.php
│   ├── CVApplication.php
│   └── AdminUser.php
├── assets/                # Static assets
│   ├── css/
│   │   ├── style.css      # Main stylesheet
│   │   └── admin.css      # Admin stylesheet
│   ├── js/
│   │   ├── main.js        # Main JavaScript
│   │   └── admin.js       # Admin JavaScript
│   └── uploads/
│       └── cv/            # CV uploads directory (create with 755 permissions)
├── schema.sql             # Database schema
├── .htaccess              # Apache configuration
└── README.md              # This file
```

## Deployment Instructions for Hostinger

### Step 1: Upload Files

1. **Access your Hostinger hosting control panel (hPanel)**

2. **Navigate to File Manager** or use FTP/SFTP:
   - Recommended: Use File Manager in hPanel
   - Alternative: Use FTP client (FileZilla, WinSCP, etc.)

3. **Upload files to your domain's root directory (`public_html/`):**
   
   **Option A: Simple Structure (Recommended for Hostinger)**
   - Upload contents of `/public/` folder directly to `public_html/`
   - Upload `/includes/` folder to `public_html/includes/`
   - Upload `/models/` folder to `public_html/models/`
   - Upload `/assets/` folder to `public_html/assets/`
   - Upload `schema.sql` and `.htaccess` to `public_html/`
   
   **Option B: Keep Project Structure**
   - Upload entire project to `public_html/`
   - Update paths in `includes/header.php` and `includes/footer.php` if needed
   - Or configure `.htaccess` to rewrite URLs (advanced)

4. **Set proper permissions:**
   - Folders: `755`
   - Files: `644`
   - `/assets/uploads/cv/` folder: `755` (must be writable)

### Step 2: Create Database

1. **In hPanel, go to "Databases" → "MySQL Databases"**

2. **Create a new database:**
   - Click "Create New Database"
   - Note the database name (e.g., `u123456789_cleaning`)

3. **Create a database user:**
   - Click "Create New User"
   - Set username and strong password
   - Note these credentials

4. **Add user to database:**
   - Select the user and database
   - Click "Add"
   - Grant all privileges

### Step 3: Import Database Schema

1. **In hPanel, go to "Databases" → "phpMyAdmin"**

2. **Select your database** from the left sidebar

3. **Click "Import" tab**

4. **Choose the `schema.sql` file** from your project

5. **Click "Go"** to import

6. **Verify tables were created:**
   - You should see: `users`, `admin_users`, `services`, `employees`, `leads`, `employee_schedules`, `cv_applications`

### Step 4: Configure Database Connection

1. **Edit `/includes/config.php`** using File Manager or FTP

2. **Update these values:**
   ```php
   define('DB_HOST', 'localhost');  // Usually 'localhost' on Hostinger
   define('DB_NAME', 'your_database_name');  // Your database name from Step 2
   define('DB_USER', 'your_database_user');  // Your database user from Step 2
   define('DB_PASS', 'your_database_password');  // Your database password from Step 2
   ```

3. **Update site URL:**
   ```php
   define('SITE_URL', 'https://yourdomain.com');  // Your actual domain
   ```

4. **Save the file**

### Step 5: Create Uploads Directory

1. **Create the CV uploads directory:**
   - Path: `/assets/uploads/cv/`
   - Set permissions to `755` (writable)

2. **You can do this via File Manager:**
   - Navigate to `/assets/uploads/`
   - Create folder `cv`
   - Right-click → Change Permissions → Set to `755`

### Step 6: Test the Installation

1. **Visit your website:**
   - `https://yourdomain.com/`
   - You should see the home page

2. **Test admin login:**
   - Go to: `https://yourdomain.com/admin/login.php`
   - **Default credentials:**
     - Email: `admin@sparklepro.com`
     - Password: `admin123`
   - **⚠️ IMPORTANT: Change these credentials immediately after first login!**

3. **Test user registration:**
   - Go to: `https://yourdomain.com/register.php`
   - Create a test account

### Step 7: Security Checklist

- [ ] Change admin password immediately
- [ ] Update `config.php` with correct database credentials
- [ ] Set `display_errors` to `0` in `config.php` for production
- [ ] Ensure `.htaccess` is working (protects config files)
- [ ] Verify file permissions are correct
- [ ] Test file upload functionality (CV uploads)

## Default Admin Credentials

**⚠️ CHANGE THESE IMMEDIATELY AFTER FIRST LOGIN!**

- **Email:** `admin@sparklepro.com`
- **Password:** `admin123`

To change the admin password, you can:
1. Log in to phpMyAdmin
2. Go to `admin_users` table
3. Update the `password_hash` field with a new hash generated using PHP's `password_hash()` function

Or create a simple password reset script (recommended for production).

## Database Tables

- **users** - Customer accounts
- **admin_users** - Admin accounts
- **services** - Cleaning services offered
- **employees** - Staff members
- **leads** - Quote/callback requests
- **employee_schedules** - Job schedules
- **cv_applications** - Job applications with CV uploads

## Common Issues & Solutions

### Issue: "Database connection failed"
**Solution:** Check `config.php` database credentials match your Hostinger database settings.

### Issue: "File upload failed"
**Solution:** Ensure `/assets/uploads/cv/` directory exists and has `755` permissions.

### Issue: "404 Not Found" on pages
**Solution:** Check that `.htaccess` is uploaded and Apache mod_rewrite is enabled.

### Issue: "Session errors"
**Solution:** Ensure PHP sessions are enabled (usually enabled by default on Hostinger).

## Support

For Hostinger-specific issues, consult:
- Hostinger Knowledge Base: https://www.hostinger.com/tutorials
- Hostinger Support: Available in hPanel

## License

This project is provided as-is for use with SparklePro Cleaning Services.

## Notes

- All database queries use PDO with prepared statements for security
- Passwords are hashed using PHP's `password_hash()` function
- File uploads are validated for type and size
- CSRF protection can be added to forms (basic implementation included)
- The code is PHP 8+ compatible

---

**Last Updated:** 2024
**Version:** 1.0.0

