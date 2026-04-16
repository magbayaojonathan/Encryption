<?php
require_once 'includes/config.php';
require_once 'includes/Database.php';

requireLogin();

$user_id = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Elite Homes</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="dashboard-body">
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
    
    <!-- Dashboard Content -->
    <div class="dashboard-container">
        <div class="page-header">
            <h1>Welcome to Elite Homes</h1>
            <p>Browse our premium property listings</p>
        </div>
        
        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">1,250+</div>
                <div class="stat-label">Properties Listed</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">50+</div>
                <div class="stat-label">Professional Agents</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">$2.5B+</div>
                <div class="stat-label">Total Value</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">98%</div>
                <div class="stat-label">Client Satisfaction</div>
            </div>
        </div>
        
        <!-- Properties Grid -->
        <h2 style="margin-bottom: 1.5rem;">Featured Properties</h2>
        <div class="properties-grid" id="propertiesGrid">
            <!-- Properties loaded via JavaScript -->
            <div style="text-align: center; grid-column: 1 / -1;">
                <div class="loading"></div>
                <p>Loading properties...</p>
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
            <p>&copy; 2024 Elite Homes Real Estate. All rights reserved. | Privacy Policy | Terms of Service</p>
        </div>
    </footer>
    
    <script src="assets/js/main.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script>
        // Load properties when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadProperties();
        });
    </script>
</body>
</html>
