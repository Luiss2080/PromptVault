document.addEventListener("DOMContentLoaded", function () {
    const overlay = document.getElementById("loadingOverlay");
    const progressBar = document.getElementById("loadingProgressBar");
    const percentageText = document.getElementById("loadingPercentage");
    const statusText = document.getElementById("loadingStatus");
    const systemLog = document.getElementById("systemLog");

    if (!overlay) return;

    let progress = 0;
    let loadingInterval = null;
    let messageInterval = null;
    let logInterval = null;

    // Simulation Config
    const duration = 5000;
    const interval = 30;
    const steps = duration / interval;
    const increment = 100 / steps;

    const messages = [
        "Inicializando núcleo del sistema...",
        "Cargando módulos de seguridad...",
        "Verificando integridad de datos...",
        "Optimizando recursos gráficos...",
        "Estableciendo conexión segura...",
    ];

    const techLogs = [
        "> mounting /sys/kernel/security...",
        "> checking auth_tokens...",
        "> loading assets [css, js, imgs]...",
        "> verifying db_connection pool...",
        "> optimizing render_engine...",
        "> syncing user_profile_data...",
        "> cleaning memory buffers...",
        "> starting main_thread...",
        "> checking version 2.1.0 update...",
        "> initializing dashboard_view...",
        "> system ready.",
    ];

    // Initialize
    startSimulation();

    // --- Global Navigation Handlers ---
    document.addEventListener("click", function (e) {
        const link = e.target.closest("a");
        if (link) {
            const href = link.getAttribute("href");
            const target = link.getAttribute("target");
            if (
                href &&
                !href.startsWith("#") &&
                !href.startsWith("javascript:") &&
                target !== "_blank" &&
                !e.ctrlKey &&
                !e.metaKey &&
                !link.dataset.noLoader
            ) {
                showLoader();
            }
        }
    });

    document.addEventListener("submit", function (e) {
        if (!e.target.dataset.noLoader) showLoader();
    });

    window.addEventListener("pageshow", function (event) {
        if (event.persisted) hideLoaderInstant();
    });

    // --- Loader Functions ---

    function showLoader() {
        if (overlay.classList.contains("hidden")) {
            overlay.style.display = "flex";
            void overlay.offsetWidth;
            overlay.classList.remove("hidden");
            resetLoader();
            startSimulation();
        }
    }

    function resetLoader() {
        progress = 0;
        progressBar.style.width = "0%";
        percentageText.textContent = "0%";
        statusText.textContent = "Cargando...";
        statusText.style.opacity = "1";
        if (systemLog)
            systemLog.innerHTML =
                '<span class="log-line">> Iniciando kernel...</span>';
    }

    function startSimulation() {
        if (loadingInterval) clearInterval(loadingInterval);
        if (messageInterval) clearInterval(messageInterval);
        if (logInterval) clearInterval(logInterval);

        let messageIndex = 0;
        let logIndex = 0;

        // Status Text Cycler
        messageInterval = setInterval(() => {
            messageIndex = (messageIndex + 1) % messages.length;
            statusText.style.opacity = "0";
            setTimeout(() => {
                statusText.textContent = messages[messageIndex];
                statusText.style.opacity = "1";
            }, 200);
        }, 800);

        // System Log Cycler
        if (systemLog) {
            logInterval = setInterval(() => {
                if (logIndex < techLogs.length) {
                    const line = document.createElement("span");
                    line.className = "log-line";
                    line.textContent = techLogs[logIndex];
                    systemLog.appendChild(line);

                    // Keep only last 3 lines
                    while (systemLog.children.length > 3) {
                        systemLog.removeChild(systemLog.firstChild);
                    }

                    logIndex++;
                }
            }, 400); // Fast tech scrolling
        }

        // Progress Bar
        loadingInterval = setInterval(() => {
            const randomIncrement = increment * (0.5 + Math.random());
            progress += randomIncrement;

            if (progress >= 100) {
                progress = 100;
                clearInterval(loadingInterval);
                clearInterval(messageInterval);
                clearInterval(logInterval);
            }
            updateUI(progress);
        }, interval);
    }

    window.addEventListener("load", function () {
        progress = 100;
        updateUI(100);
        finishLoading();
    });

    function updateUI(value) {
        if (!progressBar) return;
        const rounded = Math.floor(value);
        progressBar.style.width = `${value}%`;
        percentageText.textContent = `${rounded}%`;
    }

    function finishLoading() {
        if (loadingInterval) clearInterval(loadingInterval);
        if (messageInterval) clearInterval(messageInterval);
        if (logInterval) clearInterval(logInterval);

        if (systemLog) {
            const line = document.createElement("span");
            line.className = "log-line";
            line.textContent = "> Access Granted.";
            line.style.color = "#fff";
            systemLog.appendChild(line);
            while (systemLog.children.length > 3)
                systemLog.removeChild(systemLog.firstChild);
        }

        setTimeout(() => {
            overlay.classList.add("hidden");
            setTimeout(() => {
                overlay.style.display = "none";
                resetLoader();
            }, 500);
        }, 1000);
    }

    function hideLoaderInstant() {
        overlay.classList.add("hidden");
        overlay.style.display = "none";
        resetLoader();
    }
});
