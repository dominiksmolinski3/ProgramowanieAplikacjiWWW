// notifications.js
function showNotification(message, type = "info") {
    // Create the notification container
    const notification = document.createElement("div");
    notification.className = `notification ${type}`;
    notification.textContent = message;

    // Style the notification
    notification.style.position = "fixed";
    notification.style.bottom = "20px";
    notification.style.right = "20px";
    notification.style.backgroundColor = type === "error" ? "#f44336" : "#4CAF50";
    notification.style.color = "#fff";
    notification.style.padding = "10px 20px";
    notification.style.borderRadius = "5px";
    notification.style.boxShadow = "0px 4px 6px rgba(0, 0, 0, 0.1)";
    notification.style.zIndex = "1000";

    // Add to the document
    document.body.appendChild(notification);

    // Remove after 3 seconds
    setTimeout(() => {
        document.body.removeChild(notification);
    }, 3000);
}


// Function to show floating text for a specified time
function showFloatingTextForTime(textElement, displayTime) {
    // Show the floating text
    textElement.classList.add('show');
    
    // Hide the text after the specified time
    setTimeout(function () {
        textElement.classList.remove('show');
    }, displayTime);  // The text will be visible for displayTime (in ms)
}

// Initialize and show floating text after page load
document.addEventListener("DOMContentLoaded", function () {
    let floatingText = document.querySelector('.floating-text');

    // Show text for 5 seconds after page load
    showFloatingTextForTime(floatingText, 5000);

});
