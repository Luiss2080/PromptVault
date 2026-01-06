/**
 * PRIMERO DE JUNIO - SIDEBAR JAVASCRIPT PROFESIONAL
 * Sistema de navegación lateral optimizado - Basado en el sitio web
 */

class SidebarManager {
  constructor() {
    this.sidebar = null;
    this.sidebarToggle = null;
    this.sidebarOverlay = null;
    this.navItems = [];
    this.activeItem = null;
    this.isCollapsed = false;
    this.isHovered = false;
    this.touchStartX = 0;
    this.touchStartY = 0;
    this.swipeThreshold = 50;
    this.isAnimating = false;
    
    this.init();
  }

  init() {
    this.bindElements();
    this.bindEvents();
    this.setupNavigation();
    this.setupTooltips();
    this.setupSwipeGestures();
    this.setupKeyboardShortcuts();
    this.restoreState();
    this.updateActiveItem();
    
    console.log('📱 SIDEBAR: Sistema de navegación lateral inicializado');
  }

  bindElements() {
    this.sidebar = document.querySelector('.main-sidebar');
    this.sidebarToggle = document.querySelector('.sidebar-toggle');
    this.sidebarOverlay = document.querySelector('.sidebar-overlay');
    this.navItems = Array.from(document.querySelectorAll('.nav-item'));
    this.collapseBtn = document.querySelector('.collapse-btn');
  }

  bindEvents() {
    // Toggle buttons
    if (this.sidebarToggle) {
      this.sidebarToggle.addEventListener('click', this.toggleSidebar.bind(this));
    }
    
    if (this.collapseBtn) {
      this.collapseBtn.addEventListener('click', this.toggleCollapse.bind(this));
    }

    // Overlay click
    if (this.sidebarOverlay) {
      this.sidebarOverlay.addEventListener('click', this.closeSidebar.bind(this));
    }

    // Hover events
    if (this.sidebar) {
      this.sidebar.addEventListener('mouseenter', this.handleMouseEnter.bind(this));
      this.sidebar.addEventListener('mouseleave', this.handleMouseLeave.bind(this));
    }

    // Resize events
    window.addEventListener('resize', this.throttle(this.handleResize.bind(this), 250));

    // Navigation items
    this.navItems.forEach(item => {
      this.setupNavItem(item);
    });

    // Escape key
    document.addEventListener('keydown', this.handleEscapeKey.bind(this));

    // Route changes
    window.addEventListener('popstate', this.updateActiveItem.bind(this));
  }

  setupNavItem(item) {
    const link = item.querySelector('.nav-link');
    const submenu = item.querySelector('.nav-submenu');
    
    if (link) {
      link.addEventListener('click', this.handleNavClick.bind(this, item));
      
      // Hover effects for collapsed mode
      link.addEventListener('mouseenter', this.showTooltip.bind(this, item));
      link.addEventListener('mouseleave', this.hideTooltip.bind(this, item));
    }

    // Submenu toggle
    if (submenu) {
      const toggle = item.querySelector('.submenu-toggle');
      if (toggle) {
        toggle.addEventListener('click', this.toggleSubmenu.bind(this, item));
      }
    }
  }

  handleNavClick(item, e) {
    const link = e.currentTarget;
    const hasSubmenu = item.querySelector('.nav-submenu');
    
    if (hasSubmenu && !link.classList.contains('has-link')) {
      e.preventDefault();
      this.toggleSubmenu(item);
      return;
    }

    // Handle regular navigation
    this.setActiveItem(item);
    
    // Close sidebar on mobile after navigation
    if (window.innerWidth <= 768) {
      setTimeout(() => this.closeSidebar(), 300);
    }

    // Loading state
    this.showLoadingState(item);
    
    // Analytics
    this.trackNavigation(link.getAttribute('href') || link.textContent.trim());
  }

  toggleSubmenu(item) {
    const submenu = item.querySelector('.nav-submenu');
    if (!submenu) return;

    const isOpen = item.classList.contains('menu-open');
    
    // Close other submenus
    this.navItems.forEach(navItem => {
      if (navItem !== item) {
        navItem.classList.remove('menu-open');
        const otherSubmenu = navItem.querySelector('.nav-submenu');
        if (otherSubmenu) {
          this.collapseSubmenu(otherSubmenu);
        }
      }
    });

    if (isOpen) {
      this.collapseSubmenu(submenu);
      item.classList.remove('menu-open');
    } else {
      this.expandSubmenu(submenu);
      item.classList.add('menu-open');
    }
  }

  expandSubmenu(submenu) {
    const height = submenu.scrollHeight;
    submenu.style.height = height + 'px';
    submenu.style.opacity = '1';
    
    setTimeout(() => {
      submenu.style.height = 'auto';
    }, 300);
  }

  collapseSubmenu(submenu) {
    submenu.style.height = submenu.scrollHeight + 'px';
    
    // Force reflow
    submenu.offsetHeight;
    
    submenu.style.height = '0';
    submenu.style.opacity = '0';
  }

  setActiveItem(item) {
    // Remove active from all items
    this.navItems.forEach(navItem => {
      navItem.classList.remove('active');
      const link = navItem.querySelector('.nav-link');
      if (link) link.classList.remove('active');
    });

    // Set new active item
    item.classList.add('active');
    const link = item.querySelector('.nav-link');
    if (link) link.classList.add('active');

    this.activeItem = item;
    this.saveActiveState();
  }

  updateActiveItem() {
    const currentPath = window.location.pathname;
    
    this.navItems.forEach(item => {
      const link = item.querySelector('.nav-link');
      if (link) {
        const href = link.getAttribute('href');
        if (href && currentPath.includes(href.replace(/^\//, ''))) {
          this.setActiveItem(item);
          
          // Expand parent menu if it's a submenu item
          const parentItem = item.closest('.nav-item');
          if (parentItem && parentItem !== item) {
            this.toggleSubmenu(parentItem);
          }
        }
      }
    });
  }

  toggleSidebar() {
    if (window.innerWidth <= 768) {
      // Mobile behavior
      this.sidebar.classList.toggle('show');
      this.sidebarOverlay?.classList.toggle('show');
      document.body.classList.toggle('sidebar-open');
    } else {
      // Desktop behavior
      this.toggleCollapse();
    }
  }

  toggleCollapse() {
    if (this.isAnimating) return;
    
    this.isAnimating = true;
    this.isCollapsed = !this.isCollapsed;
    
    this.sidebar.classList.toggle('collapsed', this.isCollapsed);
    document.body.classList.toggle('sidebar-collapsed', this.isCollapsed);
    
    // Close all submenus when collapsing
    if (this.isCollapsed) {
      this.closeAllSubmenus();
    }
    
    // Save state
    this.saveCollapseState();
    
    // Update tooltips
    setTimeout(() => {
      this.updateTooltips();
      this.isAnimating = false;
    }, 300);

    console.log(`📱 Sidebar ${this.isCollapsed ? 'colapsado' : 'expandido'}`);
  }

  closeSidebar() {
    this.sidebar?.classList.remove('show');
    this.sidebarOverlay?.classList.remove('show');
    document.body.classList.remove('sidebar-open');
  }

  closeAllSubmenus() {
    this.navItems.forEach(item => {
      item.classList.remove('menu-open');
      const submenu = item.querySelector('.nav-submenu');
      if (submenu) {
        this.collapseSubmenu(submenu);
      }
    });
  }

  handleMouseEnter() {
    if (this.isCollapsed && window.innerWidth > 768) {
      this.isHovered = true;
      this.sidebar.classList.add('hovered');
      this.showAllTooltips();
    }
  }

  handleMouseLeave() {
    if (this.isCollapsed && window.innerWidth > 768) {
      this.isHovered = false;
      this.sidebar.classList.remove('hovered');
      this.hideAllTooltips();
    }
  }

  handleResize() {
    if (window.innerWidth > 768) {
      // Desktop mode
      this.closeSidebar();
      this.sidebar?.classList.remove('show');
      this.sidebarOverlay?.classList.remove('show');
      document.body.classList.remove('sidebar-open');
    } else {
      // Mobile mode - remove collapsed state
      this.sidebar?.classList.remove('collapsed');
      document.body.classList.remove('sidebar-collapsed');
    }
  }

  handleEscapeKey(e) {
    if (e.key === 'Escape') {
      this.closeSidebar();
      this.closeAllSubmenus();
    }
  }

  setupTooltips() {
    this.navItems.forEach(item => {
      const link = item.querySelector('.nav-link');
      const text = item.querySelector('.nav-text');
      
      if (link && text) {
        const tooltip = document.createElement('div');
        tooltip.className = 'nav-tooltip';
        tooltip.textContent = text.textContent.trim();
        item.appendChild(tooltip);
      }
    });
  }

  showTooltip(item) {
    if (!this.isCollapsed || this.isHovered || window.innerWidth <= 768) return;
    
    const tooltip = item.querySelector('.nav-tooltip');
    if (tooltip) {
      tooltip.classList.add('show');
    }
  }

  hideTooltip(item) {
    const tooltip = item.querySelector('.nav-tooltip');
    if (tooltip) {
      tooltip.classList.remove('show');
    }
  }

  showAllTooltips() {
    const tooltips = document.querySelectorAll('.nav-tooltip');
    tooltips.forEach(tooltip => tooltip.classList.add('hover-mode'));
  }

  hideAllTooltips() {
    const tooltips = document.querySelectorAll('.nav-tooltip');
    tooltips.forEach(tooltip => tooltip.classList.remove('hover-mode'));
  }

  updateTooltips() {
    const tooltips = document.querySelectorAll('.nav-tooltip');
    tooltips.forEach(tooltip => {
      if (this.isCollapsed) {
        tooltip.style.display = 'block';
      } else {
        tooltip.style.display = 'none';
      }
    });
  }

  setupSwipeGestures() {
    if (!('ontouchstart' in window)) return;

    document.addEventListener('touchstart', this.handleTouchStart.bind(this), { passive: true });
    document.addEventListener('touchmove', this.handleTouchMove.bind(this), { passive: true });
    document.addEventListener('touchend', this.handleTouchEnd.bind(this), { passive: true });
  }

  handleTouchStart(e) {
    this.touchStartX = e.touches[0].clientX;
    this.touchStartY = e.touches[0].clientY;
  }

  handleTouchMove(e) {
    if (!this.touchStartX || !this.touchStartY) return;

    const touchX = e.touches[0].clientX;
    const touchY = e.touches[0].clientY;
    
    const diffX = touchX - this.touchStartX;
    const diffY = touchY - this.touchStartY;
    
    // Only handle horizontal swipes
    if (Math.abs(diffX) > Math.abs(diffY)) {
      // Swipe right to open sidebar
      if (diffX > this.swipeThreshold && this.touchStartX < 50) {
        this.toggleSidebar();
      }
      // Swipe left to close sidebar
      else if (diffX < -this.swipeThreshold && this.sidebar?.classList.contains('show')) {
        this.closeSidebar();
      }
    }
  }

  handleTouchEnd() {
    this.touchStartX = 0;
    this.touchStartY = 0;
  }

  setupKeyboardShortcuts() {
    document.addEventListener('keydown', (e) => {
      // Ctrl/Cmd + B to toggle sidebar
      if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
        e.preventDefault();
        this.toggleSidebar();
      }
      
      // Alt + 1-9 for quick navigation
      if (e.altKey && e.key >= '1' && e.key <= '9') {
        e.preventDefault();
        const index = parseInt(e.key) - 1;
        if (this.navItems[index]) {
          this.navItems[index].querySelector('.nav-link')?.click();
        }
      }
    });
  }

  showLoadingState(item) {
    const link = item.querySelector('.nav-link');
    if (link) {
      link.classList.add('loading');
      
      // Remove loading state after navigation
      setTimeout(() => {
        link.classList.remove('loading');
      }, 1000);
    }
  }

  trackNavigation(page) {
    if (typeof gtag !== 'undefined') {
      gtag('event', 'navigation', {
        page_title: page,
        page_location: window.location.href,
        content_type: 'sidebar_navigation'
      });
    }
    
    console.log(`🧭 Navegación: ${page}`);
  }

  saveCollapseState() {
    localStorage.setItem('sidebarCollapsed', JSON.stringify(this.isCollapsed));
  }

  saveActiveState() {
    if (this.activeItem) {
      const activeId = this.activeItem.dataset.navId;
      if (activeId) {
        localStorage.setItem('sidebarActiveItem', activeId);
      }
    }
  }

  restoreState() {
    // Restore collapse state
    const savedCollapsed = localStorage.getItem('sidebarCollapsed');
    if (savedCollapsed) {
      this.isCollapsed = JSON.parse(savedCollapsed);
      if (this.isCollapsed && window.innerWidth > 768) {
        this.sidebar?.classList.add('collapsed');
        document.body.classList.add('sidebar-collapsed');
      }
    }

    // Restore active item
    const savedActiveId = localStorage.getItem('sidebarActiveItem');
    if (savedActiveId) {
      const activeItem = document.querySelector(`[data-nav-id="${savedActiveId}"]`);
      if (activeItem) {
        this.setActiveItem(activeItem);
      }
    }
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
  expand() {
    if (this.isCollapsed) {
      this.toggleCollapse();
    }
  }

  collapse() {
    if (!this.isCollapsed) {
      this.toggleCollapse();
    }
  }

  navigateTo(navId) {
    const item = document.querySelector(`[data-nav-id="${navId}"]`);
    if (item) {
      const link = item.querySelector('.nav-link');
      link?.click();
    }
  }

  highlightItem(navId, duration = 2000) {
    const item = document.querySelector(`[data-nav-id="${navId}"]`);
    if (item) {
      item.classList.add('highlighted');
      setTimeout(() => {
        item.classList.remove('highlighted');
      }, duration);
    }
  }

  showNotificationBadge(navId, count = 1) {
    const item = document.querySelector(`[data-nav-id="${navId}"]`);
    if (item) {
      let badge = item.querySelector('.nav-badge');
      if (!badge) {
        badge = document.createElement('span');
        badge.className = 'nav-badge';
        item.querySelector('.nav-link').appendChild(badge);
      }
      
      badge.textContent = count;
      badge.style.display = 'flex';
    }
  }

  hideNotificationBadge(navId) {
    const item = document.querySelector(`[data-nav-id="${navId}"]`);
    if (item) {
      const badge = item.querySelector('.nav-badge');
      if (badge) {
        badge.style.display = 'none';
      }
    }
  }

  addMenuItem(config) {
    const item = document.createElement('li');
    item.className = 'nav-item';
    item.dataset.navId = config.id;
    
    item.innerHTML = `
      <a href="${config.href || '#'}" class="nav-link">
        <div class="nav-icon">
          ${config.icon}
        </div>
        <span class="nav-text">${config.text}</span>
        ${config.badge ? `<span class="nav-badge">${config.badge}</span>` : ''}
      </a>
    `;
    
    const navList = this.sidebar?.querySelector('.nav-list');
    if (navList) {
      navList.appendChild(item);
      this.navItems.push(item);
      this.setupNavItem(item);
    }
  }

  removeMenuItem(navId) {
    const item = document.querySelector(`[data-nav-id="${navId}"]`);
    if (item) {
      item.remove();
      this.navItems = this.navItems.filter(navItem => navItem !== item);
    }
  }
}

// Estilos adicionales para efectos dinámicos
const additionalStyles = `
.nav-tooltip {
  position: absolute;
  left: calc(100% + 15px);
  top: 50%;
  transform: translateY(-50%);
  background: rgba(0, 0, 0, 0.9);
  backdrop-filter: blur(10px);
  color: var(--white);
  padding: 8px 12px;
  border-radius: var(--border-radius);
  font-size: 12px;
  font-weight: 500;
  white-space: nowrap;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  z-index: 1000;
  border: 1px solid rgba(0, 255, 102, 0.3);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.nav-tooltip::before {
  content: '';
  position: absolute;
  right: 100%;
  top: 50%;
  transform: translateY(-50%);
  border: 6px solid transparent;
  border-right-color: rgba(0, 0, 0, 0.9);
}

.nav-tooltip.show,
.nav-tooltip.hover-mode {
  opacity: 1;
  visibility: visible;
  transform: translateY(-50%) translateX(5px);
}

.nav-item.highlighted {
  animation: highlightPulse 2s ease-in-out;
}

@keyframes highlightPulse {
  0%, 100% {
    background: transparent;
    transform: scale(1);
  }
  50% {
    background: rgba(0, 255, 102, 0.1);
    transform: scale(1.02);
  }
}

.nav-badge {
  position: absolute;
  top: 8px;
  right: 8px;
  background: var(--accent-red);
  color: var(--white);
  font-size: 10px;
  font-weight: 600;
  padding: 2px 6px;
  border-radius: 10px;
  min-width: 16px;
  height: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  animation: badgePulse 2s infinite;
}

@keyframes badgePulse {
  0%, 100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.1);
  }
}

.nav-link.loading {
  position: relative;
  pointer-events: none;
}

.nav-link.loading::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(
    90deg,
    transparent 0%,
    rgba(0, 255, 102, 0.1) 50%,
    transparent 100%
  );
  animation: loadingSlide 1.5s infinite;
}

@keyframes loadingSlide {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: translateX(100%);
  }
}

.sidebar-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(5px);
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
  z-index: 998;
}

.sidebar-overlay.show {
  opacity: 1;
  visibility: visible;
}

@media (max-width: 768px) {
  .nav-tooltip {
    display: none !important;
  }
  
  .main-sidebar {
    transform: translateX(-100%);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
  
  .main-sidebar.show {
    transform: translateX(0);
  }
  
  .nav-submenu {
    max-height: 0;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
  
  .nav-item.menu-open .nav-submenu {
    max-height: 500px;
  }
}

.main-sidebar.collapsed .nav-submenu {
  max-height: 0;
  overflow: hidden;
}

.main-sidebar.collapsed.hovered .nav-submenu {
  max-height: none;
  overflow: visible;
}
`;

// Inyectar estilos adicionales
const styleSheet = document.createElement("style");
styleSheet.textContent = additionalStyles;
document.head.appendChild(styleSheet);

// Inicializar cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
  new SidebarManager();
});

// Exportar para uso global
window.SidebarManager = SidebarManager;
