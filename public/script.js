// Function to check login status
async function checkLoginStatus() {
    try {
        const response = await fetch('functions.php?check_login=true'); // Use functions.php for checking login status
        const data = await response.json();

        // Update UI based on login status
        if (data.isLoggedIn) {
            // User is logged in
            document.getElementById('basket').classList.remove('hidden');
            document.getElementById('profile').classList.remove('hidden');
            document.getElementById('signin').classList.add('hidden');
        } else {
            // User is not logged in
            document.getElementById('basket').classList.add('hidden');
            document.getElementById('signin').classList.remove('hidden');
            document.getElementById('profile').classList.add('hidden');
        }
    } catch (error) {
        console.error('Error checking login status:', error);
    }
}

// Check login status on page load
document.addEventListener('DOMContentLoaded', checkLoginStatus);
