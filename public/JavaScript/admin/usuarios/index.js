document.addEventListener("DOMContentLoaded", function () {
    // --- SEARCH FUNCTIONALITY (REAL TIME FILTER) ---
    const searchInput = document.getElementById("searchInput");
    let timeout = null;

    if (searchInput) {
        searchInput.addEventListener("input", function () {
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                filterTableRows();
            }, 300); // Reduced debounce for real-time feel
        });

        // Focus effect for parent wrapper
        searchInput.addEventListener("focus", function () {
            const wrapper = this.closest(".search-wrapper");
            if (wrapper) wrapper.classList.add("focused");
        });

        searchInput.addEventListener("blur", function () {
            const wrapper = this.closest(".search-wrapper");
            if (wrapper) wrapper.classList.remove("focused");
        });
    }

    // Function to filter table rows in real-time
    function filterTableRows() {
        const query = searchInput.value.toLowerCase().trim();
        const tableRows = document.querySelectorAll('.dashboard-table tbody tr');
        let visibleCount = 0;

        tableRows.forEach(row => {
            // Skip the "no results" row if it exists
            if (row.querySelector('td[colspan]')) {
                row.style.display = 'none';
                return;
            }

            const userName = row.querySelector('.user-info h4')?.textContent.toLowerCase() || '';
            const userEmail = row.querySelector('.user-info p')?.textContent.toLowerCase() || '';
            
            // Check if query matches name or email
            if (userName.includes(query) || userEmail.includes(query)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Show/hide no results message
        updateNoResultsMessage(visibleCount);
    }

    // Function to show/hide no results message
    function updateNoResultsMessage(visibleCount) {
        const tbody = document.querySelector('.dashboard-table tbody');
        let noResultsRow = tbody.querySelector('.no-results-row');

        if (visibleCount === 0) {
            if (!noResultsRow) {
                noResultsRow = document.createElement('tr');
                noResultsRow.className = 'no-results-row';
                noResultsRow.innerHTML = `
                    <td colspan="6" class="text-center" style="padding: 3rem; color: var(--text-muted);">
                        <i class="fas fa-search" style="font-size: 3rem; opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
                        No se encontraron resultados para tu búsqueda
                    </td>
                `;
                tbody.appendChild(noResultsRow);
            }
            noResultsRow.style.display = '';
        } else {
            if (noResultsRow) {
                noResultsRow.style.display = 'none';
            }
        }
    }

    // --- ENTRIES PER PAGE ---
    const entriesSelect = document.getElementById("entriesSelect");
    if (entriesSelect) {
        entriesSelect.addEventListener("change", function () {
            const entries = this.value;
            const url = new URL(window.location.href);
            url.searchParams.set("per_page", entries);
            url.searchParams.set("page", 1);
            window.location.href = url.toString();
        });
    }

    // --- ROLE FILTER ---
    const roleSelect = document.getElementById("roleSelect");
    if (roleSelect) {
        roleSelect.addEventListener("change", function () {
            const role = this.value;
            const url = new URL(window.location.href);
            if (role) url.searchParams.set("rol", role);
            else url.searchParams.delete("rol");
            url.searchParams.set("page", 1);
            window.location.href = url.toString();
        });
    }

    // --- DELETE BUTTONS WITH DATA-ID ---
    const deleteButtons = document.querySelectorAll('.btn-delete-user');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            confirmDelete(id);
        });
    });

    // --- ADVANCED FILTERS MODAL ---
    const filtersBtn = document.getElementById("openFiltersModal");
    const filtersModal = document.getElementById("filtersModal");
    const closeFiltersBtn = document.getElementById("closeFiltersModal");
    const applyFiltersBtn = document.getElementById("applyFiltersBtn");
    const clearFiltersBtn = document.getElementById("clearFiltersBtn");
    const filtersForm = document.getElementById("filtersForm");

    // Open modal
    if (filtersBtn) {
        filtersBtn.addEventListener("click", function () {
            filtersModal.classList.add("show");
            loadCurrentFilters();
            updateActiveFilters();
        });
    }

    // Close modal
    if (closeFiltersBtn) {
        closeFiltersBtn.addEventListener("click", function () {
            filtersModal.classList.remove("show");
        });
    }

    // Close modal on overlay click
    if (filtersModal) {
        filtersModal.addEventListener("click", function (e) {
            if (e.target === filtersModal) {
                filtersModal.classList.remove("show");
            }
        });
    }

    // Apply filters
    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener("click", function () {
            const url = new URL(window.location.href);
            const formData = new FormData(filtersForm);

            // Reset page to 1
            url.searchParams.set("page", 1);

            // Add form data to URL
            for (let [key, value] of formData.entries()) {
                if (value && value !== "") {
                    url.searchParams.set(key, value);
                } else {
                    url.searchParams.delete(key);
                }
            }

            // Keep existing search and per_page
            const search = document.getElementById("searchInput")?.value;
            const perPage = document.getElementById("entriesSelect")?.value;
            if (search) url.searchParams.set("search", search);
            if (perPage) url.searchParams.set("per_page", perPage);

            window.location.href = url.toString();
        });
    }

    // Clear filters
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener("click", function () {
            const url = new URL(window.location.href);
            
            // Remove all filter parameters
            url.searchParams.delete("cuenta_activa");
            url.searchParams.delete("rol");
            url.searchParams.delete("fecha_desde");
            url.searchParams.delete("fecha_hasta");
            url.searchParams.delete("prompts_min");
            url.searchParams.delete("tiene_acceso");
            url.searchParams.set("page", 1);

            window.location.href = url.toString();
        });
    }

    // Load current filters from URL
    function loadCurrentFilters() {
        const params = new URLSearchParams(window.location.search);
        
        // Set form values from URL
        if (params.has("cuenta_activa")) {
            const select = filtersForm.querySelector('[name="cuenta_activa"]');
            if (select) select.value = params.get("cuenta_activa");
        }
        if (params.has("rol")) {
            const select = filtersForm.querySelector('[name="rol"]');
            if (select) select.value = params.get("rol");
        }
        if (params.has("fecha_desde")) {
            const input = filtersForm.querySelector('[name="fecha_desde"]');
            if (input) input.value = params.get("fecha_desde");
        }
        if (params.has("fecha_hasta")) {
            const input = filtersForm.querySelector('[name="fecha_hasta"]');
            if (input) input.value = params.get("fecha_hasta");
        }
        if (params.has("prompts_min")) {
            const input = filtersForm.querySelector('[name="prompts_min"]');
            if (input) input.value = params.get("prompts_min");
        }
        if (params.has("tiene_acceso")) {
            const select = filtersForm.querySelector('[name="tiene_acceso"]');
            if (select) select.value = params.get("tiene_acceso");
        }
    }

    // Update active filters display
    function updateActiveFilters() {
        const params = new URLSearchParams(window.location.search);
        const activeFiltersList = document.getElementById("activeFiltersList");
        const filtersCount = document.getElementById("filtersCount");
        
        if (!activeFiltersList) return;

        let count = 0;
        let html = "";

        const filterLabels = {
            cuenta_activa: "Estado",
            rol: "Rol",
            fecha_desde: "Desde",
            fecha_hasta: "Hasta",
            prompts_min: "Prompts mín.",
            tiene_acceso: "Último acceso"
        };

        const filterValues = {
            cuenta_activa: { "1": "Activa", "0": "Inactiva" },
            rol: { admin: "Administrador", user: "Usuario", collaborator: "Colaborador", guest: "Invitado" },
            tiene_acceso: { "1": "Con acceso", "0": "Sin acceso" }
        };

        for (let [key, label] of Object.entries(filterLabels)) {
            if (params.has(key) && params.get(key) !== "") {
                count++;
                let value = params.get(key);
                
                // Format value if it's in filterValues
                if (filterValues[key] && filterValues[key][value]) {
                    value = filterValues[key][value];
                }

                html += `
                    <div class="active-filter-tag">
                        <span class="filter-label">${label}:</span>
                        <span class="filter-value">${value}</span>
                    </div>
                `;
            }
        }

        if (count === 0) {
            html = '<p class="no-filters">No hay filtros activos</p>';
        }

        activeFiltersList.innerHTML = html;
        if (filtersCount) filtersCount.textContent = count;
    }
});

// --- SWEETALERT DELETE CONFIRMATION ---
function confirmDelete(id) {
    // Get theme colors if defined globally in blade, otherwise fallback
    const confirmColor =
        typeof swalTheme !== "undefined"
            ? swalTheme.confirmButtonColor
            : "#e11d48";
    const cancelColor =
        typeof swalTheme !== "undefined"
            ? swalTheme.cancelButtonColor
            : "#64748b";
    const bg =
        typeof swalTheme !== "undefined" ? swalTheme.background : "#1e293b";
    const text = typeof swalTheme !== "undefined" ? swalTheme.color : "#f1f5f9";

    Swal.fire({
        title: "¿Estás seguro?",
        text: " Esta acción no se puede deshacer. Se eliminará el usuario y todos sus datos asociados.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: confirmColor,
        cancelButtonColor: cancelColor,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
        background: bg,
        color: text,
        iconColor: confirmColor,
        reverseButtons: true,
        focusCancel: true,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("delete-form-" + id).submit();
        }
    });
}
