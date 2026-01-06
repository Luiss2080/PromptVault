/**
 * PRIMERO DE JUNIO - HEADER JAVASCRIPT PROFESIONAL
 * Funcionalidades optimizadas para header del sistema - Basado en el sitio web
 */

class HeaderManager {
  constructor() {
    this.header = null;
    this.searchInput = null;
    this.notificationBtn = null;
    this.notificationDropdown = null;
    this.userBtn = null;
    this.userDropdown = null;
    this.mobileMenuBtn = null;
    this.dropdownTimeouts = new Map();
    this.searchTimeout = null;
    this.lastScrollY = 0;
    this.isScrolling = false;

    this.init();
  }

  init() {
    this.bindElements();
    this.bindEvents();
    this.setupSearch();
    this.setupNotifications();
    this.setupDropdowns();
    this.handleScroll();
    this.updateTime();
    this.setupKeyboardNavigation();
    
    console.log('🎯 HEADER: Sistema de navegación inicializado correctamente');
  }

  bindElements() {
    this.header = document.querySelector('.system-header');
    this.searchInput = document.getElementById('globalSearch');
    this.notificationBtn = document.getElementById('notificationToggle');
    this.notificationDropdown = document.getElementById('notificationDropdown');
    this.userBtn = document.getElementById('userToggle');
    this.userDropdown = document.getElementById('userDropdown');
    this.mobileMenuBtn = document.getElementById('mobileMenuToggle');
  }

  bindEvents() {
    // Scroll events
    window.addEventListener('scroll', this.throttle(this.handleScroll.bind(this), 16));
    
    // Resize events
    window.addEventListener('resize', this.throttle(this.handleResize.bind(this), 250));
    
    // Click outside to close dropdowns
    document.addEventListener('click', this.handleOutsideClick.bind(this));
    
    // Escape key to close dropdowns
    document.addEventListener('keydown', this.handleEscapeKey.bind(this));
    
    // Mobile menu toggle
    if (this.mobileMenuBtn) {
      this.mobileMenuBtn.addEventListener('click', this.toggleMobileMenu.bind(this));
    }

    // Window focus events
    window.addEventListener('focus', this.handleWindowFocus.bind(this));
    window.addEventListener('blur', this.handleWindowBlur.bind(this));
  }

  setupSearch() {
    if (!this.searchInput) return;

    this.searchInput.addEventListener('input', this.handleSearchInput.bind(this));
    this.searchInput.addEventListener('keydown', this.handleSearchKeydown.bind(this));
    this.searchInput.addEventListener('focus', this.handleSearchFocus.bind(this));
    this.searchInput.addEventListener('blur', this.handleSearchBlur.bind(this));

    // Search button functionality
    const searchBtn = document.querySelector('.search-btn');
    if (searchBtn) {
      searchBtn.addEventListener('click', this.performSearch.bind(this));
    }
  }

  setupNotifications() {
    if (!this.notificationBtn || !this.notificationDropdown) return;

    this.notificationBtn.addEventListener('click', this.toggleNotificationDropdown.bind(this));
    
    // Auto-refresh notifications
    this.startNotificationRefresh();
    
    // Mark notifications as read
    this.setupNotificationMarkAsRead();
  }

  setupDropdowns() {
    // User dropdown
    if (this.userBtn && this.userDropdown) {
      this.userBtn.addEventListener('click', this.toggleUserDropdown.bind(this));
    }

    // Dropdown hover delays
    this.setupDropdownHover();
  }

  handleScroll() {
    const currentScrollY = window.scrollY;
    
    if (!this.header) return;

    // Add scrolled class
    if (currentScrollY > 10) {
      this.header.classList.add('scrolled');
    } else {
      this.header.classList.remove('scrolled');
    }

    // Hide header on scroll down, show on scroll up (mobile)
    if (window.innerWidth <= 768) {
      if (currentScrollY > this.lastScrollY && currentScrollY > 100) {
        this.header.style.transform = 'translateY(-100%)';
      } else {
        this.header.style.transform = 'translateY(0)';
      }
    }

    this.lastScrollY = currentScrollY;
  }

  handleResize() {
    // Close all dropdowns on resize
    this.closeAllDropdowns();
    
    // Reset mobile menu
    if (window.innerWidth > 768) {
      this.closeMobileMenu();
    }
  }

  handleOutsideClick(e) {
    // Close dropdowns when clicking outside
    if (!e.target.closest('.notification-container')) {
      this.closeNotificationDropdown();
    }
    
    if (!e.target.closest('.user-container')) {
      this.closeUserDropdown();
    }
  }

  handleEscapeKey(e) {
    if (e.key === 'Escape') {
      this.closeAllDropdowns();
      this.searchInput?.blur();
    }
  }

  handleSearchInput(e) {
    const query = e.target.value.trim();
    
    // Clear previous timeout
    if (this.searchTimeout) {
      clearTimeout(this.searchTimeout);
    }
    
    // Debounce search
    this.searchTimeout = setTimeout(() => {
      if (query.length >= 2) {
        this.performLiveSearch(query);
      } else {
        this.clearSearchResults();
      }
    }, 300);
  }

  handleSearchKeydown(e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      this.performSearch();
    }
  }

  handleSearchFocus(e) {
    e.target.parentElement.classList.add('focused');
  }

  handleSearchBlur(e) {
    e.target.parentElement.classList.remove('focused');
  }

  performSearch() {
    const query = this.searchInput?.value.trim();
    if (!query) return;

    console.log(`🔍 BÚSQUEDA GLOBAL: "${query}"`);
    
    // Aquí implementarías la lógica de búsqueda real
    this.showSearchResults(query);
    
    // Analytics tracking
    this.trackSearch(query);
  }

  performLiveSearch(query) {
    // Simulación de búsqueda en vivo
    console.log(`🔍 BÚSQUEDA EN VIVO: "${query}"`);
    
    // Mostrar indicador de carga
    this.showSearchLoading();
    
    // Simular API call
    setTimeout(() => {
      this.showLiveSearchResults(query);
    }, 500);
  }

  showSearchLoading() {
    const container = this.searchInput?.parentElement;
    if (container) {
      container.classList.add('loading');
    }
  }

  showLiveSearchResults(query) {
    const container = this.searchInput?.parentElement;
    if (container) {
      container.classList.remove('loading');
    }
    
    // Aquí mostrarías los resultados en tiempo real
    console.log(`📊 Resultados para: "${query}"`);
  }

  showSearchResults(query) {
    // Redirigir a página de resultados o mostrar modal
    console.log(`📊 Búsqueda completa para: "${query}"`);
  }

  clearSearchResults() {
    // Limpiar resultados de búsqueda en vivo
    console.log('🧹 Limpiando resultados de búsqueda');
  }

  trackSearch(query) {
    // Analytics tracking
    if (typeof gtag !== 'undefined') {
      gtag('event', 'search', {
        search_term: query,
        content_type: 'system_search'
      });
    }
  }

  toggleNotificationDropdown(e) {
    e.stopPropagation();
    
    // Close user dropdown if open
    this.closeUserDropdown();
    
    if (this.notificationDropdown.classList.contains('show')) {
      this.closeNotificationDropdown();
    } else {
      this.openNotificationDropdown();
    }
  }

  openNotificationDropdown() {
    this.notificationDropdown.classList.add('show');
    this.notificationBtn.classList.add('active');
    
    // Mark as opened
    this.markNotificationsAsViewed();
    
    // Animation
    this.animateDropdownOpen(this.notificationDropdown);
  }

  closeNotificationDropdown() {
    this.notificationDropdown.classList.remove('show');
    this.notificationBtn.classList.remove('active');
  }

  toggleUserDropdown(e) {
    e.stopPropagation();
    
    // Close notification dropdown if open
    this.closeNotificationDropdown();
    
    if (this.userDropdown.classList.contains('show')) {
      this.closeUserDropdown();
    } else {
      this.openUserDropdown();
    }
  }

  openUserDropdown() {
    this.userDropdown.classList.add('show');
    this.userBtn.classList.add('active');
    
    // Animation
    this.animateDropdownOpen(this.userDropdown);
  }

  closeUserDropdown() {
    this.userDropdown.classList.remove('show');
    this.userBtn.classList.remove('active');
  }

  closeAllDropdowns() {
    this.closeNotificationDropdown();
    this.closeUserDropdown();
  }

  animateDropdownOpen(dropdown) {
    dropdown.style.opacity = '0';
    dropdown.style.transform = 'translateY(-10px)';
    
    // Force reflow
    dropdown.offsetHeight;
    
    dropdown.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
    dropdown.style.opacity = '1';
    dropdown.style.transform = 'translateY(0)';
  }

  setupDropdownHover() {
    // Add subtle hover delays for better UX
    [this.notificationBtn, this.userBtn].forEach(btn => {
      if (!btn) return;
      
      btn.addEventListener('mouseenter', () => {
        btn.classList.add('hovered');
      });
      
      btn.addEventListener('mouseleave', () => {
        btn.classList.remove('hovered');
      });
    });
  }

  startNotificationRefresh() {
    // Refresh notifications every 30 seconds
    setInterval(() => {
      this.refreshNotifications();
    }, 30000);
  }

  refreshNotifications() {
    // Simulación de actualización de notificaciones
    console.log('🔄 Actualizando notificaciones...');
    
    // Aquí harías una llamada a la API
    // this.fetchNotifications();
  }

  markNotificationsAsViewed() {
    const notificationCount = document.querySelector('.notification-count');
    if (notificationCount) {
      // Animate count decrease
      this.animateCounterDecrease(notificationCount);
    }
  }

  setupNotificationMarkAsRead() {
    const notificationItems = document.querySelectorAll('.notification-item');
    notificationItems.forEach(item => {
      item.addEventListener('click', (e) => {
        this.markNotificationAsRead(item);
      });
    });
  }

  markNotificationAsRead(item) {
    item.classList.add('read');
    
    // Update counter
    this.updateNotificationCounter();
  }

  updateNotificationCounter() {
    const unreadCount = document.querySelectorAll('.notification-item:not(.read)').length;
    const counter = document.querySelector('.notification-count');
    
    if (counter) {
      if (unreadCount === 0) {
        counter.style.display = 'none';
      } else {
        counter.textContent = unreadCount;
        counter.style.display = 'flex';
      }
    }
  }

  animateCounterDecrease(counter) {
    counter.style.transform = 'scale(0.8)';
    setTimeout(() => {
      counter.style.transform = 'scale(1)';
    }, 150);
  }

  toggleMobileMenu() {
    this.mobileMenuBtn.classList.toggle('active');
    
    // Here you would typically show/hide a mobile navigation menu
    console.log('📱 Mobile menu toggled');
  }

  closeMobileMenu() {
    if (this.mobileMenuBtn) {
      this.mobileMenuBtn.classList.remove('active');
    }
  }

  setupKeyboardNavigation() {
    document.addEventListener('keydown', (e) => {
      // Alt + S for search
      if (e.altKey && e.key === 's') {
        e.preventDefault();
        this.searchInput?.focus();
      }
      
      // Alt + N for notifications
      if (e.altKey && e.key === 'n') {
        e.preventDefault();
        this.toggleNotificationDropdown(e);
      }
      
      // Alt + U for user menu
      if (e.altKey && e.key === 'u') {
        e.preventDefault();
        this.toggleUserDropdown(e);
      }
    });
  }

  updateTime() {
    // Update any time-related elements
    const timeElements = document.querySelectorAll('[data-time]');
    timeElements.forEach(element => {
      const timestamp = element.dataset.time;
      element.textContent = this.formatRelativeTime(timestamp);
    });
    
    // Update every minute
    setTimeout(() => this.updateTime(), 60000);
  }

  formatRelativeTime(timestamp) {
    const now = new Date();
    const time = new Date(timestamp);
    const diff = now - time;
    
    const minutes = Math.floor(diff / 60000);
    const hours = Math.floor(diff / 3600000);
    const days = Math.floor(diff / 86400000);
    
    if (minutes < 1) return 'Hace un momento';
    if (minutes < 60) return `Hace ${minutes} minutos`;
    if (hours < 24) return `Hace ${hours} horas`;
    if (days < 7) return `Hace ${days} días`;
    
    return time.toLocaleDateString();
  }

  handleWindowFocus() {
    // Refresh data when window regains focus
    this.refreshNotifications();
    console.log('🎯 Ventana enfocada - actualizando datos');
  }

  handleWindowBlur() {
    // Cleanup when window loses focus
    this.closeAllDropdowns();
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

  showToast(message, type = 'info') {
    this.createToast(message, type);
  }

  createToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `notification-toast ${type}`;
    toast.innerHTML = `
      <div class="toast-content">
        <div class="toast-icon">
          ${this.getToastIcon(type)}
        </div>
        <div class="toast-message">${message}</div>
        <button class="toast-close" onclick="this.parentElement.parentElement.remove()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
          </svg>
        </button>
      </div>
    `;
    
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => toast.classList.add('show'), 100);
    
    // Auto remove
    setTimeout(() => {
      toast.classList.remove('show');
      setTimeout(() => toast.remove(), 300);
    }, 5000);
  }

  getToastIcon(type) {
    const icons = {
      info: '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>',
      success: '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
      warning: '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>',
      error: '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/></svg>'
    };
    return icons[type] || icons.info;
  }
}

// CSS adicional dinámico para efectos y notificaciones
const additionalStyles = `
.notification-toast {
  position: fixed;
  top: 100px;
  right: 20px;
  background: rgba(0, 0, 0, 0.95);
  backdrop-filter: blur(15px);
  border: 1px solid rgba(0, 255, 102, 0.3);
  border-radius: var(--border-radius-large);
  padding: 16px 20px;
  color: var(--white);
  font-size: 14px;
  font-weight: 500;
  z-index: 10000;
  transform: translateX(400px);
  opacity: 0;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  max-width: 350px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
}

.notification-toast.show {
  transform: translateX(0);
  opacity: 1;
}

.notification-toast.success {
  border-color: rgba(0, 255, 102, 0.5);
}

.notification-toast.warning {
  border-color: rgba(255, 165, 0, 0.5);
}

.notification-toast.error {
  border-color: rgba(255, 59, 92, 0.5);
}

.toast-content {
  display: flex;
  align-items: flex-start;
  gap: 12px;
}

.toast-icon {
  flex-shrink: 0;
  color: var(--primary-green);
  margin-top: 2px;
}

.toast-message {
  flex: 1;
  line-height: 1.4;
}

.toast-close {
  background: none;
  border: none;
  color: var(--gray-medium);
  cursor: pointer;
  padding: 0;
  width: 20px;
  height: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 4px;
  transition: var(--transition-fast);
}

.toast-close:hover {
  color: var(--white);
  background: rgba(255, 255, 255, 0.1);
}

.search-container.loading::after {
  content: '';
  position: absolute;
  right: 50px;
  top: 50%;
  transform: translateY(-50%);
  width: 16px;
  height: 16px;
  border: 2px solid transparent;
  border-top: 2px solid var(--primary-green);
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: translateY(-50%) rotate(360deg); }
}

.notification-btn.hovered {
  transform: translateY(-1px);
}

.user-btn.hovered {
  transform: translateY(-1px);
}

.dropdown-menu {
  animation: dropdownSlide 0.3s ease-out;
}

@keyframes dropdownSlide {
  from {
    opacity: 0;
    transform: translateY(-15px) scale(0.95);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

.nav-link.loading {
  pointer-events: none;
  opacity: 0.6;
}

.nav-link.loading .nav-icon {
  animation: pulse 1.5s infinite;
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
    transform: scale(1);
  }
  50% {
    opacity: 0.5;
    transform: scale(0.95);
  }
}

.search-container.focused {
  box-shadow: 0 0 0 3px rgba(0, 255, 102, 0.2);
}

.notification-item.read {
  opacity: 0.7;
  background: rgba(255, 255, 255, 0.02);
}
`;

// Inyectar estilos adicionales
const styleSheet = document.createElement("style");
styleSheet.textContent = additionalStyles;
document.head.appendChild(styleSheet);

// Inicializar cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
  new HeaderManager();
});

// Exportar para uso global si es necesario
window.HeaderManager = HeaderManager;
