let slideIndex = 0;
showSlides();

function showSlides() {
    let i;
    let slides = document.getElementsByClassName("images");
    let dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) {
        slideIndex = 1;
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace("active", "");
    }
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
    setTimeout(showSlides, 4000);
}


// let fadeIndex = 0;
//   fadeSlides();

//   function fadeSlides() {
//     let slides = document.getElementsByClassName("fade");
//     for (let i = 0; i < slides.length; i++) {
//       slides[i].style.display = "none";
//     }
//     fadeIndex++;
//     if (fadeIndex > slides.length) {
//         fadeIndex = 1;
//     }
//     slides[fadeIndex - 1].style.display = "block";
//     setTimeout(fadeSlides, 4000); // Change image every 3 seconds (adjust as needed)
//   }