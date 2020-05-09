// Compares password and confirm password fields
function comparePass() {
    // Enable strict mode
    "use strict";
    
    // Initialize document elements passed by ID
    var confirmPassInput = document.getElementById("password-confirm"), passInput = document.getElementById("password"), matchTrue = document.getElementById("match-true"), matchFalse = document.getElementById("match-false");
    
    // Check if password fields match
    if (confirmPassInput.value === passInput.value) {
        // Hide document element
        matchFalse.style.display = "none";
        // Display document element
        matchTrue.style.display = "block";
    } else {
        // Hide document element
        matchTrue.style.display = "none";
        // Display document element
        matchFalse.style.display = "block";
    }
}

// Execute when user clicks inside confirm password field
document.getElementById("password-confirm").onfocus = function () {
    // Enable strict mode
    "use strict";
    
    // Display password match status
    document.getElementById("pass-match").style.display = "block";
    
    // Compare passwords
    comparePass();
};

// Execute when user clicks outside confirm password field
document.getElementById("password-confirm").onblur = function () {
    // Enable strict mode
    "use strict";
    
    // Hide password match status
    document.getElementById("pass-match").style.display = "none";
};

// Execute when user fills out confirm password field
document.getElementById("password-confirm").onkeyup = function () {
    // Enable strict mode
    "use strict";
    
    // Call function
    comparePass();
};