document.addEventListener("DOMContentLoaded", function () {
    // Tab Switching Logic
    const tabs = document.querySelectorAll(".tab-trigger");
    const sections = document.querySelectorAll(".config-section");

    if (tabs.length > 0) {
        tabs.forEach((tab) => {
            tab.addEventListener("click", () => {
                // Deactivate all tabs
                tabs.forEach((t) => t.classList.remove("active"));

                // Activate clicked tab
                tab.classList.add("active");

                // Hide all sections
                sections.forEach((section) =>
                    section.classList.remove("active")
                );

                // Show target section
                const targetId = tab.getAttribute("data-target");
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    targetSection.classList.add("active");
                }
            });
        });
    }

    // Toggle Interactions
    const toggles = document.querySelectorAll(".switch input");
    toggles.forEach((toggle) => {
        toggle.addEventListener("change", function () {
            // Visual feedback via Console or Toast
            const name = this.getAttribute("name");
            const status = this.checked ? "Activado" : "Desactivado";
            console.log(`Configuración [${name}]: ${status}`);

            // Simple Toast
            showToast(`Configuración actualizada`);
        });
    });

    function showToast(message) {
        // Create container if it doesn't exist
        let container = document.querySelector(".toast-container");
        if (!container) {
            container = document.createElement("div");
            container.className = "toast-container";
            container.style.cssText =
                "position: fixed; bottom: 20px; right: 20px; z-index: 9999;";
            document.body.appendChild(container);
        }

        const toast = document.createElement("div");
        toast.className = "config-toast";
        toast.innerHTML = `<i class="fas fa-check-circle" style="margin-right: 8px;"></i> ${message}`;
        toast.style.cssText = `
            background-color: #1f2937;
            color: #10b981;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            border: 1px solid #374151;
            display: flex;
            align-items: center;
            font-weight: 500;
            animation: slideIn 0.3s ease-out;
        `;

        container.appendChild(toast);

        // Remove
        setTimeout(() => {
            toast.style.opacity = "0";
            toast.style.transform = "translateX(20px)";
            toast.style.transition = "all 0.3s ease";
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
});

// Add animation keyframes via JS if needed, or rely on CSS
styleSheet = document.createElement("style");
styleSheet.innerText = `
@keyframes slideIn {
  from { opacity: 0; transform: translateX(20px); }
  to { opacity: 1; transform: translateX(0); }
}`;
document.head.appendChild(styleSheet);
