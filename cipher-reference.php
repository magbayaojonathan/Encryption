<?php
/**
 * Cipher Reference & Test File
 * Shows the encryption mapping and allows testing
 */

require_once 'includes/Cipher.php';

$cipher = new Cipher();

// Get the cipher map for reference
$map = $cipher->getCipherMap();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cipher Reference - Elite Homes</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .cipher-table {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(40px, 1fr));
            gap: 5px;
            margin: 1rem 0;
        }
        .cipher-cell {
            background: white;
            border: 1px solid var(--border-color);
            padding: 0.5rem;
            text-align: center;
            border-radius: 4px;
            font-weight: 600;
            font-family: monospace;
        }
        .cipher-cell.plain {
            background: #bee3f8;
            color: #2c5282;
        }
        .cipher-cell.encrypted {
            background: #feebc8;
            color: #7c2d12;
        }
        .test-section {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="navbar-brand">🏠 Elite Homes</a>
            <ul class="navbar-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </div>
    </nav>
    
    <!-- Cipher Reference -->
    <div class="dashboard-container" style="padding: 2rem;">
        <div class="page-header">
            <h1>Cipher Reference Guide</h1>
            <p>See how text is encrypted using the substitution cipher</p>
        </div>
        
        <!-- Alphabet Mapping -->
        <div class="test-section">
            <h2>Uppercase Letters (A-Z)</h2>
            <div class="cipher-table">
                <?php 
                for ($i = 0; $i < 26; $i++) {
                    $plain = chr(65 + $i);
                    $encrypted = isset($map[$plain]) ? $map[$plain] : '?';
                    echo "<div>";
                    echo "<div class='cipher-cell plain'>$plain</div>";
                    echo "<div class='cipher-cell encrypted'>→ $encrypted</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
        
        <!-- Lowercase Mapping -->
        <div class="test-section">
            <h2>Lowercase Letters (a-z)</h2>
            <div class="cipher-table">
                <?php 
                for ($i = 0; $i < 26; $i++) {
                    $plain = chr(97 + $i);
                    $encrypted = isset($map[$plain]) ? $map[$plain] : '?';
                    echo "<div>";
                    echo "<div class='cipher-cell plain'>$plain</div>";
                    echo "<div class='cipher-cell encrypted'>→ $encrypted</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
        
        <!-- Numbers Mapping -->
        <div class="test-section">
            <h2>Numbers (0-9)</h2>
            <div class="cipher-table">
                <?php 
                for ($i = 0; $i < 10; $i++) {
                    $plain = (string)$i;
                    $encrypted = isset($map[$plain]) ? $map[$plain] : '?';
                    echo "<div>";
                    echo "<div class='cipher-cell plain'>$plain</div>";
                    echo "<div class='cipher-cell encrypted'>→ $encrypted</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
        
        <!-- Space Character -->
        <div class="test-section">
            <h2>Special Characters</h2>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <th style="text-align: left; padding: 0.5rem; border-bottom: 2px solid var(--border-color);">Character</th>
                    <th style="text-align: left; padding: 0.5rem; border-bottom: 2px solid var(--border-color);">Encrypted</th>
                    <th style="text-align: left; padding: 0.5rem; border-bottom: 2px solid var(--border-color);">Description</th>
                </tr>
                <tr>
                    <td style="padding: 0.5rem;">Space</td>
                    <td style="padding: 0.5rem;"><code><?php echo $map[' '] ?? 'Space'; ?></code></td>
                    <td style="padding: 0.5rem;">Space character</td>
                </tr>
            </table>
        </div>
        
        <!-- Test Encryption -->
        <div class="test-section">
            <h2>Test Encryption Tool</h2>
            <p style="color: var(--text-light); margin-bottom: 1rem;">Enter text to see how it gets encrypted:</p>
            
            <div class="form-group">
                <label>Plain Text</label>
                <input type="text" id="plainText" placeholder="Type something..." 
                       oninput="updateEncryption(this.value)">
            </div>
            
            <div class="form-group">
                <label>Encrypted Text</label>
                <input type="text" id="encryptedText" readonly 
                       style="background: var(--light-bg); letter-spacing: 2px;">
            </div>
        </div>
        
        <!-- Example Passwords -->
        <div class="test-section">
            <h2>Example Passwords</h2>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <th style="text-align: left; padding: 0.75rem; border-bottom: 2px solid var(--border-color); background: var(--light-bg);">Plain Password</th>
                    <th style="text-align: left; padding: 0.75rem; border-bottom: 2px solid var(--border-color); background: var(--light-bg);">Encrypted</th>
                    <th style="text-align: left; padding: 0.75rem; border-bottom: 2px solid var(--border-color); background: var(--light-bg);">Use</th>
                </tr>
                <tr>
                    <td style="padding: 0.75rem; border-bottom: 1px solid var(--border-color);">Pass123</td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid var(--border-color); font-family: monospace; font-weight: 600;">SDqq321</td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid var(--border-color);">Test accounts (demo, agent1, admin)</td>
                </tr>
                <tr>
                    <td style="padding: 0.75rem; border-bottom: 1px solid var(--border-color);">SecurePass</td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid var(--border-color); font-family: monospace; font-weight: 600;">
                        <?php echo htmlspecialchars($cipher->encrypt('SecurePass')); ?>
                    </td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid var(--border-color);">Example</td>
                </tr>
                <tr>
                    <td style="padding: 0.75rem; border-bottom: 1px solid var(--border-color);">123456789</td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid var(--border-color); font-family: monospace; font-weight: 600;">
                        <?php echo htmlspecialchars($cipher->encrypt('123456789')); ?>
                    </td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid var(--border-color);">Example</td>
                </tr>
            </table>
        </div>
        
        <!-- Key Features -->
        <div class="test-section" style="background: #bee3f8; border-left: 5px solid #2c5282;">
            <h3 style="color: #2c5282; margin-bottom: 1rem;">🔒 Key Features of This Cipher</h3>
            <ul style="list-style: none;">
                <li style="padding: 0.5rem 0;">✓ <strong>Substitution Cipher:</strong> Each character maps to exactly one other character</li>
                <li style="padding: 0.5rem 0;">✓ <strong>Reversible:</strong> Can be decrypted back to original text</li>
                <li style="padding: 0.5rem 0;">✓ <strong>Consistent:</strong> Same input always produces same output</li>
                <li style="padding: 0.5rem 0;">✓ <strong>Visible:</strong> Passwords shown encrypted when hidden in login form</li>
                <li style="padding: 0.5rem 0;">✓ <strong>Complete:</strong> All uppercase, lowercase, numbers, and space supported</li>
            </ul>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="footer" style="margin-top: 3rem;">
        <div class="footer-bottom">
            <p>&copy; 2024 Elite Homes Real Estate. All rights reserved.</p>
        </div>
    </footer>
    
    <script>
        function updateEncryption(plainText) {
            const encryptedInput = document.getElementById('encryptedText');
            
            // Call backend API to encrypt
            fetch('api/encrypt-test.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    text: plainText
                })
            })
            .then(response => response.json())
            .then(data => {
                encryptedInput.value = data.encrypted;
            })
            .catch(error => {
                console.error('Error:', error);
                encryptedInput.value = 'Error encrypting text';
            });
        }
    </script>
</body>
</html>
