'use strict';


const dropdownBox = document.getElementById('langs');
const dropdownElems = document.querySelectorAll('.header__lang');


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
