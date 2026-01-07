/**
 * Filtros y búsqueda para Usuarios
 */

class UsuariosFilters {
    constructor(config) {
        this.baseUrl = config.baseUrl;
        this.contentContainer = document.querySelector(config.contentContainer);
        this.currentFilters = {};
        this.currentSort = { field: "created_at", order: "desc" };
        this.currentPage = 1;
        this.perPage = 10;
        this.searchTimeout = null;

        this.init();
    }

    init() {
        this.bindEvents();
        this.loadInitialData();
    }

    bindEvents() {
        // Búsqueda en tiempo real
        const searchInput = document.getElementById("searchUser");
        if (searchInput) {
            searchInput.addEventListener("input", (e) => {
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(() => {
                    this.handleSearch(e.target.value);
                }, 300);
            });
        }

        // Botón de filtros (Toggle del panel)
        const filterBtn = document.getElementById("btnFilter");
        const filterPanel = document.getElementById("filterPanel");
        if (filterBtn && filterPanel) {
            filterBtn.addEventListener("click", () => {
                filterPanel.classList.toggle("active");
                filterBtn.classList.toggle("active");
            });
        }

        // Headers de ordenamiento
        this.bindSortHeaders();

        // Filtros del panel rápido
        this.bindQuickFilters();

        // Exportar datos
        const exportBtn = document.getElementById("btnExport");
        if (exportBtn) {
            exportBtn.addEventListener("click", () => {
                this.exportData();
            });
        }
    }

    bindSortHeaders() {
        const sortHeaders = document.querySelectorAll(".sortable-header");

        sortHeaders.forEach((header) => {
            // Remover listeners anteriores para evitar duplicados si se recarga el HTML
            const newHeader = header.cloneNode(true);
            header.parentNode.replaceChild(newHeader, header);

            newHeader.addEventListener("click", () => {
                const field = newHeader.getAttribute("data-sort");

                if (this.currentSort.field === field) {
                    this.currentSort.order =
                        this.currentSort.order === "asc" ? "desc" : "asc";
                } else {
                    this.currentSort.field = field;
                    this.currentSort.order = "asc";
                }

                this.updateSortUI();
                this.loadData();
            });
        });
    }

    bindQuickFilters() {
        const quickFilters = document.querySelectorAll(
            ".filter-panel .filter-input, .filter-panel .filter-select"
        );

        quickFilters.forEach((filter) => {
            filter.addEventListener("change", () => {
                this.applyQuickFilters();
            });
        });
    }

    handleSearch(searchTerm) {
        if (searchTerm.length === 0 || searchTerm.length >= 2) {
            this.currentFilters.search = searchTerm;
            this.currentPage = 1;
            this.loadData();
        }
    }

    applyQuickFilters() {
        const panel = document.querySelector(".filter-panel");
        if (!panel) return;

        const inputs = panel.querySelectorAll(".filter-input, .filter-select");

        inputs.forEach((input) => {
            const name = input.name;
            const value = input.value;

            if (value && value.trim() !== "") {
                this.currentFilters[name] = value.trim();
            } else {
                delete this.currentFilters[name];
            }
        });

        this.currentPage = 1;
        this.loadData();
        this.updateFiltersIndicator();
    }

    updateFiltersIndicator() {
        const filterBtn = document.getElementById("btnFilter");
        if (!filterBtn) return;

        const filterCount = Object.keys(this.currentFilters).filter(
            (key) => key !== "search"
        ).length;

        if (filterCount > 0) {
            filterBtn.classList.add("filters-active");
            filterBtn.setAttribute("data-count", filterCount);
        } else {
            filterBtn.classList.remove("filters-active");
            filterBtn.setAttribute("data-count", "0");
        }
    }

    updateSortUI() {
        const headers = document.querySelectorAll(".sortable-header");

        headers.forEach((header) => {
            header.classList.remove("active", "asc", "desc");

            if (header.getAttribute("data-sort") === this.currentSort.field) {
                header.classList.add("active", this.currentSort.order);
            }
        });
    }

    updatePerPage(value) {
        this.perPage = parseInt(value);
        this.currentPage = 1;
        this.loadData();
    }

    performSearch(term) {
        this.currentFilters.search = term;
        this.currentPage = 1;
        this.loadData();
    }

    async loadData() {
        try {
            this.showLoading();

            const params = new URLSearchParams();

            // Agregar filtros
            Object.entries(this.currentFilters).forEach(([key, value]) => {
                params.append(key, value);
            });

            // Agregar ordenamiento
            params.append("sort", this.currentSort.field);
            params.append("order", this.currentSort.order);

            // Agregar paginación
            params.append("page", this.currentPage);
            params.append("per_page", this.perPage);

            const response = await fetch(
                `${this.baseUrl}?${params.toString()}`,
                {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        Accept: "application/json",
                    },
                }
            );

            if (!response.ok) {
                throw new Error("Error al cargar los datos");
            }

            const data = await response.json();

            this.updateTable(data.html);
            this.updatePagination(data.pagination, data.showing);
        } catch (error) {
            console.error("Error:", error);
            // this.showError('Error al cargar los usuarios');
        } finally {
            this.hideLoading();
        }
    }

    loadInitialData() {
        // Cargar filtros desde URL si existen
        const urlParams = new URLSearchParams(window.location.search);

        urlParams.forEach((value, key) => {
            if (["sort", "order", "page", "per_page"].includes(key)) return;
            this.currentFilters[key] = value;
        });

        this.updateFiltersIndicator();
    }

    updateTable(html) {
        if (this.contentContainer) {
            this.contentContainer.innerHTML = html;
            // Re-bind eventos para nuevos elementos
            this.bindSortHeaders();
        }
    }

    updatePagination(paginationHtml, showing) {
        // La paginación viene dentro del HTML de la tabla en este diseño,
        // pero si estuviera separada, aquí se actualizaría.
        // En nuestro caso, el partial 'table' incluye la paginación al final.
    }

    async exportData() {
        try {
            const params = new URLSearchParams();

            // Agregar filtros actuales
            Object.entries(this.currentFilters).forEach(([key, value]) => {
                params.append(key, value);
            });

            params.append("export", "excel");

            window.open(
                `${this.baseUrl}/export?${params.toString()}`,
                "_blank"
            );
        } catch (error) {
            console.error("Error:", error);
            alert("Error al exportar los datos");
        }
    }

    showLoading() {
        const tableContainer = document.querySelector(".table-container");
        if (tableContainer) {
            tableContainer.classList.add("filters-loading");
        }
    }

    hideLoading() {
        const tableContainer = document.querySelector(".table-container");
        if (tableContainer) {
            tableContainer.classList.remove("filters-loading");
        }
    }
}
