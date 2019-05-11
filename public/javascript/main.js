// get modal element
var modal = document.getElementById('myModal');
// get open modal button
var modalBtn = document.getElementById('modalBtn');
// get close button
var closeBtn = document.getElementsByClassName('closeBtn')[0];

// listen for open click 
modalBtn.addEventListener('click', openModal);
// listen for close click
closeBtn.addEventListener('click', closeModal);
// listen for outside click
window.addEventListener('click', closeOutside);

// function to open modal
function openModal(){ modal.style.display = 'block'; }
// function to close modal
function closeModal(){ modal.style.display = 'none'; }
// function to close outside
function closeOutside(e){ if(e.target == modal){ modal.style.display = 'none'; }}


// sign in modal
var modal1 = document.getElementById('signinModal');
var btn1 = document.getElementById("signinModalBtn");

btn1.addEventListener('click', function(){
  modal1.style.display = "block";}, false);

window.onclick = function (event) {
    if(event.target == modal1){
      modal1.style.display = "none";
    }
}

// var signModal = document.getElementById('signModal');
// var signModalBtn = document.getElementById('signModalBtn');
// var signCloseBtn = document.getElementsByClassName('signCloseBtn')[0];

// signModalBtn.addEventListener('click', openModal);
// signCloseBtn.addEventListener('click', closeModal);
// window.addEventListener('click', closeOutside);

// function openModal(){ signModal.style.display = 'block'; }
// function closeModal(){ signModal.style.display = 'none'; }
// function closeOutside(e){ if(e.target == signModal){ signModal.style.display = 'none'; }}


// slider
let sliderImages = document.querySelectorAll('.slide'),
    arrowLeft    = document.querySelector('#arrow-left'),
    arrowRight   = document.querySelector('#arrow-right'),
    current      = 0;

// clear all images
function reset(){
    for(let i = 0; i < sliderImages.length; i++){
        sliderImages[i].style.display = 'none';
    }
}

// initialize slider
function startSlide(){
    reset();
    sliderImages[0].style.display = 'block';
}

// show previous
function slideLeft(){
    reset(); //wipe slide clean
    sliderImages[current - 1].style.display = 'block';
    current--;
}

// show next
function slideRight(){
    reset();
    sliderImages[current + 1].style.display = 'block';
    current++;
}

// left arrow click
arrowLeft.addEventListener('click', function(){
    if(current === 0){
        current = sliderImages.length; //here is 3
    }
    slideLeft(); //here goes to 3-1, index[2], last img;
});

// right arrow click
arrowRight.addEventListener('click', function(){
    if(current === sliderImages.length - 1){ //3-1=2, index[2], last img
        current = -1;
    }
    slideRight(); //here goes to -1+1, index[0], first img 
});

startSlide();


// search bar to filter bottom categories
let filterInput = document.getElementById('filterInput');
filterInput.addEventListener('keyup', filterNames);

function filterNames(){
    // get value of input
    let filterValue = document.getElementById('filterInput').value.toUpperCase();

    // get filter items
    let filter = document.getElementById('filter');
    let item = filter.querySelectorAll('.filter-item');

    // loop through all items
    for(let i = 0; i < item.length; i++){
        let a = item[i].getElementsByTagName('a')[0];
        // if matched
        if(a.innerHTML.toUpperCase().indexOf(filterValue) > -1){
            item[i].style.display = '';
        } else {
            item[i].style.display = 'none';
        }
    }
}
      

// navbar dropdown toggle
$(document).ready(function() {
    $(".toggle").on("click", function(){
    $("nav ul").toggleClass("showing");
    });
});

// nav link, smooth scrolling
$(function() {
    $('a[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        if (target.length) {
            $('html, body').animate({
            scrollTop: target.offset().top
            }, 1000);
            return false;
        }
        }
    });
});


// js animation plugin
window.sr = ScrollReveal();
sr.reveal('.navbar', {
    duration: 2000,
    delay: 500,
    origin: 'bottom'
});
sr.reveal('.showcase-left', {
    duration: 2000,
    origin: 'top',
    distance: '300px'
});
sr.reveal('.showcase-right', {
    duration: 2000,
    origin: 'right',
    distance: '300px'
});
sr.reveal('.btn', {
    duration: 3000,
    delay: 1000,
    origin: 'bottom'
});
sr.reveal('.info-left', {
    duration: 2000,
    origin: 'left',
    distance: '300px',
    viewFactor: 0.2
});
sr.reveal('.info-right', {
    duration: 2000,
    origin: 'right',
    distance: '300px',
    viewFactor: 0.2
});
sr.reveal('.portfolio', {
    duration: 4000,
    delay: 500,
    origin: 'bottom',
    viewFactor: 0.3
});
sr.reveal('.footer', {
    duration: 4000,
    delay: 500,
    origin: 'bottom',
    viewFactor: 0.3
});