// import './bootstrap';
import './api';
import './datatable';
import '../css/notifications.css';

// Initialize application
document.addEventListener('DOMContentLoaded', () => {
    initializeApp();
});

function initializeApp() {
    // Setup CSRF token in meta tag if not exists
    if (!document.querySelector('meta[name="csrf-token"]')) {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!token) {
            console.warn('CSRF token not found in meta tags');
        }
    }

    // Initialize tooltips and popovers
    initializeBootstrapComponents();

    // Setup form validation
    setupFormValidation();

    // Setup keyboard shortcuts
    setupKeyboardShortcuts();
}

/**
 * Initialize Bootstrap tooltips and popovers
 */
function initializeBootstrapComponents() {
    // Tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(element => {
        new bootstrap.Tooltip(element);
    });

    // Popovers
    document.querySelectorAll('[data-bs-toggle="popover"]').forEach(element => {
        new bootstrap.Popover(element);
    });
}

/**
 * Client-side form validation
 */
function setupFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');

    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                api.showNotification(
                    'تنبيه',
                    'يرجى ملء جميع الحقول المطلوبة',
                    'warning'
                );
            }
            this.classList.add('was-validated');
        });
    });
}

/**
 * Setup keyboard shortcuts
 */
function setupKeyboardShortcuts() {
    document.addEventListener('keydown', (e) => {
        // Ctrl/Cmd + K: Focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const search = document.querySelector('[data-search-input]');
            if (search) search.focus();
        }

        // Escape: Close modals
        if (e.key === 'Escape') {
            const modals = document.querySelectorAll('.modal.show');
            modals.forEach(modal => {
                const bootstrapModal = bootstrap.Modal.getInstance(modal);
                if (bootstrapModal) bootstrapModal.hide();
            });
        }
    });
}

// Export for use in other modules
window.initializeApp = initializeApp;
window.setupFormValidation = setupFormValidation;
