/**
 * Dashboard JavaScript
 * Handles dashboard interactions and property management
 */

// Add to Favorites
function toggleFavorite(propertyId, button) {
    fetch('api/properties.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'toggle_favorite',
            property_id: propertyId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            button.classList.toggle('active');
            const isFavorite = button.classList.contains('active');
            button.textContent = isFavorite ? '❤️ Favorited' : '🤍 Favorite';
        }
    })
    .catch(error => console.error('Error:', error));
}

// View Property Details
function viewProperty(propertyId) {
    window.location.href = `property.php?id=${propertyId}`;
}

// Load Properties
function loadProperties(filter = 'all') {
    const grid = document.querySelector('.properties-grid');
    if (!grid) return;
    
    grid.innerHTML = '<div class="loading"></div>';
    
    fetch(`api/properties.php?action=list&filter=${filter}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderProperties(data.properties, grid);
            } else {
                grid.innerHTML = '<p>' + data.message + '</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            grid.innerHTML = '<p>Error loading properties</p>';
        });
}

// Real estate image URLs from free sources
const houseImages = [
    'https://images.unsplash.com/photo-1570129477492-45a003537e1d?w=400&h=300&fit=crop',
    'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=400&h=300&fit=crop',
    'https://images.unsplash.com/photo-1512917774080-9b274b5ce486?w=400&h=300&fit=crop',
    'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=400&h=300&fit=crop',
    'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=400&h=300&fit=crop',
    'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=300&fit=crop'
];

// Get image URL based on property ID
function getHouseImage(propertyId) {
    return houseImages[(propertyId - 1) % houseImages.length];
}

// Render Properties
function renderProperties(properties, container) {
    container.innerHTML = '';
    
    if (properties.length === 0) {
        container.innerHTML = '<p>No properties found</p>';
        return;
    }
    
    properties.forEach(property => {
        const card = document.createElement('div');
        card.className = 'property-card';
        const imageUrl = getHouseImage(property.id);
        card.innerHTML = `
            <div class="property-image">
                <img src="${imageUrl}" alt="${property.title}" onerror="this.style.display='none'">
            </div>
            <div class="property-info">
                <h3 class="property-title">${property.title}</h3>
                <p class="property-price">$${parseFloat(property.price).toLocaleString()}</p>
                <div class="property-details">
                    <div class="property-detail-item">
                        <span>🛏️ ${property.bedrooms} Beds</span>
                    </div>
                    <div class="property-detail-item">
                        <span>🚿 ${property.bathrooms} Baths</span>
                    </div>
                </div>
                <div class="property-actions">
                    <button class="btn-small" onclick="viewProperty(${property.id})">View</button>
                    <button class="btn-small" onclick="toggleFavorite(${property.id}, this)">🤍 Favorite</button>
                </div>
            </div>
        `;
        container.appendChild(card);
    });
}

// Update Profile
function updateProfile(e) {
    e.preventDefault();
    
    const fullName = document.getElementById('fullName').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    
    if (!fullName || !email) {
        showAlert('Please fill in all required fields', 'warning');
        return;
    }
    
    const button = document.querySelector('button[type="submit"]');
    button.disabled = true;
    button.innerHTML = '<span class="loading"></span> Updating...';
    
    fetch('api/user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'update_profile',
            full_name: fullName,
            email: email,
            phone: phone
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
        } else {
            showAlert(data.message, 'error');
        }
        button.disabled = false;
        button.innerHTML = 'Update Profile';
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('An error occurred', 'error');
        button.disabled = false;
        button.innerHTML = 'Update Profile';
    });
}

// Load on page load
document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', updateProfile);
    }
});
