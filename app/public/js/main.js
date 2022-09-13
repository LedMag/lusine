'use strict';


const dropdownBox = document.getElementById('langs');
const dropdownElems = document.querySelectorAll('.header__lang');
const buttons = document.querySelectorAll('.slider__delete');
const url = 'localhost';
const token = document.querySelector("meta[name='csrf-token']").getAttribute("content");
const langs = document.getElementById('langs');
const imageShow = document.getElementById('imageShow');
const imageInput = document.getElementById('inputImage');
const sliderForm = document.querySelector('.slider__form');
const sliderImage = document.querySelector('.slider__image');

$('#slider').nivoSlider ({ 
    //effect: 'random',
    slices: 20,
    boxCols: 8,
    boxRows: 4,
    animSpeed: 400,
    pauseTime: 5000,
    startSlide: 0,
    directionNav:false,
    controlNav: true,
    controlNavThumbs: false,
    pauseOnHover: true,
    manualAdvance: false,
    prevText: 'Prev',
    nextText: 'Next',
    randomStart: false,
});

// options od nivo-slider
/*
effect: 'random', // Transition effect between images (see below)
slices: 15, // For slice animations
boxCols: 8, // For box animations
boxRows: 4, // For box animations
animSpeed: 500, // Slide transition speed
pauseTime: 3000, // How long each slide will show
startSlide: 0, // Set starting Slide (0 index)
directionNav: true, // Next & Prev navigation
controlNav: true, // 1,2,3... navigation
controlNavThumbs: false, // Use thumbnails for Control Nav
pauseOnHover: true, // Stop animation while hovering
manualAdvance: false, // Force manual transitions
prevText: 'Prev', // Prev directionNav text
nextText: 'Next', // Next directionNav text
randomStart: false, // Start on a random slide
beforeChange: function(){}, // Triggers before a slide transition
afterChange: function(){}, // Triggers after a slide transition
slideshowEnd: function(){}, // Triggers after all slides have been shown
lastSlide: function(){}, // Triggers when last slide is shown
afterLoad: function(){} // Triggers when slider has loaded
*/

// buttons.forEach( btn => {
//     btn.addEventListener('click', (e) => {
//         const fileName = e.target.dataset.name;
//         fetch(`admin/deleteSlide/${fileName}`, {
//             headers: {
//                 'X-CSRF-TOKEN': token
//             }
//         });
//         // window.location.href=`/home`;
//     })
// })

langs.addEventListener('change', (e) => {
    const url = window.location.host;
    console.log(url, e)
    // window.location.href = url + "?lang="+ $(this).val();
})

if(imageInput){
    imageInput.onchange = (event) => {
        console.log('Work', event)
        imageShow.src = URL.createObjectURL(event.target.files[0]);
    }
}

if(sliderImage){
    sliderForm.onchange = (event) => {
        sliderForm.style.backgroundImage = `url('${URL.createObjectURL(event.target.files[0])}')`;
    }
}



dropdownBox.addEventListener('click', (e) => {
    if(dropdownBox.classList.contains('open')){
        return;
    }
    e.stopPropagation();
    dropdownBox.classList.add('open');
    dropdownElems.forEach( elem => {
        elem.style.display = "block"
        elem.removeEventListener('click', stop);
    })
})

dropdownElems.forEach( elem => {
    elem.addEventListener('click', stop)
})

function stop (e){
    e.preventDefault()
}
