document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("warningModal");
    const closeBtn = document.getElementById("closeWarningBtn");

    if (!modal) return;

    // Function to open modal
    window.openWarningModal = function (title, message) {
        if (title) document.getElementById("warningTitle").textContent = title;
        if (message)
            document.getElementById("warningMessage").textContent = message;

        modal.classList.add("active");
        document.body.style.overflow = "hidden";
    };

    // Function to close modal
    window.closeWarningModal = function () {
        modal.classList.remove("active");
        document.body.style.overflow = "";
    };

    // Event Listeners
    if (closeBtn) {
        closeBtn.addEventListener("click", window.closeWarningModal);
    }

    // Close on click outside
    modal.addEventListener("click", function (e) {
        if (e.target === modal) {
            window.closeWarningModal();
        }
    });

    // Close on Escape key
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && modal.classList.contains("active")) {
            window.closeWarningModal();
        }
    });
});
