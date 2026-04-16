<?php
require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Homes - Premium Real Estate Portal</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="navbar-brand">🏠 Elite Homes</a>
            
            <ul class="navbar-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="<?php echo isLoggedIn() ? 'dashboard.php' : 'login.php'; ?>">Browse Properties</a></li>
                <li><a href="<?php echo isLoggedIn() ? 'profile.php' : 'login.php'; ?>">My Profile</a></li>
            </ul>
            
            <div class="navbar-user">
                <?php if (isLoggedIn()): ?>
                    <div class="user-info">
                        <p><?php echo htmlspecialchars($_SESSION['full_name'] ?? 'User'); ?></p>
                    </div>
                    <button class="logout-btn" onclick="logout()">Logout</button>
                <?php else: ?>
                    <a href="login.php" style="color: white; text-decoration: none; font-weight: 600;">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <div style="background: linear-gradient(135deg, var(--primary-color) 0%, #f6ad55 100%); color: white; padding: 5rem 2rem; text-align: center;">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Find Your Dream Home</h1>
        <p style="font-size: 1.2rem; margin-bottom: 2rem;">Discover premium properties in your desired location</p>
        
        <div style="max-width: 600px; margin: 0 auto; display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
            <input type="text" placeholder="Search location..." style="flex: 1; min-width: 200px; padding: 0.75rem 1rem; border: none; border-radius: 5px;">
            <select style="padding: 0.75rem 1rem; border: none; border-radius: 5px; min-width: 150px;">
                <option>All Types</option>
                <option>House</option>
                <option>Apartment</option>
                <option>Commercial</option>
                <option>Land</option>
            </select>
            <button style="padding: 0.75rem 2rem; background: var(--accent-color); color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;">Search</button>
        </div>
    </div>
    
    <!-- Features Section -->
    <div class="dashboard-container">
        <h2 style="text-align: center; margin: 3rem 0 2rem; font-size: 2rem;">Why Choose Elite Homes?</h2>
        
        <div class="stats-grid">
            <div class="stat-card" style="text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🔒</div>
                <div class="stat-label">
                    <strong>Secure Encrypted Authentication</strong>
                    <p style="margin-top: 0.5rem;">Your credentials are encrypted, not hashed. See your password encrypted in the login form.</p>
                </div>
            </div>
            <div class="stat-card" style="text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">💼</div>
                <div class="stat-label">
                    <strong>Professional Listings</strong>
                    <p style="margin-top: 0.5rem;">Browse our carefully curated collection of premium properties.</p>
                </div>
            </div>
            <div class="stat-card" style="text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">❤️</div>
                <div class="stat-label">
                    <strong>Save Your Favorites</strong>
                    <p style="margin-top: 0.5rem;">Mark properties as favorites and keep track of your preferences.</p>
                </div>
            </div>
            <div class="stat-card" style="text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">👥</div>
                <div class="stat-label">
                    <strong>Expert Agents</strong>
                    <p style="margin-top: 0.5rem;">Connect with experienced real estate professionals.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics Section -->
    <div style="background: linear-gradient(135deg, var(--primary-color) 0%, #1e3a5f 100%); color: white; padding: 3rem 2rem; margin: 3rem 0;">
        <div class="dashboard-container">
            <div class="stats-grid">
                <div style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: bold; margin-bottom: 0.5rem;">1,250+</div>
                    <p>Properties Listed</p>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: bold; margin-bottom: 0.5rem;">50+</div>
                    <p>Professional Agents</p>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: bold; margin-bottom: 0.5rem;">$2.5B+</div>
                    <p>Total Portfolio Value</p>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: bold; margin-bottom: 0.5rem;">98%</div>
                    <p>Client Satisfaction</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CTA Section -->
    <div class="dashboard-container" style="text-align: center; padding: 3rem 0;">
        <h2 style="margin-bottom: 1rem;">Ready to Get Started?</h2>
        <p style="color: var(--text-light); margin-bottom: 2rem;">Join thousands of satisfied clients finding their perfect home</p>
        
        <?php if (!isLoggedIn()): ?>
            <a href="login.php" style="
                display: inline-block;
                padding: 1rem 2rem;
                background: linear-gradient(135deg, var(--primary-color) 0%, #f6ad55 100%);
                color: white;
                text-decoration: none;
                border-radius: 8px;
                font-weight: 600;
                transition: all 0.3s ease;
            " onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                Register Now
            </a>
        <?php else: ?>
            <a href="dashboard.php" style="
                display: inline-block;
                padding: 1rem 2rem;
                background: linear-gradient(135deg, var(--primary-color) 0%, #f6ad55 100%);
                color: white;
                text-decoration: none;
                border-radius: 8px;
                font-weight: 600;
                transition: all 0.3s ease;
            " onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                Browse Properties
            </a>
        <?php endif; ?>
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
</body>
</html>
