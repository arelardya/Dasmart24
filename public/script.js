function submitForm() {
    const dummyUsername = 'user123';
    const dummyPassword = 'password123';

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username === dummyUsername && password === dummyPassword) {
        window.location.href = './market.html';
    } else {
        document.getElementById('message').classList.remove('hidden');
    }
}

function adminSubmitForm() {
    const adminUsername = 'admin123';
    const adminPassword = 'password123';

    const usernameA = document.getElementById('adminUsername').value;
    const passwordA = document.getElementById('adminPassword').value;

    if (usernameA === adminUsername && passwordA === adminPassword) {
        window.location.href = './menuAdmin.html';
    } else {
        document.getElementById('message').classList.remove('hidden');
    }
}

function changeImage(x) {
    let image = document.getElementById("nextButton");

    if (x==1) {
        image.src = "./assets/nextButton2.png";
    } if (x==2) {
        image.src = "./assets/nextButton.png";
    }
}