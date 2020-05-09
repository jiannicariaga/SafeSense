// Display initial value of slider
document.getElementById("range-value").innerHTML = document.getElementById("range-input").value;

// Updates value of slider to reflect user input
function updateSlider() {
    // Enable strict mode
    "use strict";
    
    // Display updated value of slider
    document.getElementById("range-value").innerHTML = document.getElementById("range-input").value;
}

// Execute when user clicks on slider
document.getElementById("range-input").oninput = function () {
    // Enable strict mode
    "use strict";
    
    // Call function
    updateSlider();
};