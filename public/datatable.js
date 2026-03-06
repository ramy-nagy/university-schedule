/**
 * Dynamic Table Management with AJAX
 */

class DataTable {
    constructor(options = {}) {
        this.container = document.getElementById(options.containerId || 'data-table-container');
        this.apiMethod = options.apiMethod;
        this.columns = options.columns || [];
        this.actions = options.actions || {};
        this.currentPage = 1;
        this.currentSearch = '';
        this.perPage = options.perPage || 15;
        this.showCheckboxes = options.showCheckboxes !== false;

        this.init();
    }

    init() {
        if (!this.container) return;

        // Setup event listeners
        this.setupSearchListener();
        this.setupPaginationListener();
        this.setupCheckboxListener();

        // Load initial data
        this.load();
    }

    /**
     * Load table data
     */
    async load() {
        if (!this.apiMethod) return;

        const response = await this.apiMethod(this.currentPage, this.currentSearch, this.perPage);
        if (!response) return;

        this.render(response);
    }

    /**
     * Render table
     */
    render(data) {
        const tbody = this.container.querySelector('tbody');
        if (!tbody) return;

        // Clear existing rows
        tbody.innerHTML = '';

        if (!data.data || data.data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="${this.showCheckboxes ? this.columns.length + 2 : this.columns.length + 1}" 
                        class="text-center text-muted py-4">
                        <i class="bi bi-inbox" style="font-size: 2rem;"></i><br>
                        <span class="mt-2 d-block">لا توجد بيانات</span>
                    </td>
                </tr>
            `;
            this.updatePagination(data.pagination);
            return;
        }

        // Render rows
        data.data.forEach((item, index) => {
            const row = this.createRow(item, index, data);
            tbody.appendChild(row);
        });

        // Update pagination
        this.updatePagination(data.pagination);
    }

    /**
     * Create table row
     */
    createRow(item, index, data) {
        const row = document.createElement('tr');

        let html = '';

        // Checkbox column
        if (this.showCheckboxes) {
            html += `
                <td>
                    <input type="checkbox" class="form-check-input select-row-checkbox" 
                           value="${item.id}" data-item='${JSON.stringify(item)}'>
                </td>
            `;
        }

        // Index column
        html += `<td>${((data.pagination.current_page - 1) * data.pagination.per_page) + (index + 1)}</td>`;

        // Data columns
        this.columns.forEach(column => {
            const value = this.getNestedValue(item, column.key);
            const formatted = column.format 
                ? column.format(value, item) 
                : this.formatValue(value, column.type);
            
            html += `<td>${formatted}</td>`;
        });

        // Actions column
        if (Object.keys(this.actions).length > 0) {
            let actionsHtml = '<td>';

            if (this.actions.edit) {
                actionsHtml += `
                    <button type="button" class="btn btn-sm btn-outline-warning edit-btn" 
                            data-id="${item.id}" title="تعديل">
                        <i class="bi bi-pencil"></i>
                    </button>
                `;
            }

            if (this.actions.delete) {
                actionsHtml += `
                    <button type="button" class="btn btn-sm btn-outline-danger delete-btn" 
                            data-id="${item.id}" title="حذف">
                        <i class="bi bi-trash"></i>
                    </button>
                `;
            }

            if (this.actions.view) {
                actionsHtml += `
                    <button type="button" class="btn btn-sm btn-outline-info view-btn" 
                            data-id="${item.id}" title="عرض">
                        <i class="bi bi-eye"></i>
                    </button>
                `;
            }

            actionsHtml += '</td>';
            html += actionsHtml;
        }

        row.innerHTML = html;

        // Attach action listeners
        if (this.actions.edit) {
            const editBtn = row.querySelector('.edit-btn');
            if (editBtn) {
                editBtn.addEventListener('click', () => this.actions.edit(item));
            }
        }

        if (this.actions.delete) {
            const deleteBtn = row.querySelector('.delete-btn');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', () => this.actions.delete(item));
            }
        }

        if (this.actions.view) {
            const viewBtn = row.querySelector('.view-btn');
            if (viewBtn) {
                viewBtn.addEventListener('click', () => this.actions.view(item));
            }
        }

        return row;
    }

    /**
     * Get nested object value
     */
    getNestedValue(obj, path) {
        return path.split('.').reduce((current, prop) => current?.[prop], obj);
    }

    /**
     * Format value based on type
     */
    formatValue(value, type = 'text') {
        if (value === null || value === undefined) {
            return '<span class="text-muted">—</span>';
        }

        switch (type) {
            case 'badge':
                return `<span class="badge bg-primary">${value}</span>`;
            case 'date':
                return new Date(value).toLocaleDateString('ar-SA');
            case 'time':
                return new Date(`2000-01-01 ${value}`).toLocaleTimeString('ar-SA', {
                    hour: '2-digit',
                    minute: '2-digit',
                });
            case 'boolean':
                return value 
                    ? '<span class="badge bg-success">نعم</span>'
                    : '<span class="badge bg-danger">لا</span>';
            default:
                return value;
        }
    }

    /**
     * Update pagination
     */
    updatePagination(pagination) {
        const pagination_container = document.getElementById(this.container.id + '-pagination');
        if (!pagination_container) return;

        let html = `
            <nav>
                <ul class="pagination justify-content-center">
        `;

        // Previous button
        if (pagination.current_page > 1) {
            html += `
                <li class="page-item">
                    <button type="button" class="page-link" data-page="1">
                        <i class="bi bi-skip-backward"></i>
                    </button>
                </li>
                <li class="page-item">
                    <button type="button" class="page-link" data-page="${pagination.current_page - 1}">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </li>
            `;
        }

        // Page numbers
        const maxPages = 5;
        const startPage = Math.max(1, pagination.current_page - Math.floor(maxPages / 2));
        const endPage = Math.min(pagination.last_page, startPage + maxPages - 1);

        for (let i = startPage; i <= endPage; i++) {
            html += `
                <li class="page-item ${i === pagination.current_page ? 'active' : ''}">
                    <button type="button" class="page-link" data-page="${i}">${i}</button>
                </li>
            `;
        }

        // Next button
        if (pagination.current_page < pagination.last_page) {
            html += `
                <li class="page-item">
                    <button type="button" class="page-link" data-page="${pagination.current_page + 1}">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                </li>
                <li class="page-item">
                    <button type="button" class="page-link" data-page="${pagination.last_page}">
                        <i class="bi bi-skip-forward"></i>
                    </button>
                </li>
            `;
        }

        html += `</ul></nav>`;

        pagination_container.innerHTML = html;

        // Attach listeners
        pagination_container.querySelectorAll('[data-page]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.currentPage = parseInt(btn.dataset.page);
                this.load();
            });
        });
    }

    /**
     * Setup search listener
     */
    setupSearchListener() {
        const searchInput = this.container.parentElement?.querySelector('[data-search-input]');
        if (!searchInput) return;

        let timeout;
        searchInput.addEventListener('input', (e) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                this.currentSearch = e.target.value;
                this.currentPage = 1;
                this.load();
            }, 300);
        });
    }

    /**
     * Setup pagination listener
     */
    setupPaginationListener() {
        // Handled in updatePagination
    }

    /**
     * Setup checkbox listener
     */
    setupCheckboxListener() {
        const selectAllCheckbox = this.container.parentElement?.querySelector('[data-select-all]');
        if (!selectAllCheckbox) return;

        selectAllCheckbox.addEventListener('change', (e) => {
            this.container.querySelectorAll('.select-row-checkbox').forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
        });
    }

    /**
     * Get selected items
     */
    getSelectedItems() {
        const checkboxes = this.container.querySelectorAll('.select-row-checkbox:checked');
        const items = [];

        checkboxes.forEach(checkbox => {
            items.push({
                id: parseInt(checkbox.value),
                data: JSON.parse(checkbox.dataset.item)
            });
        });

        return items;
    }

    /**
     * Refresh table
     */
    refresh() {
        this.currentPage = 1;
        this.currentSearch = '';
        this.load();
    }
}
