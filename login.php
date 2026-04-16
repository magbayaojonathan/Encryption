<?php
require_once 'includes/config.php';

redirectIfLoggedIn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Real Estate Portal</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-wrapper">
            <div class="login-header">
                <h1>🏠 Elite Homes</h1>
                <p>Your Premium Real Estate Portal</p>
            </div>
            
            <div class="login-body">
                <div id="loginForm" class="form-section active">
                    <h2 style="margin-bottom: 1.5rem; text-align: center;">Welcome Back</h2>
                    
                    <form onsubmit="handleLogin(event)" id="loginFormElement">
                        <div class="form-group">
                            <label for="loginUsername">Username or Email</label>
                            <input type="text" id="loginUsername" placeholder="Enter your username or email" required>
                        </div>
                        
                        <div class="form-group password-wrapper">
                            <label for="loginPassword">Password</label>
                            <input type="password" id="loginPassword" class="password-field" placeholder="Enter your password" required 
                                   data-plaintext="" data-visibility-state="hidden"
                                   oninput="this.setAttribute('data-plaintext', this.value)">
                            <button type="button" id="loginPasswordToggle" class="password-toggle" data-input="loginPassword" onclick="togglePasswordVisibility('loginPassword', 'loginPasswordToggle')">👁️‍🗨️</button>
                        </div>
                        
                        <!-- Encryption Info -->
                        <div style="background: #f0f0f0; border: 2px solid #000000; border-radius: 8px; padding: 0.75rem; margin-bottom: 1rem; font-size: 0.85rem; color: #000000;">
                            <strong>💡 Tip:</strong> Click the eye icon to toggle: hidden → decrypted → encrypted
                        </div>
                        
                        <button type="submit" class="btn-primary">Login</button>
                    </form>
                    
                    <div class="form-footer">
                        <p>Don't have an account? <a href="signup.php">Register here</a></p>
                        <p style="margin-top: 1rem; font-size: 0.9rem;"><a href="#" style="color: var(--primary-color);">Forgot Password?</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="assets/js/main.js"></script>
</body>
</html>
