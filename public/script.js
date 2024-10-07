async function checkLoginStatus() {
    try {
        const response = await fetch('../constant/functions.php?user_info=true');
        const data = await response.json(); // This line must receive valid JSON

        if (data && data.username) {
            console.log('User is logged in');
            document.getElementById('basket').classList.remove('hidden');
            document.getElementById('profile').classList.remove('hidden');
            document.getElementById('signin').classList.add('hidden');
        } else {
            console.log('User is NOT logged in');
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
        const formData = new FormData();
        formData.append('logout', 'true'); // Trigger logout

        await fetch('../constant/functions.php', {
            method: 'POST',
            body: formData // Send form data instead of JSON
        });
        location.reload(); // Reload the page after logout
    } catch (error) {
        console.error('Error logging out:', error);
    }
}

// Check login status on page load
document.addEventListener('DOMContentLoaded', checkLoginStatus);
