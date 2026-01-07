<div class="loading-overlay" id="loadingOverlay">
    <!-- Tech Background Elements -->
    <div class="tech-bg-grid"></div>
    <div class="tech-particles">
        <div class="tp tp-1"></div>
        <div class="tp tp-2"></div>
        <div class="tp tp-3"></div>
        <div class="tp tp-4"></div>
    </div>

    <div class="loading-content">
        <h2 class="welcome-text">Bienvenido a</h2>
        <h1 class="brand-text" data-text="PROMPTVAULT">PROMPTVAULT</h1>
        
        <div class="spinner-container">
            <svg class="spinner" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle>
            </svg>
        </div>

        <!-- System Log Output -->
        <div class="system-log-container">
            <div class="log-content" id="systemLog">
                <span class="log-line">> Iniciando kernel...</span>
            </div>
        </div>

        <div class="progress-wrapper">
            <div class="progress-bar-bg">
                <div class="progress-bar-fill" id="loadingProgressBar"></div>
            </div>
            <div class="progress-info">
                <span class="percentage" id="loadingPercentage">0%</span>
            </div>
        </div>
        
        <div class="status-wrapper">
            <p class="loading-status" id="loadingStatus">Iniciando sistema...</p>
            <div class="loading-dots">
                <span></span><span></span><span></span>
            </div>
        </div>
    </div>
</div>
