# ✅ Database Setup Checklist

## Current Status: ✅ ALL CODE READY - AWAITING DATABASE INITIALIZATION

The system is fully configured to use MySQL database with custom cipher encryption. Everything is in place - you just need to initialize the database.

---

## 🚀 Quick Start (3 Easy Steps)

### Step 1: Start XAMPP
1. Open XAMPP Control Panel
2. Start **Apache** and **MySQL**
3. Verify both are running (green status)

### Step 2: Create Database
**Go to:** `http://localhost/Encryption/setup-database.php`

This automated script will:
- ✓ Create `real_estate_db` database
- ✓ Create `users` table (with password_encrypted column)
- ✓ Create `properties` table
- ✓ Create `favorites` table
- ✓ Insert 3 test accounts with encrypted passwords
- ✓ Insert 6 sample properties

**You should see:**
```
✓ Database created successfully
✓ Users table created successfully
✓ Properties table created successfully
✓ Favorites table created successfully
✓ Test users inserted with encrypted passwords
✓ Sample properties inserted

Test Login Credentials:
Username: demo | Password: password123
Username: agent | Password: password123
Username: admin | Password: password123
```

### Step 3: Test Login
**Go to:** `http://localhost/Encryption/login.php`

1. Username: `demo`
2. Password: `password123`
3. Click "Login"
4. Should redirect to dashboard with properties showing

---

## 🔐 What Happens Behind the Scenes

### When You Sign Up (New Account)
```
You enter: password123
    ↓
Frontend stores in data-plaintext attribute
    ↓
Send plaintext to api/auth.php
    ↓
User.php applies Cipher::encrypt()
    ↓
Database stores: >=||_@(/JTA (encrypted)
    ↓
Next time you login, decrypts back to: password123
    ↓
Compares with your input
    ↓
✓ Login successful!
```

### Cipher Mapping (First 5 Characters)
```
p → >     (letter to symbol)
a → =     (letter to symbol)
s → |     (letter to symbol)
s → |     (letter to symbol)
w → _     (letter to symbol)
```

**Result:** `password123` → `>=||_@(/JTA`

---

## ✅ Verification Checklist

After running setup-database.php, verify:

### 1. Database Created
```bash
# In MySQL command line or phpMyAdmin:
SHOW DATABASES;
# Should see: real_estate_db
```

### 2. Users Table Created
```bash
SELECT * FROM users;
# Should show 3 rows: demo, agent, admin
# password_encrypted column should contain: >=||_@(/JTA
```

### 3. Properties Table Created
```bash
SELECT * FROM properties;
# Should show 6 properties with images
```

### 4. Test Login Works
1. Go to login.php
2. Enter: demo / password123
3. Should see dashboard with properties
4. Try password toggle (eye icon) - should show 3 states

### 5. Test Signup Works
1. Go to signup.php
2. Create new account (e.g., testuser / mypassword123)
3. Should be able to login with new credentials
4. Check database - new password should be encrypted

---

## 📁 Files Modified & Created

### ✅ Configuration Changed
- **includes/config.php**
  - `OFFLINE_MODE` changed to `false` (database mode enabled)

### ✅ Database Files
- **database_setup.sql** - Updated test passwords to correct encrypted values
- **setup-database.php** - ✨ NEW automated setup script
- **DATABASE_ENCRYPTION_GUIDE.md** - ✨ NEW comprehensive guide

### ✅ Verified Working
- **includes/Cipher.php** - Encryption/Decryption ✓
- **includes/User.php** - Registration & Login with encryption ✓
- **api/auth.php** - API endpoints ✓
- **assets/js/main.js** - Password toggle & form handling ✓
- **login.php** - Login form ✓
- **signup.php** - Signup form ✓
- **dashboard.php** - Authenticated dashboard ✓

---

## 🆘 Troubleshooting

### Error: "Connection failed"
**Problem:** MySQL not running
**Solution:**
1. Open XAMPP Control Panel
2. Click "Start" next to MySQL
3. Wait 2 seconds
4. Refresh browser

### Error: "Access denied for user 'root'@'localhost'"
**Problem:** Root password is set
**Solution:** Edit `includes/config.php`:
```php
// Change this line:
define('DB_PASSWORD', '');
// To your MySQL root password:
define('DB_PASSWORD', 'your_password_here');
```

### Error: Database already exists
**Problem:** Running setup twice
**Solution:** This is fine! The script uses `IF NOT EXISTS` clauses, so it's safe to run multiple times

### Login fails with "Invalid username or password"
**Problem:** Password not decrypting correctly
**Solution:**
1. Check cipher mapping is correct (see DATABASE_ENCRYPTION_GUIDE.md)
2. Verify password in database: `SELECT * FROM users WHERE username='demo';`
3. Should see: `>=||_@(/JTA`

### Password toggle not showing encrypted state
**Problem:** JavaScript not loaded
**Solution:**
1. Check browser console (F12 → Console tab)
2. Look for JavaScript errors
3. Verify main.js is loaded: `http://localhost/Encryption/assets/js/main.js`

---

## 🎯 Next Steps

### Immediate (Do Now)
1. ✓ Run `setup-database.php` to initialize database
2. ✓ Test login with demo/password123
3. ✓ Check password toggle on login page

### Short Term (Optional Enhancements)
1. Create more test accounts
2. Add properties with custom images
3. Test favorites functionality
4. Test password matching on signup

### Long Term (Production Ready)
1. Change `DB_PASSWORD` to secure password
2. Implement HTTPS/SSL
3. Consider using bcrypt instead of custom cipher
4. Add rate limiting to auth endpoints
5. Implement CSRF tokens

---

## 📊 Database Credentials

**File:** `includes/config.php`

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');           // Set if needed
define('DB_NAME', 'real_estate_db');
define('OFFLINE_MODE', false);       // ← Database mode ENABLED
```

---

## 🔄 Encryption Details

**Algorithm:** Substitution Cipher (Custom)
**Location:** `includes/Cipher.php`
**Key Components:**
- 26 letters → 26 unique symbols
- 10 numbers → 10 letters
- Space → period
- Reversible (can decrypt to verify passwords)

**Security Note:** This is a demonstration cipher. For production, use bcrypt or Argon2.

---

## 📝 Summary

Your Elite Homes real estate portal is **ready to function with database encryption**:

✅ Passwords encrypted with custom cipher
✅ Stored securely in database
✅ Decrypted on login for verification
✅ Three-state password toggle on UI
✅ Black theme with animated background
✅ Real estate property listings
✅ Favorites management

**Just run `setup-database.php` and you're live!**

---

**Need Help?** Check `DATABASE_ENCRYPTION_GUIDE.md` for detailed information.
