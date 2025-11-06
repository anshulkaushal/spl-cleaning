# Deployment Checklist for Hostinger

## 403 Forbidden Error - Step by Step Fix

### Step 1: Verify File Location in Hostinger

**In Hostinger File Manager, your `public_html/` should contain:**

```
public_html/
├── index.php          ← MUST BE HERE (root level)
├── services.php
├── register.php
├── login.php
├── logout.php
├── account.php
├── request-quote.php
├── join-our-team.php
├── test.php          (for testing)
├── admin/
│   ├── login.php
│   ├── index.php
│   └── ...
├── includes/
│   ├── config.php    ← MUST EXIST
│   ├── db.php
│   └── ...
├── models/
├── assets/
└── .htaccess
```

### Step 2: Check File Permissions

**In Hostinger File Manager:**

1. Right-click on `index.php`
2. Select "Change Permissions" or "File Permissions"
3. Set to: **644** (rw-r--r--)
4. Click "Change"

**For folders:**
- All folders should be **755** (rwxr-xr-x)
- Especially check: `includes/`, `models/`, `assets/`, `admin/`

### Step 3: Verify config.php Exists

1. Navigate to `public_html/includes/`
2. Check if `config.php` exists
3. If not, copy `config.php.example` to `config.php`
4. Edit `config.php` with your database credentials

### Step 4: Test with Simple PHP File

1. Upload this simple test file to `public_html/test-simple.php`:

```php
<?php
echo "PHP is working!";
phpinfo();
?>
```

2. Access: `https://rosybrown-barracuda-297414.hostingersite.com/test-simple.php`
3. If this works → PHP is fine, issue is with file location/permissions
4. If this gives 403 → Contact Hostinger support

### Step 5: Temporarily Disable .htaccess

1. In File Manager, rename `.htaccess` to `.htaccess.backup`
2. Try accessing the site
3. If it works → The issue is in `.htaccess`
4. Restore `.htaccess` and we'll fix it

### Step 6: Check Directory Index

1. In Hostinger hPanel, go to "Advanced" → "Index Manager"
2. Make sure "Default Directory Index" includes `index.php`
3. It should list: `index.php`, `index.html`, etc.

### Step 7: Verify Domain Points to Correct Directory

1. In hPanel, go to "Domains"
2. Check that your domain points to `public_html/`
3. If you have a subdomain, verify its document root

## Common Issues

### Issue: Files are in `public_html/public/` instead of `public_html/`

**Solution:** Move all files from `public_html/public/` to `public_html/`

### Issue: config.php is missing

**Solution:** 
1. Copy `config.php.example` to `config.php`
2. Edit with your database credentials

### Issue: Wrong file permissions

**Solution:**
- Files: `644`
- Folders: `755`

### Issue: .htaccess blocking access

**Solution:**
1. Rename to `.htaccess.backup`
2. Test site
3. If works, restore and fix `.htaccess`

## Quick Test Commands

After uploading, test these URLs:

1. `https://rosybrown-barracuda-297414.hostingersite.com/test-simple.php` - Should show PHP info
2. `https://rosybrown-barracuda-297414.hostingersite.com/test.php` - Should show database connection test
3. `https://rosybrown-barracuda-297414.hostingersite.com/` - Should show homepage

## Still Not Working?

1. **Check Hostinger Error Logs:**
   - hPanel → "Advanced" → "Error Log"
   - Look for specific error messages

2. **Contact Hostinger Support:**
   - They can check server-side issues
   - They can verify file permissions
   - They can check if mod_rewrite is enabled

3. **Verify PHP Version:**
   - hPanel → "Advanced" → "Select PHP Version"
   - Should be PHP 8.0 or higher

