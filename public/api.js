/**
 * University Schedule Management System
 * AJAX Request Handler with Modern UI Notifications
 */

class ScheduleAPI {
    constructor() {
        this.baseUrl = '/api';
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        this.setupInterceptors();
    }

    /**
     * Setup CSRF and Error Interceptors
     */
    setupInterceptors() {
        // Setup default headers
        fetch.defaultHeaders = {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': this.csrfToken,
            'Accept': 'application/json',
        };
    }

    /**
     * Internal API Request Method
     */
    async request(method, endpoint, data = null, role = null) {
        const url = role 
            ? `${this.baseUrl}/${role}${endpoint}`
            : `${this.baseUrl}${endpoint}`;

        const options = {
            method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.csrfToken,
                'Accept': 'application/json',
            },
        };

        if (data && (method === 'POST' || method === 'PUT' || method === 'PATCH')) {
            options.body = JSON.stringify(data);
        }

        try {
            const response = await fetch(url, options);
            const result = await response.json();

            if (!response.ok) {
                this.handleError(result);
                return null;
            }

            return result;
        } catch (error) {
            this.showNotification('Error', error.message, 'error');
            return null;
        }
    }

    /**
     * Handle API Errors
     */
    handleError(response) {
        if (response.errors) {
            Object.keys(response.errors).forEach(field => {
                const message = Array.isArray(response.errors[field])
                    ? response.errors[field][0]
                    : response.errors[field];
                this.showFieldError(field, message);
            });
        } else {
            this.showNotification('Error', response.message || 'An error occurred', 'error');
        }
    }

    /**
     * Show field validation error
     */
    showFieldError(field, message) {
        const input = document.querySelector(`[name="${field}"]`);
        if (input) {
            input.classList.add('is-invalid');
            const feedback = input.nextElementSibling;
            if (feedback?.classList.contains('invalid-feedback')) {
                feedback.textContent = message;
            } else {
                const div = document.createElement('div');
                div.className = 'invalid-feedback d-block';
                div.textContent = message;
                input.parentNode.appendChild(div);
            }
        }
    }

    /**
     * Clear field errors
     */
    clearFieldErrors() {
        document.querySelectorAll('.form-control.is-invalid').forEach(input => {
            input.classList.remove('is-invalid');
        });
    }

    /**
     * Show Notification
     */
    showNotification(title, message, type = 'success', duration = 5000) {
        const container = document.getElementById('notifications-container') || this.createNotificationContainer();
        
        const notification = document.createElement('div');
        notification.className = `alert alert-${this.getAlertType(type)} alert-dismissible fade show notification-toast`;
        notification.role = 'alert';
        notification.innerHTML = `
            <div class="d-flex align-items-start gap-2">
                <i class="bi bi-${this.getIcon(type)} flex-shrink-0 mt-1"></i>
                <div>
                    <strong>${title}</strong>
                    <p class="mb-0 small mt-1">${message}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        container.appendChild(notification);

        // Auto remove
        if (duration > 0) {
            setTimeout(() => {
                notification.remove();
            }, duration);
        }

        return notification;
    }

    /**
     * Create notification container if not exists
     */
    createNotificationContainer() {
        const container = document.createElement('div');
        container.id = 'notifications-container';
        container.className = 'notifications-container';
        document.body.appendChild(container);
        
        const style = document.createElement('style');
        style.textContent = `
            .notifications-container {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                max-width: 400px;
                gap: 10px;
                display: flex;
                flex-direction: column;
            }
            .notification-toast {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                animation: slideIn 0.3s ease-out;
                min-width: 300px;
            }
            @keyframes slideIn {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @media (max-width: 576px) {
                .notifications-container {
                    right: 10px;
                    left: 10px;
                    max-width: none;
                }
                .notification-toast {
                    min-width: auto;
                }
            }
        `;
        document.head.appendChild(style);
        
        return container;
    }

    /**
     * Get Alert Type for Bootstrap
     */
    getAlertType(type) {
        const types = {
            'success': 'success',
            'error': 'danger',
            'warning': 'warning',
            'info': 'info',
        };
        return types[type] || 'info';
    }

    /**
     * Get Icon for Notification
     */
    getIcon(type) {
        const icons = {
            'success': 'check-circle-fill',
            'error': 'exclamation-circle-fill',
            'warning': 'exclamation-triangle-fill',
            'info': 'info-circle-fill',
        };
        return icons[type] || 'info-circle-fill';
    }

    // ═══════════════════════════════════════════════════════════════════
    // ADMIN APIs
    // ═══════════════════════════════════════════════════════════════════

    /**
     * Doctors APIs
     */
    async getDoctors(page = 1, search = '', per_page = 15) {
        return this.request('GET', `/admin/doctors?page=${page}&search=${search}&per_page=${per_page}`);
    }

    async getDoctor(id) {
        return this.request('GET', `/admin/doctors/${id}`);
    }

    async createDoctor(data) {
        return this.request('POST', '/admin/doctors', data);
    }

    async updateDoctor(id, data) {
        return this.request('PUT', `/admin/doctors/${id}`, data);
    }

    async deleteDoctor(id) {
        return this.request('DELETE', `/admin/doctors/${id}`);
    }

    async bulkDeleteDoctors(ids) {
        return this.request('POST', '/admin/doctors/bulk-delete', { ids });
    }

    /**
     * Halls APIs
     */
    async getHalls(page = 1, search = '', per_page = 15) {
        return this.request('GET', `/admin/halls?page=${page}&search=${search}&per_page=${per_page}`);
    }

    async getHall(id) {
        return this.request('GET', `/admin/halls/${id}`);
    }

    async createHall(data) {
        return this.request('POST', '/admin/halls', data);
    }

    async updateHall(id, data) {
        return this.request('PUT', `/admin/halls/${id}`, data);
    }

    async deleteHall(id) {
        return this.request('DELETE', `/admin/halls/${id}`);
    }

    async bulkDeleteHalls(ids) {
        return this.request('POST', '/admin/halls/bulk-delete', { ids });
    }

    /**
     * Subjects APIs
     */
    async getSubjects(page = 1, search = '', per_page = 15) {
        return this.request('GET', `/admin/subjects?page=${page}&search=${search}&per_page=${per_page}`);
    }

    async getSubject(id) {
        return this.request('GET', `/admin/subjects/${id}`);
    }

    async createSubject(data) {
        return this.request('POST', '/admin/subjects', data);
    }

    async updateSubject(id, data) {
        return this.request('PUT', `/admin/subjects/${id}`, data);
    }

    async deleteSubject(id) {
        return this.request('DELETE', `/admin/subjects/${id}`);
    }

    async bulkDeleteSubjects(ids) {
        return this.request('POST', '/admin/subjects/bulk-delete', { ids });
    }

    /**
     * Student Groups APIs
     */
    async getStudentGroups(page = 1, search = '', per_page = 15) {
        return this.request('GET', `/admin/student-groups?page=${page}&search=${search}&per_page=${per_page}`);
    }

    async getStudentGroup(id) {
        return this.request('GET', `/admin/student-groups/${id}`);
    }

    async createStudentGroup(data) {
        return this.request('POST', '/admin/student-groups', data);
    }

    async updateStudentGroup(id, data) {
        return this.request('PUT', `/admin/student-groups/${id}`, data);
    }

    async deleteStudentGroup(id) {
        return this.request('DELETE', `/admin/student-groups/${id}`);
    }

    async bulkDeleteStudentGroups(ids) {
        return this.request('POST', '/admin/student-groups/bulk-delete', { ids });
    }

    /**
     * Schedules APIs
     */
    async getSchedules(page = 1, search = '', per_page = 15) {
        return this.request('GET', `/admin/schedules?page=${page}&search=${search}&per_page=${per_page}`);
    }

    async getSchedule(id) {
        return this.request('GET', `/admin/schedules/${id}`);
    }

    async createSchedule(data) {
        return this.request('POST', '/admin/schedules', data);
    }

    async updateSchedule(id, data) {
        return this.request('PUT', `/admin/schedules/${id}`, data);
    }

    async deleteSchedule(id) {
        return this.request('DELETE', `/admin/schedules/${id}`);
    }

    async checkScheduleConflicts(data) {
        return this.request('POST', '/admin/schedules/conflicts/check', data);
    }

    async bulkDeleteSchedules(ids) {
        return this.request('POST', '/admin/schedules/bulk-delete', { ids });
    }

    /**
     * Students APIs
     */
    async getStudents(page = 1, search = '', per_page = 15) {
        return this.request('GET', `/admin/students?page=${page}&search=${search}&per_page=${per_page}`);
    }

    async getStudent(id) {
        return this.request('GET', `/admin/students/${id}`);
    }

    async createStudent(data) {
        return this.request('POST', '/admin/students', data);
    }

    async updateStudent(id, data) {
        return this.request('PUT', `/admin/students/${id}`, data);
    }

    async deleteStudent(id) {
        return this.request('DELETE', `/admin/students/${id}`);
    }

    async bulkDeleteStudents(ids) {
        return this.request('POST', '/admin/students/bulk-delete', { ids });
    }

    /**
     * Dashboard Stats
     */
    async getAdminDashboard() {
        return this.request('GET', '/admin/dashboard');
    }

    // ═══════════════════════════════════════════════════════════════════
    // DOCTOR APIs
    // ═══════════════════════════════════════════════════════════════════

    async getDoctorDashboard() {
        return this.request('GET', '/doctor/dashboard');
    }

    async getDoctorSchedules(page = 1, date = null) {
        let endpoint = `/doctor/schedules?page=${page}`;
        if (date) endpoint += `&date=${date}`;
        return this.request('GET', endpoint);
    }

    async getDoctorSchedule(id) {
        return this.request('GET', `/doctor/schedules/${id}`);
    }

    // ═══════════════════════════════════════════════════════════════════
    // STUDENT APIs
    // ═══════════════════════════════════════════════════════════════════

    async getStudentDashboard() {
        return this.request('GET', '/student/dashboard');
    }

    async getStudentSchedules(page = 1, date = null) {
        let endpoint = `/student/schedules?page=${page}`;
        if (date) endpoint += `&date=${date}`;
        return this.request('GET', endpoint);
    }

    async getStudentSchedule(id) {
        return this.request('GET', `/student/schedules/${id}`);
    }
}

// Create global instance
const api = new ScheduleAPI();
