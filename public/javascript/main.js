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
function openModal(){
    modal.style.display = 'block';
}
// function to close modal
function closeModal(){
    modal.style.display = 'none';
}
// function to close outside
function closeOutside(e){
    if(e.target == modal){
        modal.style.display = 'none';
    }
}

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
