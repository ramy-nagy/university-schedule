
@extends('layouts.admin')
@section('title','الدكاترة')
@section('content')

<div class="container-fluid">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">
            <i class="bi bi-person-badge me-2 text-primary"></i>إدارة الدكاترة
        </h3>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#doctorModal" onclick="openAddDoctorForm()">
            <i class="bi bi-plus-lg me-1"></i>إضافة دكتور جديد
        </button>
    </div>

    {{-- Search & Filter --}}
    <div class="row mb-3">
        <div class="col-md-8">
            <input type="text" class="form-control" placeholder="ابحث عن دكتور..." data-search-input>
        </div>
        <div class="col-md-4">
            <div class="btn-group w-100" role="group">
                <button type="button" class="btn btn-outline-secondary" onclick="doctorTable.refresh()">
                    <i class="bi bi-arrow-clockwise"></i> تحديث
                </button>
                <button type="button" class="btn btn-outline-danger" id="bulk-delete-btn" style="display: none;">
                    <i class="bi bi-trash"></i> حذف المحدد
                </button>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="doctors-table">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;">
                                <input type="checkbox" class="form-check-input" data-select-all>
                            </th>
                            <th>#</th>
                            <th style="width: 200px;">الاسم</th>
                            <th style="width: 250px;">البريد الإلكتروني</th>
                            <th style="width: 150px;">القسم</th>
                            <th style="width: 150px;">التليفون</th>
                            <th style="width: 100px;">الجداول</th>
                            <th style="width: 150px;">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="doctors-tbody">
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">جاري التحميل...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light" id="doctors-pagination"></div>
    </div>
</div>

{{-- Add/Edit Modal --}}
<div class="modal fade" id="doctorModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="doctorModalTitle">إضافة دكتور</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="doctorForm">
                <div class="modal-body">
                    <input type="hidden" id="doctorId">

                    <div class="mb-3">
                        <label class="form-label">الاسم بالكامل</label>
                        <input type="text" class="form-control" name="name" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-control" name="email" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">كلمة المرور</label>
                        <input type="password" class="form-control" name="password" id="passwordInput" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">تأكيد كلمة المرور</label>
                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">القسم</label>
                        <input type="text" class="form-control" name="department">
                    </div>

                    <div class="mb-0">
                        <label class="form-label">رقم التليفون</label>
                        <input type="tel" class="form-control" name="phone">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const api = new ScheduleAPI();
    let doctorTable = null;
    let currentEditingId = null;

    document.addEventListener('DOMContentLoaded', () => {
        initializeDoctorTable();
        setupDoctorFormHandler();
        setupBulkActions();
    });

    function initializeDoctorTable() {
        const container = document.getElementById('doctors-table');
        container.parentElement.id = 'data-table-container';

        doctorTable = new DataTable({
            containerId: 'data-table-container',
            apiMethod: api.getDoctors.bind(api),
            columns: [
                { key: 'name', type: 'text' },
                { key: 'user.email', type: 'text' },
                { key: 'department', type: 'text' },
                { key: 'phone', type: 'text' },
                { key: 'schedules_count', type: 'badge' },
            ],
            actions: {
                edit: editDoctor,
                delete: deleteDoctor,
            },
            showCheckboxes: true,
        });
    }

    function setupDoctorFormHandler() {
        const form = document.getElementById('doctorForm');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            api.clearFieldErrors();

            const formData = new FormData(form);
            const data = Object.fromEntries(formData);

            const doctorId = document.getElementById('doctorId').value;

            let response;
            if (doctorId) {
                response = await api.updateDoctor(doctorId, data);
            } else {
                response = await api.createDoctor(data);
            }

            if (response) {
                bootstrap.Modal.getInstance(document.getElementById('doctorModal')).hide();
                form.reset();
                doctorTable.refresh();
                api.showNotification('نجاح', 'تم حفظ البيانات بنجاح', 'success');
            }
        });
    }

    function openAddDoctorForm() {
        currentEditingId = null;
        document.getElementById('doctorId').value = '';
        document.getElementById('doctorModalTitle').textContent = 'إضافة دكتور جديد';
        document.getElementById('passwordInput').required = true;
        document.getElementById('doctorForm').reset();
        document.getElementById('doctorForm').classList.remove('was-validated');
    }

    async function editDoctor(doctor) {
        currentEditingId = doctor.id;
        document.getElementById('doctorId').value = doctor.id;
        document.getElementById('doctorModalTitle').textContent = 'تعديل بيانات الدكتور';
        document.getElementById('passwordInput').required = false;

        document.querySelector('input[name="name"]').value = doctor.name;
        document.querySelector('input[name="email"]').value = doctor.user.email;
        document.querySelector('input[name="department"]').value = doctor.department || '';
        document.querySelector('input[name="phone"]').value = doctor.phone || '';

        const modal = new bootstrap.Modal(document.getElementById('doctorModal'));
        modal.show();
    }

    async function deleteDoctor(doctor) {
        if (!confirm(`هل أنت متأكد من حذف الدكتور ${doctor.name} وحسابه؟`)) {
            return;
        }

        const response = await api.deleteDoctor(doctor.id);
        if (response) {
            doctorTable.refresh();
            api.showNotification('تم', 'تم حذف الدكتور بنجاح', 'success');
        }
    }

    function setupBulkActions() {
        document.addEventListener('change', (e) => {
            if (e.target.classList.contains('select-row-checkbox') || e.target.dataset.selectAll) {
                const selected = doctorTable.getSelectedItems();
                const bulkBtn = document.getElementById('bulk-delete-btn');
                bulkBtn.style.display = selected.length > 0 ? 'block' : 'none';
            }
        });

        document.getElementById('bulk-delete-btn')?.addEventListener('click', async () => {
            const selected = doctorTable.getSelectedItems();
            if (!confirm(`هل أنت متأكد من حذف ${selected.length} دكتور؟`)) {
                return;
            }

            const ids = selected.map(item => item.id);
            const response = await api.bulkDeleteDoctors(ids);
            if (response) {
                doctorTable.refresh();
                api.showNotification('تم', 'تم حذف الدكاترة بنجاح', 'success');
            }
        });
    }
</script>

@endsection
