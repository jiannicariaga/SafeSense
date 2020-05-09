// Compares device location field to device location requirements
function validateLocation() {
    // Enable strict mode
    "use strict";
    
    // Initialize document elements passed by ID and regular expression for blacklisted characters
    var locationInput = document.getElementById("location"), locationChars = document.getElementById("location-chars"), locationLength = document.getElementById("location-length"), userBlackList = /[~`!@#$%\^&*()+={\[}\]\|\\:;"<,>\.\?\/]/g;
    
    // Check for blacklisted characters
    if (locationInput.value.match(userBlackList) || locationInput.value.length === 0) {
        // Remove class attribute
        locationChars.classList.remove("valid");
        // Add class attribute
        locationChars.classList.add("invalid");
    } else {
        // Remove class attribute
        locationChars.classList.remove("invalid");
        // Add class attribute
        locationChars.classList.add("valid");
    }

    // Check for minimum 1 character and maximum 10 characters
    if (locationInput.value.length >= 1 && locationInput.value.length <= 10) {
        // Remove class attribute
        locationLength.classList.remove("invalid");
        // Add class attribute
        locationLength.classList.add("valid");
    } else {
        // Remove class attribute
        locationLength.classList.remove("valid");
        // Add class attribute
        locationLength.classList.add("invalid");
    }
}

// Execute when user clicks inside device location field
document.getElementById("location").onfocus = function () {
    // Enable strict mode
    "use strict";
    
    // Display device location requirements
    document.getElementById("location-req").style.display = "block";
};

// Execute when user clicks outside device location field
document.getElementById("location").onblur = function () {
    // Enable strict mode
    "use strict";
    
    // Hide device location requirements
    document.getElementById("location-req").style.display = "none";
};

// Execute when user fills out device location field
document.getElementById("location").onkeyup = function () {
    // Enable strict mode
    "use strict";
    
    // Call function
    validateLocation();
};