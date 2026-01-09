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
    let loadingStartTime = null;
    let pageLoaded = false;

    // Simulation Config
    const duration = 2000; // Llega al 100% en 2 segundos
    const minDuration = 3000; // Mínimo 3 segundos total
    const interval = 20; // Actualización cada 20ms para animación fluida
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
            overlay.classList.remove("hidden");
            loadingStartTime = Date.now();
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

        loadingStartTime = Date.now();

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
            progress += increment;

            if (progress >= 100) {
                progress = 100;
                updateUI(100);
                clearInterval(loadingInterval);
                clearInterval(messageInterval);
                clearInterval(logInterval);
                
                // Solo terminar si la página ya está cargada
                if (pageLoaded) {
                    finishLoading();
                }
            } else {
                updateUI(progress);
            }
        }, interval);
    }

    window.addEventListener("load", function () {
        pageLoaded = true;
        
        // Si ya llegamos al 100%, terminar la carga
        if (progress >= 100) {
            finishLoading();
        }
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

        const elapsed = Date.now() - loadingStartTime;
        const remainingTime = Math.max(0, minDuration - elapsed);

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
                resetLoader();
            }, 500);
        }, remainingTime + 1000);
    }

    function hideLoaderInstant() {
        overlay.classList.add("hidden");
        resetLoader();
    }
});
