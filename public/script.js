// Function to handle form submission
function submitForm(event) {
    event.preventDefault(); // Prevent the default form submission behavior
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const message = document.getElementById('message');

    // Dummy credentials for example purposes
    const validUsername = 'user123';
    const validPassword = 'pass123';

    if (username === validUsername && password === validPassword) {
        // Simulate successful login
        localStorage.setItem('isLoggedIn', 'true');
        message.classList.add('hidden');
        window.location.href = './market.html'; // Redirect to homepage or another page
    } else {
        // Show error message
        message.classList.remove('hidden');
    }
}

//Check Status
function checkLoginStatus() {
    const isLoggedIn = localStorage.getItem('isLoggedIn');

    if (isLoggedIn === 'true') {
        document.getElementById('basket').classList.remove('hidden');
        document.getElementById('profile').classList.remove('hidden');
        document.getElementById('signin').classList.add('hidden');
    } else {
        document.getElementById('basket').classList.add('hidden');
        document.getElementById('signin').classList.remove('hidden');
        document.getElementById('profile').classList.add('hidden');
    }
}

//Login
function login() {
    localStorage.setItem('isLoggedIn', 'true');
    checkLoginStatus();
}

//Logout
function logout() {
    localStorage.removeItem('isLoggedIn');
    checkLoginStatus();
    window.location.href = './index.html';
}

// Execute when the document is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    checkLoginStatus();
});

function changeImage(state) {
    const nextButton = document.getElementById('nextButton');
    if (state === 1) {
        nextButton.src = '/public/assets/nextButton2.png';
    } else {
        nextButton.src = '/public/assets/nextButton.png';
    }
}
