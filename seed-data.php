<?php
/**
 * Sample Data Seeder
 * Adds more sample properties to the database for testing
 */

require_once 'includes/config.php';
require_once 'includes/Database.php';
require_once 'includes/Cipher.php';

$db = new Database();
$db->connect();
$conn = $db->getConnection();
$cipher = new Cipher();

// Sample properties data
$properties = [
    [
        'agent_id' => 1,
        'title' => 'Luxury Beachfront Mansion',
        'description' => 'Stunning beachfront property with private beach access. Modern architecture with floor-to-ceiling windows overlooking the ocean. Perfect for someone who appreciates luxury living.',
        'price' => 2500000,
        'location' => 'Miami Beach, FL',
        'bedrooms' => 5,
        'bathrooms' => 4,
        'area_sqft' => 5500,
        'property_type' => 'house'
    ],
    [
        'agent_id' => 2,
        'title' => 'Urban Downtown Penthouse',
        'description' => 'Spectacular penthouse apartment in the heart of downtown. City skyline views from every room. Premium finishes and smart home automation throughout.',
        'price' => 1800000,
        'location' => 'New York, NY',
        'bedrooms' => 3,
        'bathrooms' => 3,
        'area_sqft' => 3200,
        'property_type' => 'apartment'
    ],
    [
        'agent_id' => 1,
        'title' => 'Modern Suburban Family Home',
        'description' => 'Beautiful 4-bedroom home in quiet residential neighborhood. Updated kitchen, spacious backyard. Perfect for families. Great schools nearby.',
        'price' => 750000,
        'location' => 'Austin, TX',
        'bedrooms' => 4,
        'bathrooms' => 2.5,
        'area_sqft' => 3000,
        'property_type' => 'house'
    ],
    [
        'agent_id' => 2,
        'title' => 'Commercial Office Space',
        'description' => 'Prime commercial real estate in business district. Modern building with parking. Recently renovated. Excellent for corporate offices or startups.',
        'price' => 5000000,
        'location' => 'San Francisco, CA',
        'bedrooms' => 0,
        'bathrooms' => 15,
        'area_sqft' => 15000,
        'property_type' => 'commercial'
    ],
    [
        'agent_id' => 1,
        'title' => 'Cozy Mountain Cottage',
        'description' => 'Charming cottage nestled in the mountains. Stone fireplace, natural wood throughout. Privacy and nature at your doorstep. Perfect getaway property.',
        'price' => 450000,
        'location' => 'Denver, CO',
        'bedrooms' => 2,
        'bathrooms' => 1.5,
        'area_sqft' => 1600,
        'property_type' => 'house'
    ],
    [
        'agent_id' => 2,
        'title' => 'Vacant Land Development Opportunity',
        'description' => 'Large plot of undeveloped land perfect for development. Zoned for residential or commercial. Close to growing area with good infrastructure.',
        'price' => 800000,
        'location' => 'Phoenix, AZ',
        'bedrooms' => 0,
        'bathrooms' => 0,
        'area_sqft' => 45000,
        'property_type' => 'land'
    ],
    [
        'agent_id' => 1,
        'title' => 'Victorian Historic Property',
        'description' => 'Restored Victorian mansion with original details. High ceilings, ornate moldings, stained glass windows. Located in prestigious historic district.',
        'price' => 1200000,
        'location' => 'Boston, MA',
        'bedrooms' => 5,
        'bathrooms' => 3,
        'area_sqft' => 4200,
        'property_type' => 'house'
    ],
    [
        'agent_id' => 2,
        'title' => 'Contemporary Loft Apartment',
        'description' => 'Trendy loft in converted warehouse. Industrial chic design with exposed brick and concrete. Open floor plan with high ceilings.',
        'price' => 650000,
        'location' => 'Chicago, IL',
        'bedrooms' => 2,
        'bathrooms' => 2,
        'area_sqft' => 2200,
        'property_type' => 'apartment'
    ]
];

// Insert properties
$inserted = 0;
$failed = 0;

foreach ($properties as $prop) {
    $query = "INSERT INTO properties 
             (agent_id, title, description, price, location, bedrooms, bathrooms, area_sqft, property_type) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    
    $stmt->bind_param(
        'issdsiiis',
        $prop['agent_id'],
        $prop['title'],
        $prop['description'],
        $prop['price'],
        $prop['location'],
        $prop['bedrooms'],
        $prop['bathrooms'],
        $prop['area_sqft'],
        $prop['property_type']
    );
    
    if ($stmt->execute()) {
        $inserted++;
    } else {
        $failed++;
        echo "Error inserting: " . $prop['title'] . " - " . $stmt->error . "\n";
    }
}

echo "✓ Successfully inserted $inserted properties\n";
if ($failed > 0) {
    echo "✗ Failed to insert $failed properties\n";
}

// Verify insertion
$result = $conn->query("SELECT COUNT(*) as total FROM properties");
$row = $result->fetch_assoc();
echo "\nTotal properties in database: " . $row['total'] . "\n";

?>
