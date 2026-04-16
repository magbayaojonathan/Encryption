<?php
/**
 * Substitution Cipher Class
 * Encrypts and decrypts text using custom special character mapping
 * 
 * Mapping:
 * A-Z → Special characters and symbols
 * 0-9 → Letters (K,J,T,A,M,R,L,E,S,D)
 * Space → Period (.)
 */
class Cipher {
    
    // Uppercase letters to special characters mapping
    private $upperMap = [
        'A' => '=', 'B' => '!', 'C' => '*', 'D' => '/', 'E' => ',',
        'F' => '#', 'G' => ';', 'H' => ':', 'I' => "'", 'J' => '+',
        'K' => '?', 'L' => '-', 'M' => '<', 'N' => '&', 'O' => '@',
        'P' => '>', 'Q' => "'", 'R' => '(', 'S' => '|', 'T' => ']',
        'U' => '{', 'V' => '`', 'W' => '_', 'X' => '~', 'Y' => '%',
        'Z' => '$'
    ];
    
    // Reverse map for uppercase decryption
    private $upperMapReverse = [
        '=' => 'A', '!' => 'B', '*' => 'C', '/' => 'D', ',' => 'E',
        '#' => 'F', ';' => 'G', ':' => 'H', "'" => 'I', '+' => 'J',
        '?' => 'K', '-' => 'L', '<' => 'M', '&' => 'N', '@' => 'O',
        '>' => 'P', '(' => 'R', '|' => 'S', ']' => 'T', '{' => 'U',
        '`' => 'V', '_' => 'W', '~' => 'X', '%' => 'Y', '$' => 'Z'
    ];
    
    // Numbers to letters mapping
    private $numMap = [
        '0' => 'K', '1' => 'J', '2' => 'T', '3' => 'A', '4' => 'M',
        '5' => 'R', '6' => 'L', '7' => 'E', '8' => 'S', '9' => 'D'
    ];
    
    // Reverse map for numbers decryption
    private $numMapReverse = [
        'K' => '0', 'J' => '1', 'T' => '2', 'A' => '3', 'M' => '4',
        'R' => '5', 'L' => '6', 'E' => '7', 'S' => '8', 'D' => '9'
    ];
    
    // Space character
    private $space = '.';
    
    /**
     * Encrypt plaintext to ciphertext
     * @param string $plaintext
     * @return string
     */
    public function encrypt($plaintext) {
        $ciphertext = '';
        
        for ($i = 0; $i < strlen($plaintext); $i++) {
            $char = $plaintext[$i];
            
            // Handle space
            if ($char === ' ') {
                $ciphertext .= $this->space;
            }
            // Handle uppercase letters
            elseif (isset($this->upperMap[$char])) {
                $ciphertext .= $this->upperMap[$char];
            }
            // Handle lowercase letters - convert to uppercase first
            elseif (isset($this->upperMap[strtoupper($char)])) {
                $ciphertext .= $this->upperMap[strtoupper($char)];
            }
            // Handle numbers
            elseif (isset($this->numMap[$char])) {
                $ciphertext .= $this->numMap[$char];
            }
            // Keep other characters as is
            else {
                $ciphertext .= $char;
            }
        }
        
        return $ciphertext;
    }
    
    /**
     * Decrypt ciphertext to plaintext
     * @param string $ciphertext
     * @return string
     */
    public function decrypt($ciphertext) {
        $plaintext = '';
        
        for ($i = 0; $i < strlen($ciphertext); $i++) {
            $char = $ciphertext[$i];
            
            // Handle space
            if ($char === $this->space) {
                $plaintext .= ' ';
            }
            // Handle special characters (from uppercase map)
            elseif (isset($this->upperMapReverse[$char])) {
                $plaintext .= strtolower($this->upperMapReverse[$char]);
            }
            // Handle number mappings
            elseif (isset($this->numMapReverse[$char])) {
                $plaintext .= $this->numMapReverse[$char];
            }
            // Keep other characters as is
            else {
                $plaintext .= $char;
            }
        }
        
        return $plaintext;
    }
    
    /**
     * Get the cipher alphabet for reference
     */
    public function getCipherMap() {
        return [
            'uppercase' => $this->upperMap,
            'numbers' => $this->numMap,
            'space' => $this->space
        ];
    }
}
?>
