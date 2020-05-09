// Execute when user clicks edit (device)
function editDevice() {
    // Enable strict mode
    "use strict";
    
    // Check if edit device form is displayed
    if (document.getElementById("change-device").style.display === "block") {
        // Hide edit device form
        document.getElementById("change-device").style.display = "none";
        // Display edit device settings button
        document.getElementById("set-submit").style.display = "block";
    } else {
        // Display edit device form
        document.getElementById("change-device").style.display = "block";
        // Clear edit device form
        document.getElementById("change-device").reset();
        // Hide edit device settings button
        document.getElementById("set-submit").style.display = "none";
    }
}

// Execute when user clicks edit (username)
function editUsername() {
    // Enable strict mode
    "use strict";
    
    // Check if edit username form is displayed
    if (document.getElementById("change-username").style.display === "block") {
        // Hide edit username form
        document.getElementById("change-username").style.display = "none";
        // Clear edit username form
        document.getElementById("change-username").reset();
    } else {
        // Display change username form
        document.getElementById("change-username").style.display = "block";
        // Hide edit email form
        document.getElementById("change-email").style.display = "none";
        // Clear edit email form
        document.getElementById("change-email").reset();
        // Hide edit password form
        document.getElementById("change-password").style.display = "none";
        // Clear edit password form
        document.getElementById("change-password").reset();
    }
}

// Execute when user clicks edit (email)
function editEmail() {
    // Enable strict mode
    "use strict";
    
    // Check if edit email form is displayed
    if (document.getElementById("change-email").style.display === "block") {
        // Hide edit email form
        document.getElementById("change-email").style.display = "none";
        // Clear edit email form
        document.getElementById("change-email").reset();
    } else {
        // Hide change username form
        document.getElementById("change-username").style.display = "none";
        // Clear edit username form
        document.getElementById("change-username").reset();
        // Display edit email form
        document.getElementById("change-email").style.display = "block";
        // Hide edit password form
        document.getElementById("change-password").style.display = "none";
        // Clear edit password form
        document.getElementById("change-password").reset();
    }
}

// Execute when user clicks edit (password)
function editPassword() {
    // Enable strict mode
    "use strict";
    
    // Check if edit password form is displayed
    if (document.getElementById("change-password").style.display === "block") {
        // Hide edit password form
        document.getElementById("change-password").style.display = "none";
        // Clear edit password form
        document.getElementById("change-password").reset();
    } else {
        // Hide edit username form
        document.getElementById("change-username").style.display = "none";
        // Clear edit username form
        document.getElementById("change-username").reset();
        // Hide edit email form
        document.getElementById("change-email").style.display = "none";
        // Clear edit email form
        document.getElementById("change-email").reset();
        // Display edit password form
        document.getElementById("change-password").style.display = "block";
    }
}