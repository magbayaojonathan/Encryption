<?php
require_once 'includes/config.php';
require_once 'includes/Database.php';

requireLogin();

// Get property ID from URL
$property_id = $_GET['id'] ?? 0;

$db = new Database();
$db->connect();
$conn = $db->getConnection();

// Get property details
$query = "SELECT p.*, u.username, u.full_name, u.phone, u.email FROM properties p 
         LEFT JOIN users u ON p.agent_id = u.id 
         WHERE p.id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $property_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: dashboard.php');
    exit;
}

$property = $result->fetch_assoc();

// Check if favorited
$user_id = getCurrentUser();
$query = "SELECT id FROM favorites WHERE user_id = ? AND property_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $user_id, $property_id);
$stmt->execute();
$is_favorite = $stmt->get_result()->num_rows > 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($property['title']); ?> - Elite Homes</title>
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
    
    <!-- Property Details -->
    <div class="dashboard-container" style="padding: 2rem;">
        <a href="dashboard.php" style="color: var(--primary-color); text-decoration: none; margin-bottom: 1rem; display: inline-block;">← Back to Properties</a>
        
        <!-- Property Image -->
        <div style="
            width: 100%;
            height: 400px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #f6ad55 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 5rem;
            margin-bottom: 2rem;
        ">🏠</div>
        
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; align-items: start;">
            <!-- Left Column -->
            <div>
                <h1 style="margin-bottom: 0.5rem;"><?php echo htmlspecialchars($property['title']); ?></h1>
                <p style="color: var(--text-light); font-size: 1.1rem; margin-bottom: 1rem;">📍 <?php echo htmlspecialchars($property['location']); ?></p>
                
                <h2 style="color: var(--secondary-color); font-size: 2rem; margin-bottom: 1.5rem;">$<?php echo number_format($property['price'], 0); ?></h2>
                
                <!-- Property Details -->
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid var(--border-color);">
                    <div style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: bold; color: var(--primary-color);"><?php echo $property['bedrooms']; ?></div>
                        <div style="color: var(--text-light);">Bedrooms</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: bold; color: var(--primary-color);"><?php echo $property['bathrooms']; ?></div>
                        <div style="color: var(--text-light);">Bathrooms</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: bold; color: var(--primary-color);"><?php echo number_format($property['area_sqft']); ?></div>
                        <div style="color: var(--text-light);">Sqft</div>
                    </div>
                </div>
                
                <!-- Description -->
                <h3 style="margin-bottom: 1rem;">Description</h3>
                <p style="line-height: 1.8; color: var(--text-light); margin-bottom: 2rem;">
                    <?php echo htmlspecialchars($property['description']); ?>
                </p>
                
                <!-- Property Type -->
                <h3 style="margin-bottom: 0.5rem;">Property Type</h3>
                <p style="text-transform: capitalize; color: var(--primary-color); font-weight: 600; margin-bottom: 2rem;">
                    <?php echo htmlspecialchars($property['property_type']); ?>
                </p>
                
                <!-- Amenities -->
                <h3 style="margin-bottom: 1rem;">Key Features</h3>
                <ul style="list-style: none; color: var(--text-light);">
                    <li style="padding: 0.5rem 0;">✓ Modern Kitchen</li>
                    <li style="padding: 0.5rem 0;">✓ Spacious Living Area</li>
                    <li style="padding: 0.5rem 0;">✓ Master Suite with En Suite</li>
                    <li style="padding: 0.5rem 0;">✓ Outdoor Patio</li>
                    <li style="padding: 0.5rem 0;">✓ Parking Available</li>
                </ul>
            </div>
            
            <!-- Right Column -->
            <div>
                <!-- Agent Card -->
                <div style="background: white; border-radius: 10px; padding: 1.5rem; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08); border-left: 5px solid var(--primary-color); margin-bottom: 1.5rem;">
                    <h3 style="margin-bottom: 1rem;">Listed by</h3>
                    <div style="text-align: center;">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-color) 0%, #f6ad55 100%); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">👨‍💼</div>
                        <h4><?php echo htmlspecialchars($property['full_name'] ?? 'Agent'); ?></h4>
                        <p style="color: var(--text-light); font-size: 0.9rem;">Real Estate Agent</p>
                        
                        <?php if ($property['phone']): ?>
                            <p style="margin-top: 1rem; color: var(--primary-color); font-weight: 600;">
                                📞 <?php echo htmlspecialchars($property['phone']); ?>
                            </p>
                        <?php endif; ?>
                        
                        <?php if ($property['email']): ?>
                            <p style="color: var(--primary-color); font-weight: 600;">
                                📧 <?php echo htmlspecialchars($property['email']); ?>
                            </p>
                        <?php endif; ?>
                        
                        <button style="
                            width: 100%;
                            margin-top: 1rem;
                            padding: 0.75rem;
                            background: linear-gradient(135deg, var(--primary-color) 0%, #f6ad55 100%);
                            color: white;
                            border: none;
                            border-radius: 5px;
                            cursor: pointer;
                            font-weight: 600;
                        ">Contact Agent</button>
                    </div>
                </div>
                
                <!-- Favorite Button -->
                <button onclick="toggleFavorite(<?php echo $property_id; ?>, this)" style="
                    width: 100%;
                    padding: 1rem;
                    border: 2px solid var(--danger-color);
                    background: <?php echo $is_favorite ? 'var(--danger-color)' : 'white'; ?>;
                    color: <?php echo $is_favorite ? 'white' : 'var(--danger-color)'; ?>;
                    border-radius: 8px;
                    cursor: pointer;
                    font-weight: 600;
                    font-size: 1rem;
                    transition: all 0.3s ease;
                " class="btn-small favorite <?php echo $is_favorite ? 'active' : ''; ?>">
                    <?php echo $is_favorite ? '❤️ Favorited' : '🤍 Add to Favorites'; ?>
                </button>
                
                <!-- Quick Info -->
                <div style="background: var(--light-bg); border-radius: 10px; padding: 1.5rem; margin-top: 1.5rem;">
                    <h4 style="margin-bottom: 1rem;">Quick Info</h4>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-color);">
                        <span>Property Type:</span>
                        <strong style="text-transform: capitalize;"><?php echo htmlspecialchars($property['property_type']); ?></strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-color);">
                        <span>Year Built:</span>
                        <strong>2022</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-color);">
                        <span>Property Tax:</span>
                        <strong>$4,200/yr</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>HOA Fees:</span>
                        <strong>$350/mo</strong>
                    </div>
                </div>
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
