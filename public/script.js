function changeImage(x) {
    let image = document.getElementById("nextButton");

    if (x==1) {
        image.src = "./assets/nextButton2.png";
    } if (x==2) {
        image.src = "./assets/nextButton.png";
    }
}