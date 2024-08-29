function submitForm() {
    const dummyUsername = 'user123';
    const dummyPassword = 'password123';

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username === dummyUsername && password === dummyPassword) {
        window.location.href = './market.html'; // Replace with the URL of the page you want to redirect to
    } else {
        document.getElementById('message').classList.remove('hidden');
    }
}

function changeImage(x) {
    let image = document.getElementById("nextButton");

    if (x==1) {
        image.src = "./assets/button/nextButton2.png";
    } if (x==2) {
        image.src = "./assets/button/nextButton.png";
    }
}