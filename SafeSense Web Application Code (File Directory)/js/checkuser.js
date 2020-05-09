// Compares username field to username requirements
function validateUser() {
    // Enable strict mode
    "use strict";
    
    // Initialize document elements passed by ID and regular expression for blacklisted characters
    var userInput = document.getElementById("username"), userChars = document.getElementById("user-chars"), userLength = document.getElementById("user-length"), userBlackList = /[\s~`!@#$%\^&*()+={\[}\]\|\\:;"'<,>\.\?\/]/g;
    
    // Check for blacklisted characters
    if (userInput.value.match(userBlackList) || userInput.value.length === 0) {
        // Remove class attribute
        userChars.classList.remove("valid");
        // Add class attribute
        userChars.classList.add("invalid");
    } else {
        // Remove class attribute
        userChars.classList.remove("invalid");
        // Add class attribute
        userChars.classList.add("valid");
    }

    // Check for minimum 5 characters and maximum 15 characters
    if (userInput.value.length >= 5 && userInput.value.length <= 15) {
        // Remove class attribute
        userLength.classList.remove("invalid");
        // Add class attribute
        userLength.classList.add("valid");
    } else {
        // Remove class attribute
        userLength.classList.remove("valid");
        // Add class attribute
        userLength.classList.add("invalid");
    }
}

// Execute when user clicks inside username field
document.getElementById("username").onfocus = function () {
    // Enable strict mode
    "use strict";
    
    // Display username requirements
    document.getElementById("user-req").style.display = "block";
};

// Execute when user clicks outside username field
document.getElementById("username").onblur = function () {
    // Enable strict mode
    "use strict";
    
    // Hide username requirements
    document.getElementById("user-req").style.display = "none";
};

// Execute when user fills out username field
document.getElementById("username").onkeyup = function () {
    // Enable strict mode
    "use strict";
    
    // Call function
    validateUser();
};