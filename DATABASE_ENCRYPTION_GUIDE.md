# 🔐 Elite Homes - Complete Encryption & Database Setup Guide

## Overview

The system is now fully connected to a **MySQL database** with **custom cipher encryption** for passwords. When you create an account or log in, passwords are encrypted using a substitution cipher (NOT hashed) and stored securely in the database.

---

## 🚀 Quick Setup

### Step 1: Run Database Setup
1. Go to `http://localhost/Encryption/setup-database.php`
2. This will automatically create:
   - Database: `real_estate_db`
   - Tables: `users`, `properties`, `favorites`
   - Test accounts with encrypted passwords

### Step 2: Test Login
- **Username:** demo (or agent, or admin)
- **Password:** password123
- All passwords are encrypted as: `>=||_@(/JTA`

---

## 🔐 Encryption Flow

### Account Creation (Signup)

```
User Input
    ↓
Frontend: Stores plaintext in data-plaintext attribute
    ↓
Form Submission: Sends plaintext to api/auth.php
    ↓
Backend (api/auth.php): Calls User::register()
    ↓
User.php: Applies Cipher::encrypt() to password
    ↓
Database: Stores ENCRYPTED password in password_encrypted column
```

**Example:**
- User types: `password123`
- Encrypted as: `>=||_@(/JTA`
- Stored in DB: `>=||_@(/JTA`

### Login Flow

```
User Input
    ↓
Frontend: Stores plaintext in data-plaintext attribute
    ↓
Form Submission: Sends plaintext to api/auth.php
    ↓
Backend (api/auth.php): Calls User::login()
    ↓
User.php: Fetches encrypted password from database
    ↓
Cipher::decrypt() on stored password
    ↓
Compare decrypted value with user input
    ↓
Match = Login Success ✓
```

---

## 🔤 Cipher Mapping Reference

The custom cipher uses substitution mapping:

| Letter | Cipher | Letter | Cipher | Number | Cipher |
|--------|--------|--------|--------|--------|--------|
| A/a    | =      | N/n    | &      | 0      | K      |
| B/b    | !      | O/o    | @      | 1      | J      |
| C/c    | *      | P/p    | >      | 2      | T      |
| D/d    | /      | Q/q    | '      | 3      | A      |
| E/e    | ,      | R/r    | (      | 4      | M      |
| F/f    | #      | S/s    | \|     | 5      | R      |
| G/g    | ;      | T/t    | ]      | 6      | L      |
| H/h    | :      | U/u    | {      | 7      | E      |
| I/i    | '      | V/v    | `      | 8      | S      |
| J/j    | +      | W/w    | _      | 9      | D      |
| K/k    | ?      | X/x    | ~      | Space  | .      |
| L/l    | -      | Y/y    | %      |        |        |
| M/m    | <      | Z/z    | $      |        |        |

**Example: 'password123' Encryption**
```
p → >
a → =
s → |
s → |
w → _
o → @
r → (
d → /
1 → J
2 → T
3 → A
Result: >=||_@(/JTA
```

---

## 📁 Key Files

### Backend Encryption
- **`includes/Cipher.php`** - Encryption/Decryption logic
- **`includes/User.php`** - User registration & login with encryption
- **`includes/config.php`** - Configuration (OFFLINE_MODE = false for database)
- **`includes/Database.php`** - Database connection layer
- **`api/auth.php`** - Authentication API endpoints

### Frontend
- **`assets/js/main.js`** - Password toggle & form handling
- **`login.php`** - Login form with three-state password toggle
- **`signup.php`** - Registration form with password matching
- **`dashboard.php`** - Authenticated user dashboard

### Database
- **`database_setup.sql`** - SQL schema and test data
- **`setup-database.php`** - Automated setup script

---

## 🔄 Database Connection Details

**File:** `includes/config.php`

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'real_estate_db');
define('OFFLINE_MODE', false); // ← Set to false to use database
```

**To switch modes:**
- `OFFLINE_MODE = true` → Uses session storage (no database needed)
- `OFFLINE_MODE = false` → Uses MySQL database (requires setup)

---

## 📊 Database Schema

### Users Table
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_encrypted VARCHAR(255) NOT NULL,  ← Stores encrypted password
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    role ENUM('admin', 'agent', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Key Point:** The `password_encrypted` column stores the cipher-encrypted password, NOT a hash. This allows decryption for verification.

### Properties Table
```sql
CREATE TABLE properties (
    id INT PRIMARY KEY AUTO_INCREMENT,
    agent_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    price DECIMAL(12, 2) NOT NULL,
    location VARCHAR(255) NOT NULL,
    bedrooms INT,
    bathrooms INT,
    area_sqft INT,
    FOREIGN KEY (agent_id) REFERENCES users(id)
);
```

### Favorites Table
```sql
CREATE TABLE favorites (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    property_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (property_id) REFERENCES properties(id),
    UNIQUE KEY unique_favorite (user_id, property_id)
);
```

---

## ✨ Features

### Account Creation with Encryption
- ✓ Password encrypted before saving to database
- ✓ Uses custom cipher (not MD5/SHA1/bcrypt)
- ✓ Real-time password strength indicator
- ✓ Real-time password match feedback
- ✓ Three-state password toggle (Hidden/Decrypted/Encrypted)

### Login with Decryption
- ✓ Fetches encrypted password from database
- ✓ Decrypts with cipher
- ✓ Compares with user input
- ✓ Session-based authentication
- ✓ Secure logout

### Dashboard
- ✓ Black background with animated moving dots
- ✓ Real estate property listings with images
- ✓ Add/Remove favorites
- ✓ View property details
- ✓ User profile management

### API Endpoints
- `POST /api/auth.php?action=register` - Create account
- `POST /api/auth.php?action=login` - Login user
- `POST /api/auth.php?action=logout` - Logout user
- `GET /api/properties.php?action=list` - List properties
- `POST /api/properties.php?action=toggle_favorite` - Manage favorites

---

## 🧪 Testing

### Test the Encryption Manually

**Login with demo account:**
1. Username: `demo`
2. Password: `password123`
3. The system will:
   - Fetch encrypted password from DB: `>=||_@(/JTA`
   - Decrypt it back to: `password123`
   - Compare with user input: ✓ Match!

### Check Database Values

```sql
SELECT username, password_encrypted FROM users;
-- demo, >=||_@(/JTA
-- agent, >=||_@(/JTA
-- admin, >=||_@(/JTA
```

---

## 🔒 Security Notes

1. **Encryption vs Hashing:**
   - This system uses **encryption** (reversible) not **hashing** (irreversible)
   - Passwords can be decrypted for verification
   - Good for this project's educational purposes
   - In production, consider bcrypt/Argon2

2. **Data Protection:**
   - Passwords encrypted at rest in database
   - SSL/HTTPS recommended for transmission
   - Session cookies should be secure

3. **Backups:**
   - Database backups will contain encrypted passwords
   - Encrypted data is still sensitive - protect backups

---

## 🆘 Troubleshooting

**Problem:** "Database connection failed"
- **Solution:** Run `setup-database.php` to create database
- Check MySQL is running on localhost
- Verify root user has no password

**Problem:** Login fails even with correct password
- **Solution:** Ensure password in DB is encrypted correctly
- Check `OFFLINE_MODE = false` in config.php
- Verify cipher mapping hasn't been modified

**Problem:** New users can't log in after signup
- **Solution:** Password is being encrypted correctly
- Check database user was created: `SELECT * FROM users;`
- Verify password_encrypted column has a value

---

## 📝 Next Steps

1. ✓ Run `setup-database.php` to initialize database
2. ✓ Test login with credentials: demo / password123
3. ✓ Create new accounts to test encryption
4. ✓ Verify passwords are stored encrypted in database
5. ✓ Browse properties and add to favorites
6. ✓ Check profile and account settings

---

**Happy Encrypting! 🔐🏠**
