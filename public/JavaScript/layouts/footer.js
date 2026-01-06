/**
 * PRIMERO DE JUNIO - FOOTER JAVASCRIPT PROFESIONAL
 * Funcionalidades optimizadas para footer del sistema - Basado en el sitio web
 */

class FooterManager {
  constructor() {
    this.footer = null;
    this.scrollToTopBtn = null;
    this.statsCounters = [];
    this.notificationCenter = null;
    this.themeToggle = null;
    this.currentTheme = 'dark';
    this.scrollThreshold = 300;
    this.counterAnimated = false;
    this.observerOptions = {
      threshold: 0.3,
      rootMargin: '0px 0px -50px 0px'
    };

    this.init();
  }

  init() {
    this.bindElements();
    this.bindEvents();
    this.setupScrollToTop();
    this.setupStatsCounters();
    this.setupThemeToggle();
    this.setupNotifications();
    this.setupIntersectionObserver();
    this.updateFooterData();
    
    console.log('📄 FOOTER: Sistema de pie de página inicializado correctamente');
  }

  bindElements() {
    this.footer = document.querySelector('.system-footer');
    this.scrollToTopBtn = document.querySelector('.scroll-to-top');
    this.statsCounters = Array.from(document.querySelectorAll('[data-counter]'));
    this.themeToggle = document.querySelector('.theme-toggle');
    this.notificationCenter = document.querySelector('.notification-center');
  }

  bindEvents() {
    // Scroll events
    window.addEventListener('scroll', this.throttle(this.handleScroll.bind(this), 16));
    
    // Scroll to top button
    if (this.scrollToTopBtn) {
      this.scrollToTopBtn.addEventListener('click', this.scrollToTop.bind(this));
    }

    // Theme toggle
    if (this.themeToggle) {
      this.themeToggle.addEventListener('click', this.toggleTheme.bind(this));
    }

    // Footer links
    this.setupFooterLinks();

    // Resize events
    window.addEventListener('resize', this.throttle(this.handleResize.bind(this), 250));

    // Visibility change
    document.addEventListener('visibilitychange', this.handleVisibilityChange.bind(this));

    // Before unload - save state
    window.addEventListener('beforeunload', this.saveState.bind(this));
  }

  handleScroll() {
    const scrollY = window.scrollY;

    // Show/hide scroll to top button
    if (scrollY > this.scrollThreshold) {
      this.showScrollToTop();
    } else {
      this.hideScrollToTop();
    }

    // Update scroll progress
    this.updateScrollProgress();
  }

  showScrollToTop() {
    if (this.scrollToTopBtn && !this.scrollToTopBtn.classList.contains('visible')) {
      this.scrollToTopBtn.classList.add('visible');
      this.scrollToTopBtn.style.transform = 'translateY(0) scale(1)';
      this.scrollToTopBtn.style.opacity = '1';
    }
  }

  hideScrollToTop() {
    if (this.scrollToTopBtn && this.scrollToTopBtn.classList.contains('visible')) {
      this.scrollToTopBtn.classList.remove('visible');
      this.scrollToTopBtn.style.transform = 'translateY(20px) scale(0.8)';
      this.scrollToTopBtn.style.opacity = '0';
    }
  }

  scrollToTop() {
    const duration = 800;
    const startY = window.scrollY;
    const startTime = performance.now();

    const animateScroll = (currentTime) => {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);
      
      // Easing function - easeInOutCubic
      const easeProgress = progress < 0.5 
        ? 4 * progress * progress * progress 
        : 1 - Math.pow(-2 * progress + 2, 3) / 2;

      window.scrollTo(0, startY * (1 - easeProgress));

      if (progress < 1) {
        requestAnimationFrame(animateScroll);
      }
    };

    requestAnimationFrame(animateScroll);

    // Analytics
    this.trackAction('scroll_to_top');
  }

  updateScrollProgress() {
    const progressBar = document.querySelector('.scroll-progress');
    if (progressBar) {
      const scrollTop = window.scrollY;
      const docHeight = document.documentElement.scrollHeight - window.innerHeight;
      const scrollPercent = (scrollTop / docHeight) * 100;
      
      progressBar.style.width = `${Math.min(scrollPercent, 100)}%`;
    }
  }

  setupStatsCounters() {
    if (this.statsCounters.length === 0) return;

    // Intersection Observer for counter animation
    this.observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !this.counterAnimated) {
          this.animateCounters();
          this.counterAnimated = true;
        }
      });
    }, this.observerOptions);

    // Observe the footer stats section
    const statsSection = document.querySelector('.footer-stats');
    if (statsSection) {
      this.observer.observe(statsSection);
    }
  }

  animateCounters() {
    this.statsCounters.forEach((counter, index) => {
      const target = parseInt(counter.dataset.counter);
      const duration = 2000 + (index * 200); // Stagger animation
      const startValue = 0;
      let startTime = null;

      const animateCounter = (currentTime) => {
        if (!startTime) startTime = currentTime;
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);

        // Easing function
        const easeProgress = 1 - Math.pow(1 - progress, 3);
        const currentValue = Math.floor(startValue + (target - startValue) * easeProgress);

        counter.textContent = this.formatNumber(currentValue);

        if (progress < 1) {
          requestAnimationFrame(animateCounter);
        } else {
          counter.textContent = this.formatNumber(target);
          counter.classList.add('animated');
        }
      };

      // Delay each counter
      setTimeout(() => {
        requestAnimationFrame(animateCounter);
      }, index * 100);
    });
  }

  formatNumber(num) {
    if (num >= 1000000) {
      return (num / 1000000).toFixed(1) + 'M';
    } else if (num >= 1000) {
      return (num / 1000).toFixed(1) + 'K';
    }
    return num.toString();
  }

  setupThemeToggle() {
    // Load saved theme
    this.currentTheme = localStorage.getItem('theme') || 'dark';
    this.applyTheme(this.currentTheme);
  }

  toggleTheme() {
    this.currentTheme = this.currentTheme === 'dark' ? 'light' : 'dark';
    this.applyTheme(this.currentTheme);
    
    // Analytics
    this.trackAction('theme_toggle', { theme: this.currentTheme });
  }

  applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
    
    if (this.themeToggle) {
      const icon = this.themeToggle.querySelector('.theme-icon');
      if (icon) {
        icon.innerHTML = theme === 'dark' 
          ? '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10z"/><path d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72 1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 6.64l1.42-1.42"/></svg>'
          : '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>';
      }
    }
    
    console.log(`🎨 Tema cambiado a: ${theme}`);
  }

  setupNotifications() {
    // Check for system notifications periodically
    this.notificationInterval = setInterval(() => {
      this.checkSystemNotifications();
    }, 60000); // Every minute

    // Setup notification center if exists
    if (this.notificationCenter) {
      this.setupNotificationCenter();
    }
  }

  checkSystemNotifications() {
    // Simulated system notifications check
    const notifications = this.getSystemNotifications();
    
    if (notifications.length > 0) {
      this.updateNotificationIndicator(notifications.length);
    }
  }

  getSystemNotifications() {
    // This would typically fetch from an API
    return [
      {
        id: 1,
        type: 'info',
        message: 'Actualización del sistema disponible',
        timestamp: new Date()
      }
    ];
  }

  updateNotificationIndicator(count) {
    const indicator = document.querySelector('.notification-indicator');
    if (indicator) {
      if (count > 0) {
        indicator.textContent = count > 99 ? '99+' : count;
        indicator.style.display = 'flex';
        indicator.classList.add('pulse');
      } else {
        indicator.style.display = 'none';
        indicator.classList.remove('pulse');
      }
    }
  }

  setupNotificationCenter() {
    const toggle = this.notificationCenter.querySelector('.notification-toggle');
    const panel = this.notificationCenter.querySelector('.notification-panel');
    
    if (toggle && panel) {
      toggle.addEventListener('click', () => {
        panel.classList.toggle('show');
      });

      // Close when clicking outside
      document.addEventListener('click', (e) => {
        if (!this.notificationCenter.contains(e.target)) {
          panel.classList.remove('show');
        }
      });
    }
  }

  setupFooterLinks() {
    const footerLinks = document.querySelectorAll('.footer-link');
    
    footerLinks.forEach(link => {
      link.addEventListener('click', (e) => {
        const href = link.getAttribute('href');
        const text = link.textContent.trim();
        
        // Track footer link clicks
        this.trackAction('footer_link_click', { 
          link_text: text,
          link_url: href 
        });

        // Handle special links
        if (href === '#contact') {
          e.preventDefault();
          this.openContactModal();
        } else if (href === '#help') {
          e.preventDefault();
          this.openHelpModal();
        }
      });
    });
  }

  openContactModal() {
    // Create or show contact modal
    console.log('📞 Abriendo modal de contacto');
    this.showModal('contact');
  }

  openHelpModal() {
    // Create or show help modal
    console.log('❓ Abriendo modal de ayuda');
    this.showModal('help');
  }

  showModal(type) {
    let modal = document.getElementById(`${type}Modal`);
    
    if (!modal) {
      modal = this.createModal(type);
      document.body.appendChild(modal);
    }
    
    modal.classList.add('show');
    document.body.classList.add('modal-open');
    
    // Close modal functionality
    const closeBtn = modal.querySelector('.modal-close');
    const backdrop = modal.querySelector('.modal-backdrop');
    
    [closeBtn, backdrop].forEach(element => {
      if (element) {
        element.addEventListener('click', () => this.hideModal(modal));
      }
    });
    
    // ESC key to close
    const handleEscape = (e) => {
      if (e.key === 'Escape') {
        this.hideModal(modal);
        document.removeEventListener('keydown', handleEscape);
      }
    };
    document.addEventListener('keydown', handleEscape);
  }

  createModal(type) {
    const modal = document.createElement('div');
    modal.id = `${type}Modal`;
    modal.className = 'footer-modal';
    
    const content = this.getModalContent(type);
    
    modal.innerHTML = `
      <div class="modal-backdrop"></div>
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">${content.title}</h3>
          <button class="modal-close">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
              <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
            </svg>
          </button>
        </div>
        <div class="modal-body">
          ${content.body}
        </div>
      </div>
    `;
    
    return modal;
  }

  getModalContent(type) {
    const contents = {
      contact: {
        title: 'Contacto',
        body: `
          <div class="contact-info">
            <div class="contact-item">
              <div class="contact-icon">📧</div>
              <div class="contact-details">
                <h4>Email</h4>
                <p>admin@primerodejunio.com</p>
              </div>
            </div>
            <div class="contact-item">
              <div class="contact-icon">📞</div>
              <div class="contact-details">
                <h4>Teléfono</h4>
                <p>+57 300 123 4567</p>
              </div>
            </div>
            <div class="contact-item">
              <div class="contact-icon">🏢</div>
              <div class="contact-details">
                <h4>Oficina</h4>
                <p>Carrera 15 #123-45, Bogotá, Colombia</p>
              </div>
            </div>
          </div>
        `
      },
      help: {
        title: 'Centro de Ayuda',
        body: `
          <div class="help-sections">
            <div class="help-section">
              <h4>🚀 Inicio Rápido</h4>
              <p>Guías básicas para comenzar a usar el sistema.</p>
            </div>
            <div class="help-section">
              <h4>📚 Documentación</h4>
              <p>Documentación completa de todas las funcionalidades.</p>
            </div>
            <div class="help-section">
              <h4>❓ FAQ</h4>
              <p>Preguntas frecuentes y sus respuestas.</p>
            </div>
            <div class="help-section">
              <h4>🎥 Tutoriales</h4>
              <p>Videos explicativos paso a paso.</p>
            </div>
          </div>
        `
      }
    };
    
    return contents[type] || { title: 'Modal', body: 'Contenido del modal' };
  }

  hideModal(modal) {
    modal.classList.remove('show');
    document.body.classList.remove('modal-open');
    
    // Remove modal after animation
    setTimeout(() => {
      if (modal.parentNode) {
        modal.parentNode.removeChild(modal);
      }
    }, 300);
  }

  setupIntersectionObserver() {
    // Observe footer for additional animations
    if (this.footer) {
      const footerObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            this.footer.classList.add('in-view');
          }
        });
      }, { threshold: 0.1 });

      footerObserver.observe(this.footer);
    }
  }

  updateFooterData() {
    // Update copyright year
    const copyrightYear = document.querySelector('.copyright-year');
    if (copyrightYear) {
      copyrightYear.textContent = new Date().getFullYear();
    }

    // Update system version
    const versionElement = document.querySelector('.system-version');
    if (versionElement) {
      versionElement.textContent = this.getSystemVersion();
    }

    // Update last activity
    this.updateLastActivity();
  }

  getSystemVersion() {
    // This would typically come from a config or API
    return 'v2.1.0';
  }

  updateLastActivity() {
    const lastActivityElement = document.querySelector('.last-activity');
    if (lastActivityElement) {
      const now = new Date();
      const timeString = now.toLocaleTimeString('es-CO', { 
        hour: '2-digit', 
        minute: '2-digit' 
      });
      lastActivityElement.textContent = `Última actividad: ${timeString}`;
    }
  }

  handleResize() {
    // Adjust footer layout on resize if needed
    if (window.innerWidth < 768) {
      this.footer?.classList.add('mobile');
    } else {
      this.footer?.classList.remove('mobile');
    }
  }

  handleVisibilityChange() {
    if (document.hidden) {
      // Page is hidden, pause any animations or intervals
      clearInterval(this.notificationInterval);
    } else {
      // Page is visible again, resume
      this.setupNotifications();
      this.updateFooterData();
    }
  }

  saveState() {
    // Save any necessary state before page unload
    const state = {
      theme: this.currentTheme,
      scrollPosition: window.scrollY,
      timestamp: Date.now()
    };
    
    localStorage.setItem('footerState', JSON.stringify(state));
  }

  restoreState() {
    const savedState = localStorage.getItem('footerState');
    if (savedState) {
      try {
        const state = JSON.parse(savedState);
        
        // Restore theme
        if (state.theme) {
          this.currentTheme = state.theme;
          this.applyTheme(this.currentTheme);
        }
      } catch (e) {
        console.error('Error restoring footer state:', e);
      }
    }
  }

  trackAction(action, data = {}) {
    // Analytics tracking
    if (typeof gtag !== 'undefined') {
      gtag('event', action, {
        event_category: 'footer',
        ...data
      });
    }
    
    console.log(`📊 Footer Action: ${action}`, data);
  }

  // Utility functions
  throttle(func, limit) {
    let inThrottle;
    return function() {
      const args = arguments;
      const context = this;
      if (!inThrottle) {
        func.apply(context, args);
        inThrottle = true;
        setTimeout(() => inThrottle = false, limit);
      }
    };
  }

  // Public API methods
  showNotification(message, type = 'info', duration = 5000) {
    const notification = document.createElement('div');
    notification.className = `footer-notification ${type}`;
    notification.innerHTML = `
      <div class="notification-content">
        <div class="notification-icon">
          ${this.getNotificationIcon(type)}
        </div>
        <div class="notification-message">${message}</div>
        <button class="notification-close">×</button>
      </div>
    `;
    
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => notification.classList.add('show'), 100);
    
    // Auto hide
    setTimeout(() => {
      notification.classList.remove('show');
      setTimeout(() => notification.remove(), 300);
    }, duration);
    
    // Manual close
    notification.querySelector('.notification-close').addEventListener('click', () => {
      notification.classList.remove('show');
      setTimeout(() => notification.remove(), 300);
    });
  }

  getNotificationIcon(type) {
    const icons = {
      info: '🔵',
      success: '✅',
      warning: '⚠️',
      error: '❌'
    };
    return icons[type] || icons.info;
  }

  updateStats(newStats) {
    Object.keys(newStats).forEach(key => {
      const element = document.querySelector(`[data-stat="${key}"]`);
      if (element) {
        const counter = element.querySelector('[data-counter]');
        if (counter) {
          counter.dataset.counter = newStats[key];
          counter.textContent = this.formatNumber(newStats[key]);
        }
      }
    });
  }

  destroy() {
    // Cleanup
    clearInterval(this.notificationInterval);
    if (this.observer) {
      this.observer.disconnect();
    }
    
    // Remove event listeners
    window.removeEventListener('scroll', this.handleScroll);
    window.removeEventListener('resize', this.handleResize);
    document.removeEventListener('visibilitychange', this.handleVisibilityChange);
    window.removeEventListener('beforeunload', this.saveState);
  }
}

// Estilos adicionales para efectos dinámicos
const additionalStyles = `
.scroll-to-top {
  position: fixed;
  bottom: 30px;
  right: 30px;
  width: 50px;
  height: 50px;
  background: var(--primary-green);
  border: none;
  border-radius: 50%;
  color: var(--black);
  font-size: 20px;
  cursor: pointer;
  z-index: 999;
  opacity: 0;
  visibility: hidden;
  transform: translateY(20px) scale(0.8);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 4px 12px rgba(0, 255, 102, 0.3);
}

.scroll-to-top.visible {
  opacity: 1;
  visibility: visible;
  transform: translateY(0) scale(1);
}

.scroll-to-top:hover {
  background: rgba(0, 255, 102, 0.9);
  transform: translateY(-2px) scale(1.05);
  box-shadow: 0 6px 16px rgba(0, 255, 102, 0.4);
}

.scroll-progress {
  position: fixed;
  top: 0;
  left: 0;
  height: 3px;
  background: var(--primary-green);
  transition: width 0.1s ease;
  z-index: 9999;
}

.footer-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 10000;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
}

.footer-modal.show {
  opacity: 1;
  visibility: visible;
}

.modal-backdrop {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.7);
  backdrop-filter: blur(5px);
}

.modal-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: var(--card-bg);
  border-radius: var(--border-radius-large);
  padding: 0;
  max-width: 500px;
  width: 90%;
  max-height: 80vh;
  overflow: hidden;
  border: 1px solid var(--border-color);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px;
  border-bottom: 1px solid var(--border-color);
}

.modal-title {
  margin: 0;
  font-size: 20px;
  font-weight: 600;
  color: var(--text-primary);
}

.modal-close {
  background: none;
  border: none;
  color: var(--text-secondary);
  cursor: pointer;
  padding: 5px;
  border-radius: var(--border-radius);
  transition: var(--transition-fast);
}

.modal-close:hover {
  color: var(--text-primary);
  background: var(--hover-bg);
}

.modal-body {
  padding: 20px;
  overflow-y: auto;
}

.contact-info, .help-sections {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.contact-item, .help-section {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  padding: 12px;
  border-radius: var(--border-radius);
  background: var(--hover-bg);
  transition: var(--transition-fast);
}

.contact-item:hover, .help-section:hover {
  background: var(--border-color);
  transform: translateY(-1px);
}

.contact-icon {
  font-size: 24px;
  flex-shrink: 0;
}

.contact-details h4, .help-section h4 {
  margin: 0 0 4px 0;
  font-size: 14px;
  font-weight: 600;
  color: var(--text-primary);
}

.contact-details p, .help-section p {
  margin: 0;
  font-size: 13px;
  color: var(--text-secondary);
  line-height: 1.4;
}

.footer-notification {
  position: fixed;
  bottom: 100px;
  right: 20px;
  background: var(--card-bg);
  border: 1px solid var(--border-color);
  border-radius: var(--border-radius-large);
  padding: 16px;
  max-width: 300px;
  z-index: 10000;
  transform: translateX(400px);
  opacity: 0;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
}

.footer-notification.show {
  transform: translateX(0);
  opacity: 1;
}

.notification-content {
  display: flex;
  align-items: flex-start;
  gap: 12px;
}

.notification-icon {
  font-size: 18px;
  flex-shrink: 0;
  margin-top: 2px;
}

.notification-message {
  flex: 1;
  font-size: 14px;
  color: var(--text-primary);
  line-height: 1.4;
}

.notification-close {
  background: none;
  border: none;
  color: var(--text-secondary);
  cursor: pointer;
  font-size: 18px;
  line-height: 1;
  padding: 0;
  width: 20px;
  height: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.notification-close:hover {
  color: var(--text-primary);
}

.notification-indicator {
  position: absolute;
  top: -5px;
  right: -5px;
  background: var(--accent-red);
  color: var(--white);
  font-size: 10px;
  font-weight: 600;
  padding: 2px 6px;
  border-radius: 10px;
  min-width: 16px;
  height: 16px;
  display: none;
  align-items: center;
  justify-content: center;
}

.notification-indicator.pulse {
  animation: indicatorPulse 2s infinite;
}

@keyframes indicatorPulse {
  0%, 100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.2);
  }
}

.system-footer.in-view {
  animation: footerSlideIn 0.6s ease-out;
}

@keyframes footerSlideIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@media (max-width: 768px) {
  .scroll-to-top {
    bottom: 20px;
    right: 20px;
    width: 45px;
    height: 45px;
    font-size: 18px;
  }
  
  .modal-content {
    width: 95%;
    max-height: 85vh;
  }
  
  .footer-notification {
    right: 10px;
    left: 10px;
    max-width: none;
    transform: translateY(100px);
  }
  
  .footer-notification.show {
    transform: translateY(0);
  }
}

body.modal-open {
  overflow: hidden;
}

[data-counter].animated {
  color: var(--primary-green);
  font-weight: 700;
}
`;

// Inyectar estilos adicionales
const styleSheet = document.createElement("style");
styleSheet.textContent = additionalStyles;
document.head.appendChild(styleSheet);

// Inicializar cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
  new FooterManager();
});

// Exportar para uso global
window.FooterManager = FooterManager;
