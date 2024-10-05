async function checkLoginStatus() {
    try {
        const response = await fetch('functions.php?user_info=true'); // Fetch user info
        const data = await response.json();

        // Update UI based on login status
        if (data && data.username) {
            document.getElementById('basket').classList.remove('hidden');
            document.getElementById('profile').classList.remove('hidden');
            document.getElementById('signin').classList.add('hidden');
            showUserInfo(data); // Show user info if logged in
        } else {
            document.getElementById('basket').classList.add('hidden');
            document.getElementById('signin').classList.remove('hidden');
            document.getElementById('profile').classList.add('hidden');
        }
    } catch (error) {
        console.error('Error checking login status:', error);
    }
}

// Function to show user information
function showUserInfo(userInfo) {
    if (userInfo) {
        document.getElementById('username').textContent = userInfo.username; // Update username
        document.getElementById('email').textContent = userInfo.email; // Update email
    }
}

// Logout function
async function logout() {
    try {
        await fetch('functions.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ logout: true }) // Trigger logout
        });
        location.reload(); // Reload the page after logout
    } catch (error) {
        console.error('Error logging out:', error);
    }
}

// Check login status on page load
document.addEventListener('DOMContentLoaded', checkLoginStatus);
