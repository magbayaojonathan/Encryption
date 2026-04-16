<?php
require_once 'includes/config.php';
require_once 'includes/Database.php';
require_once 'includes/User.php';

requireLogin();

$user_id = getCurrentUser();
$db = new Database();
$db->connect();
$user_obj = new User($db);
$user_data = $user_obj->getUserById($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Elite Homes</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="navbar-brand">🏠 Elite Homes</a>
            
            <ul class="navbar-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Browse Properties</a></li>
                <li><a href="profile.php">My Profile</a></li>
            </ul>
            
            <div class="navbar-user">
                <div class="user-info">
                    <p><?php echo htmlspecialchars($_SESSION['full_name'] ?? 'User'); ?></p>
                </div>
                <button class="logout-btn" onclick="logout()">Logout</button>
            </div>
        </div>
    </nav>
    
    <!-- Profile Content -->
    <div class="profile-container">
        <div class="page-header">
            <h1>My Profile</h1>
            <p>Manage your account information</p>
        </div>
        
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">👤</div>
            <div class="profile-info">
                <h2><?php echo htmlspecialchars($user_data['full_name'] ?? 'User'); ?></h2>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user_data['username']); ?></p>
                <p><strong>Role:</strong> <?php echo ucfirst($user_data['role']); ?></p>
                <p><strong>Member Since:</strong> <?php echo date('M d, Y', strtotime($user_data['created_at'])); ?></p>
            </div>
        </div>
        
        <!-- Edit Profile Form -->
        <div class="profile-form">
            <h3 style="margin-bottom: 1.5rem;">Edit Profile Information</h3>
            
            <form id="profileForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" id="fullName" name="fullName" value="<?php echo htmlspecialchars($user_data['full_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user_data['phone'] ?? ''); ?>">
                    </div>
                </div>
                
                <button type="submit" class="btn-primary">Update Profile</button>
            </form>
        </div>
        
        <!-- Account Security Section -->
        <div class="profile-form" style="margin-top: 2rem;">
            <h3 style="margin-bottom: 1.5rem;">🔒 Account Security</h3>
            
            <div style="background: #bee3f8; border: 1px solid #90cdf4; border-radius: 8px; padding: 1.5rem; color: #2c5282;">
                <p><strong>Encryption Notice:</strong></p>
                <p style="margin-top: 0.5rem;">
                    Your password is stored in <strong>encrypted format</strong> in our database, not hashed. This unique approach gives you the ability to reveal your password when needed.
                </p>
                <ul style="margin-top: 1rem; margin-left: 1.5rem;">
                    <li>When you log in, we encrypt your input and compare it with the stored encrypted password</li>
                    <li>In the login form, you can toggle to see your password in encrypted format</li>
                    <li>Your data remains secure and recoverable</li>
                </ul>
            </div>
        </div>
        
        <!-- Account Statistics -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
            <div class="stat-card">
                <div class="stat-number">12</div>
                <div class="stat-label">Favorite Properties</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">5</div>
                <div class="stat-label">Property Alerts</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">3</div>
                <div class="stat-label">Favorites Shortlisted</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">✓</div>
                <div class="stat-label">Email Verified</div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <ul>
                    <li><a href="#">About Elite Homes</a></li>
                    <li><a href="#">Our Mission</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Press</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>For Buyers</h3>
                <ul>
                    <li><a href="#">Browse Properties</a></li>
                    <li><a href="#">Saved Favorites</a></li>
                    <li><a href="#">Mortgage Calculator</a></li>
                    <li><a href="#">Buying Guide</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>For Agents</h3>
                <ul>
                    <li><a href="#">List Your Property</a></li>
                    <li><a href="#">Agent Dashboard</a></li>
                    <li><a href="#">Marketing Tools</a></li>
                    <li><a href="#">Support</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Contact</h3>
                <ul>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2024 Elite Homes Real Estate. All rights reserved.</p>
        </div>
    </footer>
    
    <script src="assets/js/main.js"></script>
    <script src="assets/js/dashboard.js"></script>
</body>
</html>
