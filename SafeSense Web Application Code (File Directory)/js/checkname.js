// Compares device name field to device name requirements
function validateName() {
    // Enable strict mode
    "use strict";
    
    // Initialize document elements passed by ID and regular expression for blacklisted characters
    var nameInput = document.getElementById("name"), nameChars = document.getElementById("name-chars"), nameLength = document.getElementById("name-length"), userBlackList = /[~`!@#$%\^&*()+={\[}\]\|\\:;"<,>\.\?\/]/g;
    
    // Check for blacklisted characters
    if (nameInput.value.match(userBlackList) || nameInput.value.length === 0) {
        // Remove class attribute
        nameChars.classList.remove("valid");
        // Add class attribute
        nameChars.classList.add("invalid");
    } else {
        // Remove class attribute
        nameChars.classList.remove("invalid");
        // Add class attribute
        nameChars.classList.add("valid");
    }

    // Check for minimum 1 character and maximum 10 characters
    if (nameInput.value.length >= 1 && nameInput.value.length <= 10) {
        // Remove class attribute
        nameLength.classList.remove("invalid");
        // Add class attribute
        nameLength.classList.add("valid");
    } else {
        // Remove class attribute
        nameLength.classList.remove("valid");
        // Add class attribute
        nameLength.classList.add("invalid");
    }
}

// Execute when user clicks inside device name field
document.getElementById("name").onfocus = function () {
    // Enable strict mode
    "use strict";
    
    // Display device name requirements
    document.getElementById("name-req").style.display = "block";
};

// Execute when user clicks outside device name field
document.getElementById("name").onblur = function () {
    // Enable strict mode
    "use strict";
    
    // Hide device name requirements
    document.getElementById("name-req").style.display = "none";
};

// Execute when user fills out device name field
document.getElementById("name").onkeyup = function () {
    // Enable strict mode
    "use strict";
    
    // Call function
    validateName();
};