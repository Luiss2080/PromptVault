document.addEventListener("DOMContentLoaded", function () {
    // Prevent multiple initializations
    if (window.modalInitialized) return;
    window.modalInitialized = true;

    const modal = document.getElementById("deleteModal");
    const cancelBtn = document.getElementById("cancelDeleteBtn");
    const confirmBtn = document.getElementById("confirmDeleteBtn");
    const deleteForm = document.getElementById("deleteForm");

    if (!modal) {
        console.error("Modal deleteModal not found");
        return;
    }

    // Function to open modal
    window.openDeleteModal = function (actionUrl, itemName = "este elemento") {
        if (!modal) return;

        // Update form action
        deleteForm.action = actionUrl;

        // Update item name if placeholder exists
        const itemSpan = document.getElementById("deleteItemName");
        if (itemSpan) {
            itemSpan.textContent = itemName;
        }

        // Show modal
        console.log("Opening delete modal for:", actionUrl);
        modal.classList.add("active");
        document.body.style.overflow = "hidden"; // Prevent background scrolling
    };

    // Function to close modal
    window.closeDeleteModal = function () {
        if (!modal) return;
        modal.classList.remove("active");
        document.body.style.overflow = ""; // Restore scrolling
    };

    // Event Listeners
    if (cancelBtn) {
        // Remove existing listeners to be safe (though cloning is better, this is simple)
        const newCancelBtn = cancelBtn.cloneNode(true);
        cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
        newCancelBtn.addEventListener("click", window.closeDeleteModal);
    }

    // Close on click outside
    if (modal) {
        modal.addEventListener("click", function (e) {
            if (e.target === modal) {
                window.closeDeleteModal();
            }
        });
    }

    // Close on Escape key
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && modal.classList.contains("active")) {
            window.closeDeleteModal();
        }
    });
});
