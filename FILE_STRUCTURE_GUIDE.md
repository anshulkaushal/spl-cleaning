# File Structure Guide for Hostinger

## Problem: 404 Errors on All Pages

**Root Cause:** Files are in `/public/` subdirectory, but URLs expect them in root.

## Solution: Move Files to Root

### Current Structure (WRONG):
```
public_html/
├── index.php          ← Works
├── public/            ← Files are here
│   ├── login.php
│   ├── register.php
│   ├── services.php
│   └── ...
├── includes/
└── models/
```

### Required Structure (CORRECT):
```
public_html/
├── index.php          ← Home page
├── login.php          ← Must be in root
├── register.php       ← Must be in root
├── logout.php         ← Must be in root
├── account.php        ← Must be in root
├── services.php       ← Must be in root
├── request-quote.php  ← Must be in root
├── join-our-team.php  ← Must be in root
├── admin/            ← Admin folder
│   ├── login.php
│   ├── index.php
│   └── ...
├── includes/         ← Core files
├── models/           ← Models
└── assets/           ← CSS, JS, images
```

## Step-by-Step Fix

### Option 1: Move Files via File Manager (Recommended)

1. **In Hostinger File Manager:**
   - Navigate to `public_html/public/`
   - Select ALL files EXCEPT the `admin/` folder
   - Cut them (or copy)
   - Navigate to `public_html/` (root)
   - Paste them

2. **Move admin folder:**
   - Cut `public_html/public/admin/`
   - Paste to `public_html/admin/`

3. **Delete empty public folder:**
   - Delete `public_html/public/` if it's now empty

### Option 2: Re-upload Files Correctly

1. **Upload these files directly to `public_html/` root:**
   - login.php
   - register.php
   - logout.php
   - account.php
   - services.php
   - request-quote.php
   - join-our-team.php
   - test.php

2. **Upload `admin/` folder to `public_html/admin/`**

3. **Keep these folders as-is:**
   - includes/
   - models/
   - assets/

## Verify Structure

After moving files, your `public_html/` should look like:

```
public_html/
├── .htaccess
├── index.php
├── login.php          ✓
├── register.php       ✓
├── services.php       ✓
├── account.php        ✓
├── request-quote.php   ✓
├── join-our-team.php  ✓
├── admin/
│   ├── login.php
│   └── ...
├── includes/
│   └── config.php
└── models/
```

## Test URLs

After moving files, these should work:
- ✅ `https://rosybrown-barracuda-297414.hostingersite.com/` - Home
- ✅ `https://rosybrown-barracuda-297414.hostingersite.com/login.php` - Login
- ✅ `https://rosybrown-barracuda-297414.hostingersite.com/register.php` - Register
- ✅ `https://rosybrown-barracuda-297414.hostingersite.com/services.php` - Services
- ✅ `https://rosybrown-barracuda-297414.hostingersite.com/admin/login.php` - Admin Login

## Quick Check

In Hostinger File Manager:
1. Go to `public_html/`
2. You should see `login.php`, `register.php`, etc. directly listed (not in a subfolder)
3. If you see a `public/` folder with these files inside, move them out

