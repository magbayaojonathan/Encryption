<?php
require_once 'includes/config.php';

redirectIfLoggedIn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Elite Homes</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-wrapper">
            <div class="login-header">
                <h1>🏠 Elite Homes</h1>
                <p>Create Your Account</p>
            </div>
            
            <div class="login-body">
                <div id="alertContainer"></div>
                <form onsubmit="handleRegister(event)" id="signupForm">
                    <div class="form-group">
                        <label for="registerUsername">Username</label>
                        <input type="text" id="registerUsername" placeholder="Choose a unique username" 
                               pattern="[a-zA-Z0-9_]{3,20}" title="3-20 characters, letters, numbers, underscore only" required>
                        <small>3-20 characters (letters, numbers, underscore)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="registerEmail">Email Address</label>
                        <input type="email" id="registerEmail" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="registerFullName">Full Name</label>
                        <input type="text" id="registerFullName" placeholder="Enter your full name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="registerPhone">Phone Number <span style="color: #999999;">(Optional)</span></label>
                        <input type="tel" id="registerPhone" placeholder="(555) 123-4567">
                    </div>
                    
                    <div class="form-group password-wrapper">
                        <label for="registerPassword">Password</label>
                        <input type="password" id="registerPassword" class="password-field" placeholder="Create a strong password" 
                               minlength="6" required 
                               data-plaintext="" data-visibility-state="hidden"
                               oninput="updatePasswordStrength(this.value); this.setAttribute('data-plaintext', this.value); checkPasswordMatch();">
                        <button type="button" id="registerPasswordToggle" class="password-toggle" data-input="registerPassword" onclick="togglePasswordVisibility('registerPassword', 'registerPasswordToggle')">👁️‍🗨️</button>
                        <small id="passwordStrength" style="color: var(--text-light); font-size: 0.8rem; display: block; margin-top: 0.25rem;"></small>
                    </div>
                    
                    <div class="form-group password-wrapper">
                        <label for="registerConfirmPassword">Confirm Password</label>
                        <input type="password" id="registerConfirmPassword" class="password-field" placeholder="Confirm your password" 
                               minlength="6" required 
                               data-plaintext="" data-visibility-state="hidden"
                               oninput="this.setAttribute('data-plaintext', this.value); checkPasswordMatch();">
                        <button type="button" id="registerConfirmPasswordToggle" class="password-toggle" data-input="registerConfirmPassword" onclick="togglePasswordVisibility('registerConfirmPassword', 'registerConfirmPasswordToggle')">👁️‍🗨️</button>
                        <small id="passwordMatch" style="color: #999999; font-size: 0.8rem; display: block; margin-top: 0.25rem;"></small>
                    </div>
                    
                    <!-- Encryption Info -->
                    <div style="background: #f0f0f0; border: 2px solid #000000; border-radius: 8px; padding: 1rem; margin-bottom: 1rem; font-size: 0.85rem; color: #000000; line-height: 1.5;">
                        <strong>🔐 Password Toggle Guide:</strong>
                        <ul style="margin-top: 0.5rem; margin-left: 1.5rem; list-style: disc;">
                            <li>👁️‍🗨️ Hidden: Password shown as dots</li>
                            <li>🔒 Decrypted: Shows your actual password</li>
                            <li>🔐 Encrypted: Shows encrypted version</li>
                        </ul>
                    </div>
                    
                    <button type="submit" class="btn-primary">Create My Account</button>
                </form>
                
                <div class="form-footer">
                    <p>Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="assets/js/main.js"></script>
    <script>
        // Password strength indicator
        function updatePasswordStrength(password) {
            const strengthEl = document.getElementById('passwordStrength');
            let strength = 'Weak';
            let color = '#f56565';
            
            if (password.length >= 8) {
                if (/[a-z]/.test(password) && /[A-Z]/.test(password) && /[0-9]/.test(password)) {
                    strength = 'Strong';
                    color = '#48bb78';
                } else if (/[a-z]/.test(password) || /[A-Z]/.test(password) || /[0-9]/.test(password)) {
                    strength = 'Medium';
                    color = '#f6ad55';
                }
            }
            
            strengthEl.textContent = `Password strength: ${strength}`;
            strengthEl.style.color = color;
        }
    </script>
</body>
</html>
