/*
    This function gets the current value from the sliders in the search form
    on the 'Our Venues' page and feeds it back to php file so it can be displayed.
    This increases usability for the user in a drastic way.
*/ 

function updateSliderVal(){
    let sliders = document.getElementsByClassName("slider");
    let outputs = document.getElementsByClassName("slider-value");

    for(let i = 0; i < sliders.length; i++){
        outputs[i].innerHTML = sliders[i].value;
    }
}

/*
    This function checks whether the corresponding checkbox is true or false
    and disables/enables the slider. If the checkbox is ticked, the user 
    should not be able to use the slider.
*/

function toggleSlider(elementIndex){
    if (document.getElementsByClassName("slider-toggle")[elementIndex].checked == true){
        document.getElementsByClassName("slider")[elementIndex].disabled = true;
    }
    else{
        document.getElementsByClassName("slider")[elementIndex].disabled = false;
    }
}

/*
    These functions are used to prevent the user from selecting a maximum value lower than the minimum
    or vice versa. This is validation. 
*/

function setSliderBounds(className, sliderNo){
    let sliders = document.getElementsByClassName(className);
    let minValue = sliders[0].value;
    let maxValue = sliders[1].value;

    // If maxValue lower than minValue set maxValue to equal minValue
    if (maxValue < minValue){
        if (sliderNo == 0){
            document.getElementsByClassName(className)[1].value = minValue + 5;
        }
        else if (sliderNo == 1){
            document.getElementsByClassName(className)[0].value = maxValue - 5;
        }
    }
}
