# Elite Homes - Real Estate Portal with Encrypted Passwords

A complete real estate website featuring a unique encrypted password authentication system where passwords are stored in encrypted format (not hashed) and displayed encrypted in the login form when hidden.

## Features

### 🔒 Unique Encryption System
- **Substitution Cipher**: Uses a character substitution cipher for password encryption
- **Encrypted Display**: When you hide the password in the login form, it shows the encrypted version
- **Decrypted Display**: When you toggle to show the password, it displays the plain text
- **Database Storage**: Passwords stored in encrypted format in the database (not hashed)
- **Reversible Encryption**: Unlike hashes, encryption allows password recovery

### 🏠 Real Estate Features
- **Property Listings**: Browse premium properties with detailed information
- **Advanced Search**: Search properties by location and type
- **Property Details**: View full property information including bedrooms, bathrooms, area
- **Favorites**: Save favorite properties for later reference
- **User Profiles**: Manage your account information
- **Responsive Design**: Works on desktop, tablet, and mobile devices

### 🎨 Professional UI
- **Modern Design**: Real estate themed interface with premium colors
- **Real Estate Color Scheme**: Blue and orange gradient theme
- **Smooth Animations**: Fade-in effects and hover animations
- **Mobile Responsive**: Fully responsive across all devices

## Setup Instructions

### 1. Prerequisites
- XAMPP installed (or any server with PHP 7.4+)
- MySQL/MariaDB
- Modern web browser

### 2. Installation Steps

#### Step 1: Copy Files
Copy the entire Encryption folder to your XAMPP htdocs directory:
```
c:\xampppp\htdocs\Encryption
```

#### Step 2: Create Database
1. Start XAMPP (Apache + MySQL)
2. Open phpMyAdmin: http://localhost/phpmyadmin/
3. Copy the contents of `database_setup.sql`
4. Paste it into the SQL tab in phpMyAdmin
5. Click "Go" to execute

Or import the SQL file directly:
```sql
-- Run this in phpMyAdmin or MySQL console
-- Copy contents from database_setup.sql
```

#### Step 3: Verify Configuration
Check `includes/config.php` for correct database credentials:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'real_estate_db');
```

#### Step 4: Access the Application
Open your browser and navigate to:
```
http://localhost/Encryption/
```

### 3. Default Test Accounts

The database is pre-populated with test accounts:

**Regular User:**
- Username/Email: `demo`
- Password: `Pass123`

**Real Estate Agent:**
- Username/Email: `agent1`
- Email: `agent@realestate.com`
- Password: `Pass123`

**Administrator:**
- Username/Email: `admin`
- Email: `admin@realestate.com`
- Password: `Pass123`

## File Structure

```
Encryption/
├── index.php                 # Home page
├── login.php                 # Login/Register page
├── dashboard.php             # Properties browse page
├── profile.php               # User profile page
├── property.php              # Individual property details
├── database_setup.sql        # Database initialization script
│
├── includes/
│   ├── config.php           # Configuration file
│   ├── Database.php         # Database connection class
│   ├── Cipher.php           # Encryption/Decryption class
│   └── User.php             # User management class
│
├── api/
│   ├── auth.php             # Authentication API endpoints
│   ├── properties.php       # Properties API endpoints
│   └── user.php             # User management API endpoints
│
├── assets/
│   ├── css/
│   │   └── style.css        # Main stylesheet (real estate theme)
│   ├── js/
│   │   ├── main.js          # Main JavaScript (forms, modals)
│   │   └── dashboard.js     # Dashboard JavaScript
│   └── images/              # Image assets folder
```

## How Encryption Works

### Cipher System
The application uses a **substitution cipher** that maps:
- A-Z to custom alphabet
- a-z to custom alphabet  
- 0-9 to custom numbers
- Space character

### Example
- Plaintext: `Pass123`
- Encrypted: `SDqq321`

### Login Flow
1. User enters password in login form
2. Password appears normal until toggled hidden
3. When hidden, JavaScript encrypts it using the cipher
4. Encrypted version displays in the input field with character spacing
5. On submission, the entered plaintext is encrypted on the backend
6. Database compare: encrypted-input == encrypted-stored

### Password Toggle
- 👁️‍🗨️ Eye icon = Password hidden (shows encrypted)
- 👁️ Eye icon = Password visible (shows plaintext)

## API Endpoints

### Authentication
- **POST** `/api/auth.php` - Login and Register
  - Actions: `login`, `register`, `logout`

### Properties
- **GET** `/api/properties.php` - List properties
  - Parameters: `action=list`, `filter=all|my_listings`
- **POST** `/api/properties.php` - Property actions
  - Actions: `toggle_favorite`

### User
- **POST** `/api/user.php` - User management
  - Actions: `update_profile`

## Database Schema

### Users Table
- Stores user credentials with encrypted passwords
- Contains full_name, email, phone, role
- Password stored as `password_encrypted` (not hashed)

### Properties Table
- Real estate property listings
- Includes price, location, bedrooms, bathrooms, area
- Linked to agent (user) who listed it

### Favorites Table
- Has-many relationship between users and properties
- Stores user's favorite properties

## Security Notes

⚠️ **Important**: This encryption system is for demonstration purposes. For production use:

1. Use SSL/TLS for HTTPS
2. Sanitize all inputs (done with `htmlspecialchars()`)
3. Use parameterized queries (done with prepared statements)
4. Consider additional security layers
5. Implement rate limiting on login attempts
6. Add CORS protection
7. Validate all user inputs on backend

## Browser Compatibility

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Troubleshooting

### Database Connection Error
- Check MySQL is running in XAMPP
- Verify credentials in `includes/config.php`
- Ensure `real_estate_db` database exists

### Login Not Working
- Clear browser cache
- Check JavaScript console for errors (F12)
- Verify password is being encrypted correctly

### Properties Not Loading
- Check database tables exist
- Verify sample data was inserted
- Check browser console for AJAX errors

### Session Issues
- Clear browser cookies
- Restart browser
- Check PHP session settings in `php.ini`

## Customization

### Change Cipher Alphabet
Edit `includes/Cipher.php`:
```php
private $plainAlphabet  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789 ';
private $cipherAlphabet = 'QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm9876543210 ';
```

### Change Color Theme
Edit `assets/css/style.css` CSS variables:
```css
:root {
    --primary-color: #2c5282;
    --secondary-color: #f6ad55;
    /* ... more colors ... */
}
```

### Add More Properties
Insert data directly in database or create an admin panel

## Support

For questions or issues, check:
- Browser console (press F12) for JavaScript errors
- PHP error logs in XAMPP
- Database logs for SQL errors

## License

This project is created for educational purposes.

## Author

GitHub Copilot - Real Estate Portal with Encrypted Authentication System
