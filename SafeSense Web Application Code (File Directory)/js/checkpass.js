// Compares password field to password requirements
function validatePass() {
    // Enable strict mode
    "use strict";
    
    // Initialize document elements passed by ID and regular expressions for whitelisted characters
    var passInput = document.getElementById("password"), passLower = document.getElementById("pass-lower"), passUpper = document.getElementById("pass-upper"), passNumber = document.getElementById("pass-number"), passMinLength = document.getElementById("pass-minlength"), lowerCaseLetters = /[a-z]/g, upperCaseLetters = /[A-Z]/g, numbers = /[0-9]/g;

    // Check for at least 1 lowercase letter
    if (passInput.value.match(lowerCaseLetters)) {
        // Remove class attribute
        passLower.classList.remove("invalid");
        // Add class attribute
        passLower.classList.add("valid");
    } else {
        // Remove class attribute
        passLower.classList.remove("valid");
        // Add class attribute
        passLower.classList.add("invalid");
    }

    // Check for at least 1 uppercase letter
    if (passInput.value.match(upperCaseLetters)) {
        // Remove class attribute
        passUpper.classList.remove("invalid");
        // Add class attribute
        passUpper.classList.add("valid");
    } else {
        // Remove class attribute
        passUpper.classList.remove("valid");
        // Add class attribute
        passUpper.classList.add("invalid");
    }

    // Check for at least 1 digit
    if (passInput.value.match(numbers)) {
        // Remove class attribute
        passNumber.classList.remove("invalid");
        // Add class attribute
        passNumber.classList.add("valid");
    } else {
        // Remove class attribute
        passNumber.classList.remove("valid");
        // Add class attribute
        passNumber.classList.add("invalid");
    }

    // Check for minimum 8 characters
    if (passInput.value.length >= 8) {
        // Remove class attribute
        passMinLength.classList.remove("invalid");
        // Add class attribute
        passMinLength.classList.add("valid");
    } else {
        // Remove class attribute
        passMinLength.classList.remove("valid");
        // Add class attribute
        passMinLength.classList.add("invalid");
    }
}

// Execute when user clicks inside password field
document.getElementById("password").onfocus = function () {
    // Enable strict mode
    "use strict";
    
    // Display password requirements
    document.getElementById("pass-req").style.display = "block";
};

// Execute when user clicks outside password field
document.getElementById("password").onblur = function () {
    // Enable strict mode
    "use strict";
    
    // Hide password requirements
    document.getElementById("pass-req").style.display = "none";
};

// Exectute when user fills out password field
document.getElementById("password").onkeyup = function () {
    // Enable strict mode
    "use strict";
    
    // Call function
    validatePass();
};