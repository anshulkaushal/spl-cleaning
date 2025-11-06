# Troubleshooting 403 Forbidden Error

## Common Causes and Solutions

### 1. File Location Issue

**Problem:** Files are in the wrong directory structure.

**Solution:** On Hostinger, your files should be structured like this in `public_html/`:

```
public_html/
├── index.php          (from /public/index.php)
├── services.php      (from /public/services.php)
├── register.php       (from /public/register.php)
├── login.php          (from /public/login.php)
├── logout.php         (from /public/logout.php)
├── account.php        (from /public/account.php)
├── request-quote.php  (from /public/request-quote.php)
├── join-our-team.php  (from /public/join-our-team.php)
├── admin/            (entire folder from /public/admin/)
├── includes/         (entire folder)
├── models/           (entire folder)
├── assets/           (entire folder)
├── .htaccess
└── schema.sql
```

**Action:** Make sure `index.php` is directly in `public_html/`, not in `public_html/public/`.

### 2. File Permissions

**Problem:** Incorrect file permissions.

**Solution:** Set permissions via File Manager or FTP:
- **Folders:** `755`
- **Files:** `644`
- **index.php:** `644`

**How to check in Hostinger File Manager:**
1. Right-click on `index.php`
2. Select "Change Permissions"
3. Set to `644` (rw-r--r--)

### 3. .htaccess Issues

**Problem:** .htaccess file is blocking access.

**Solution:** 
1. Temporarily rename `.htaccess` to `.htaccess.bak`
2. Try accessing the site
3. If it works, the issue is in `.htaccess`
4. Restore `.htaccess` and check for syntax errors

### 4. Missing index.php

**Problem:** No index file in the root directory.

**Solution:** Ensure `index.php` exists in `public_html/` root.

### 5. Directory Listing Disabled

**Problem:** Directory listing is disabled and no index file.

**Solution:** Make sure `index.php` is in the root directory.

## Quick Fix Steps

1. **Check file location:**
   - Log into Hostinger File Manager
   - Navigate to `public_html/`
   - Verify `index.php` is there (not in a subfolder)

2. **Check permissions:**
   - `index.php` should be `644`
   - All folders should be `755`

3. **Test without .htaccess:**
   - Rename `.htaccess` to `.htaccess.backup`
   - Try accessing the site
   - If it works, restore `.htaccess` with simplified version

4. **Check error logs:**
   - In Hostinger hPanel, go to "Error Logs"
   - Look for specific error messages

5. **Verify PHP is working:**
   - Create a test file `test.php` with: `<?php phpinfo(); ?>`
   - Access it via browser
   - If it shows PHP info, PHP is working

## If Still Not Working

1. **Contact Hostinger Support** - They can check server-side issues
2. **Check if mod_rewrite is enabled** - Required for clean URLs
3. **Verify domain is pointing to correct directory** - Check domain settings in hPanel

