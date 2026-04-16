# 🚀 Elite Homes - Quick Reference

## 📋 System Overview

```
┌─────────────────────────────────────────────────────────────┐
│              ELITE HOMES REAL ESTATE PORTAL                │
│              Database Mode with Cipher Encryption           │
└─────────────────────────────────────────────────────────────┘

  Frontend (Browser)          Backend (PHP)           Database (MySQL)
  ─────────────────          ──────────────          ─────────────────
  
  [Login Form]
        ↓
  data-plaintext = "password123"
        ↓
  Submit to API ──────→ [api/auth.php]
                            ↓
                       [User.php]
                            ↓
                       [Cipher.php]
                       encrypt()
                            ↓
        ">=||_@(/JTA" ──→ [Database]
                       password_encrypted
```

---

## 🔐 Encryption Reference

### Three-State Password Toggle

```
Click Eye Icon (3 States):

State 1: HIDDEN (●●●●●●●●●●)
         Type: password
         Display: dots

State 2: DECRYPTED (password123)
         Type: text
         Display: plaintext

State 3: ENCRYPTED (>=||_@(/JTA)
         Type: text  
         Display: cipher symbols
         Styling: 3px letter-spacing, red, monospace
```

### Cipher Mapping Quick Reference

```
Letters (A-Z):
A=  B!  C*  D/  E,  F#  G;  H:  I'  J+  K?  L-  M<  N&  O@
P>  Q'  R(  S|  T]  U{  V`  W_  X~  Y%  Z$

Numbers (0-9):
0=K  1=J  2=T  3=A  4=M  5=R  6=L  7=E  8=S  9=D

Special:
Space = .
```

### Example: Encrypting "password123"

```
p a s s w o r d 1 2 3
↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓
> = | | _ @ ( / J T A
```

**Result: `>=||_@(/JTA`**

---

## 🛠️ Setup Instructions

### One-Time Setup
```
1. Start MySQL in XAMPP
2. Visit: http://localhost/Encryption/setup-database.php
3. Wait for success message
4. Done! ✓
```

### Test Login
```
Username: demo
Password: password123
```

---

## 🔄 Data Flow

### Registration (Signup)

```
User Input
├─ Username: john_doe
├─ Email: john@example.com
├─ Password: mySecret123
└─ Full Name: John Doe

          ↓ (Send to API)

api/auth.php (POST register)
├─ Receive plaintext password
├─ Validate format
└─ Pass to User.php

          ↓

User::register()
├─ Check if user exists
├─ Encrypt password with Cipher
├─ Password: mySecret123 → <~E*5,2JTA
└─ Insert into database

          ↓

Database users table
├─ username: john_doe
├─ email: john@example.com
├─ password_encrypted: <~E*5,2JTA  ← ENCRYPTED!
└─ created_at: 2024-01-15 10:30:00
```

### Login (Authentication)

```
User Input
├─ Username: john_doe
└─ Password: mySecret123

          ↓ (Send to API)

api/auth.php (POST login)
├─ Receive plaintext password
└─ Pass to User.php

          ↓

User::login()
├─ Query database for user
├─ Fetch password_encrypted: <~E*5,2JTA
├─ Decrypt using Cipher: <~E*5,2JTA → mySecret123
├─ Compare with input: mySecret123 === mySecret123 ✓
└─ Create session

          ↓

Browser
└─ Redirect to dashboard.php
```

---

## 📁 Key Files

| File | Purpose | Status |
|------|---------|--------|
| setup-database.php | Initialize database | ✅ Ready |
| includes/config.php | Database credentials | ✅ Configured |
| includes/Cipher.php | Encryption/Decryption | ✅ Working |
| includes/User.php | Auth logic with cipher | ✅ Ready |
| api/auth.php | API endpoints | ✅ Ready |
| login.php | Login form | ✅ Ready |
| signup.php | Registration form | ✅ Ready |
| dashboard.php | Main dashboard | ✅ Ready |

---

## ✨ Features

### ✅ Password Security
- Custom substitution cipher
- Passwords encrypted before database storage
- Decrypted on login for verification
- Plaintext never stored in database

### ✅ User Interface
- Three-state password toggle (Hidden/Decrypted/Encrypted)
- Real-time password strength indicator
- Real-time password match feedback
- Black & white theme
- Animated background with moving dots
- Real estate images from Unsplash

### ✅ Functionality
- User registration with validation
- Email and username uniqueness
- Password confirmation
- Profile management
- Property browsing
- Favorites management
- Logout functionality

---

## 🧪 Testing Commands

### Verify Database Setup
```sql
-- Check database exists
SHOW DATABASES;
-- Should show: real_estate_db

-- Check users table
USE real_estate_db;
SELECT username, password_encrypted FROM users;
-- Should show demo, agent, admin with encrypted passwords
```

### Test Password Encryption
```
JavaScript console: cipherMap check
Frontend encrypt: Password toggle
Backend encrypt: Check database values
```

### Test API Endpoints
```
POST /api/auth.php?action=login
{
  "username": "demo",
  "password": "password123"
}

POST /api/auth.php?action=register
{
  "username": "newuser",
  "email": "new@example.com",
  "password": "secure123",
  "full_name": "New User"
}
```

---

## 🚨 Common Issues & Fixes

| Issue | Cause | Fix |
|-------|-------|-----|
| "Connection failed" | MySQL not running | Start MySQL in XAMPP |
| "User already exists" | Try registering with demo | Use different username |
| Login fails | Wrong encrypted password | Run setup-database.php |
| Password toggle broken | JavaScript error | Check browser console |
| Can't see encrypted state | CSS not loaded | Hard refresh (Ctrl+F5) |

---

## 🎯 URLs Reference

```
Login Page:           http://localhost/Encryption/login.php
Sign Up Page:         http://localhost/Encryption/signup.php
Dashboard:            http://localhost/Encryption/dashboard.php
API - Auth:           http://localhost/Encryption/api/auth.php
Setup Database:       http://localhost/Encryption/setup-database.php
Cipher Mapping:       http://localhost/Encryption/cipher-reference.php
```

---

## 💡 Pro Tips

1. **Password Toggle** - Click eye icon in password field to see states
2. **Test Encryption** - Try signup, check database for encrypted password
3. **Multiple Accounts** - Create test accounts to verify encryption works for each
4. **Favorites** - Click heart icon on properties to save favorites
5. **Profile** - Update profile info after logging in

---

## 🔐 Security Notes

⚠️ **This is a demonstration system:**
- Custom cipher is educational, not production-grade
- Passwords are reversible (encrypted, not hashed)
- No rate limiting on login attempts
- No HTTPS/SSL in development

✅ **For production:**
- Replace custom cipher with bcrypt or Argon2
- Implement HTTPS
- Add rate limiting
- Use secure session cookies
- Enable CSRF protection

---

**System Status: ✅ READY FOR DATABASE INITIALIZATION**

Next Action: Run `setup-database.php`
