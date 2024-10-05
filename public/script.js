
// Check Status
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

// Login
function login() {
    localStorage.setItem('isLoggedIn', 'true');
    checkLoginStatus();
}

// Logout
function logout() {
    localStorage.removeItem('isLoggedIn');
    checkLoginStatus();
    window.location.href = './index.html';
}

//check login status
document.addEventListener('DOMContentLoaded', function() {
    checkLoginStatus();
});

//button change
function changeImage(state) {
    const nextButton = document.getElementById('nextButton');
    if (state === 1) {
        nextButton.src = './assets/nextButton2.png'; 
    } else {
        nextButton.src = './assets/nextButton.png'; 
    }
}

//burger
document.addEventListener('DOMContentLoaded', () => {
    const burgerMenuButton = document.getElementById('burgerMenuButton');
    const navLinks = document.getElementById('navLinks');

    burgerMenuButton.addEventListener('click', () => {
        navLinks.classList.toggle('hidden');
    });
});