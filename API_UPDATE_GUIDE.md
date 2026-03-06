# 🎓 University Schedule Management System - API & AJAX Update

## 📋 التحديثات الرئيسية

### 1️⃣ تحويل النظام للـ APIs

تم تحويل جميع الـ Controllers التقليدية إلى **RESTful APIs** القوية:

#### API Routes المتاحة:

```
POST   /api/admin/doctors           - إضافة دكتور
GET    /api/admin/doctors           - الحصول على قائمة الدكاترة
GET    /api/admin/doctors/{id}      - الحصول على دكتور محدد
PUT    /api/admin/doctors/{id}      - تعديل بيانات الدكتور
DELETE /api/admin/doctors/{id}      - حذف الدكتور
POST   /api/admin/doctors/bulk-delete - حذف دكاترة متعددة
```

نفس النمط يتكرر مع:
- `halls` (القاعات)
- `subjects` (المواد)
- `student-groups` (مجموعات الطلاب)
- `schedules` (الجداول)
- `students` (الطلاب)

#### Doctor & Student APIs:

```
GET /api/doctor/dashboard          - لوحة تحكم الدكتور
GET /api/doctor/schedules          - جداول الدكتور
GET /api/doctor/schedules/{id}     - جدول محدد للدكتور

GET /api/student/dashboard         - لوحة تحكم الطالب
GET /api/student/schedules         - جداول الطالب
GET /api/student/schedules/{id}    - جدول محدد للطالب
```

---

### 2️⃣ JavaScript AJAX Library

تم إنشاء مكتبة AJAX حديثة وسهلة الاستخدام:

#### ملف: `resources/js/api.js`

```javascript
// استخدام بسيط جداً:
const api = new ScheduleAPI();

// الحصول على الدكاترة
const response = await api.getDoctors(page, search, perPage);

// إضافة دكتور
await api.createDoctor({
    name: 'أحمد محمد',
    email: 'ahmed@example.com',
    password: 'password123',
    password_confirmation: 'password123',
    department: 'الهندسة',
    phone: '01234567890'
});

// تعديل دكتور
await api.updateDoctor(doctorId, updatedData);

// حذف دكتور
await api.deleteDoctor(doctorId);

// إشعارات جميلة
api.showNotification('نجاح', 'تم الحفظ بنجاح', 'success');
api.showNotification('خطأ', 'حدث خطأ', 'error');
```

---

### 3️⃣ DataTable Dynamic Component

تم إنشاء مكون DataTable ديناميكي:

#### ملف: `resources/js/datatable.js`

```javascript
const table = new DataTable({
    containerId: 'data-table-container',
    apiMethod: api.getDoctors.bind(api),
    columns: [
        { key: 'name', type: 'text' },
        { key: 'user.email', type: 'text' },
        { key: 'department', type: 'text' },
    ],
    actions: {
        edit: editFunction,
        delete: deleteFunction,
        view: viewFunction,
    },
    perPage: 15,
});

// تحديث الجدول
table.refresh();

// الحصول على العناصر المحددة
const selected = table.getSelectedItems();
```

---

### 4️⃣ نظام إشعارات محسّن

#### المميزات:
- ✅ إشعارات جميلة بتصميم حديث
- 🎨 تأثيرات انسيابية (Slide-in/Slide-out)
- 📱 متجاوب مع الهاتف
- 🎯 تصنيفات مختلفة (success, error, warning, info)
- ⌨️ دعم الكلوز التلقائي

#### الاستخدام:
```javascript
api.showNotification('العنوان', 'الرسالة', 'success');
api.showNotification('خطأ', 'حدث خطأ في النظام', 'error', 5000);
api.showNotification('تحذير', 'هناك تنبيهات', 'warning', 0);
```

---

### 5️⃣ تصاميم جديدة للدكاترة والطلاب

#### لوحة تحكم الدكتور:
- 📊 إحصائيات متقدمة
- 📅 جدول اليوم في الوقت الفعلي
- ⏰ عرض الحصة القادمة مباشرة
- 📋 قائمة الجداول مع الموجة والمراجعة

#### لوحة تحكم الطالب:
- 👤 بطاقة ترحيب شخصية
- 📚 عرض الحصص في الوقت الفعلي
- 🔔 تنبيهات الحصص القادمة
- 📱 تصميم متجاوب كاملاً

---

### 6️⃣ آليات الحماية والتحقق

#### الخصائص الأمنية:
```php
// Token CSRF تلقائياً على جميع الطلبات
// التحقق من صلاحيات المستخدم (role:admin, role:doctor, role:student)
// معالجة أخطاء الـ Validation تلقائياً
// Pagination آمنة وفعالة
```

---

### 7️⃣ CSS محسّن

#### ملف: `resources/css/notifications.css`

المميزات:
- 🎨 تصاميم حديثة للـ Bootstrap 5
- 🌈 تدرجات لونية جميلة
- ✨ تأثيرات انسيابية
- 📱 تصميم متجاوب كامل
- ♿ إمكانية الوصول

---

## 🚀 كيفية البدء

### 1. تثبيت المكتبات:
```bash
cd university-schedule
npm install
composer install
```

### 2. تشغيل Vite للـ Asset Compilation:
```bash
npm run dev
```

### 3. تشغيل السيرفر:
```bash
php artisan serve
```

---

## 📚 أمثلة الاستخدام

### مثال 1: جدول الدكاترة مع AJAX

```blade
<script>
const api = new ScheduleAPI();

async function loadDoctors() {
    const response = await api.getDoctors(1, '', 15);
    if (response) {
        renderTable(response.data);
    }
}

async function editDoctor(id) {
    const doctor = await api.getDoctor(id);
    // عرض form التعديل مع البيانات
}

async function saveDoctor(data) {
    const response = await api.createDoctor(data);
    if (response) {
        api.showNotification('نجاح', 'تم الحفظ بنجاح', 'success');
        loadDoctors();
    }
}
</script>
```

### مثال 2: جدول الجداول مع معالجة التضاربات

```javascript
async function createSchedule(formData) {
    // تحقق من التضاربات أولاً
    const conflict = await api.checkScheduleConflicts(formData);
    
    if (conflict.has_conflict) {
        api.showNotification('تحذير', conflict.conflict_message, 'warning');
        return;
    }
    
    // أنشئ الجدول
    const response = await api.createSchedule(formData);
    if (response) {
        api.showNotification('نجاح', 'تم إنشاء الجدول', 'success');
    }
}
```

### مثال 3: حذف متعدد

```javascript
async function bulkDelete() {
    const table = new DataTable(options);
    const selected = table.getSelectedItems();
    
    if (!confirm(`حذف ${selected.length} عنصر؟`)) return;
    
    const ids = selected.map(item => item.id);
    const response = await api.bulkDeleteDoctors(ids);
    
    if (response) {
        api.showNotification('تم', 'تم الحذف بنجاح', 'success');
        table.refresh();
    }
}
```

---

## 🔧 التكوين والإعدادات

### توسيع API:

لإضافة API جديد، اتبع الخطوات:

1. **أنشئ Controller:**
```php
namespace App\Http\Controllers\Api\Admin;

class MyApiController extends BaseApiController {
    public function index() {
        $data = MyModel::paginate(15);
        return $this->successPaginated($data);
    }
}
```

2. **أضف Route:**
```php
Route::apiResource('my-resource', Api\Admin\MyApiController::class);
```

3. **أضف Methods في Library:**
```javascript
class ScheduleAPI {
    async getMyResources(page = 1) {
        return this.request('GET', `/admin/my-resource?page=${page}`);
    }
}
```

---

## 📊 Response Format

جميع الـ APIs تعيد في نفس الصيغة:

### نجاح:
```json
{
    "success": true,
    "message": "تم بنجاح",
    "code": 200,
    "data": { /* البيانات */ }
}
```

### مع Pagination:
```json
{
    "success": true,
    "message": "تم بنجاح",
    "code": 200,
    "data": [ /* القائمة */ ],
    "pagination": {
        "total": 100,
        "per_page": 15,
        "current_page": 1,
        "last_page": 7,
        "from": 1,
        "to": 15,
        "has_more": true
    }
}
```

### خطأ:
```json
{
    "success": false,
    "message": "رسالة الخطأ",
    "code": 400,
    "errors": {
        "field": ["الخطأ في الحقل"]
    }
}
```

---

## 🎯 الميزات المستقبلية

- [ ] Real-time Notifications باستخدام WebSockets
- [ ] نظام الإشعارات بالبريد الإلكتروني
- [ ] تصدير البيانات (PDF, Excel)
- [ ] رسوم بيانية متقدمة
- [ ] نظام الملاحظات والتعليقات
- [ ] سجل الأنشطة (Audit Log)

---

## 📝 ملاحظات مهمة

1. **Authentication:** استخدم `auth:sanctum` middleware
2. **CORS:** تأكد من تكوين CORS في `config/cors.php`
3. **Rate Limiting:** استخدم throttle middleware للحماية
4. **Caching:** استخدم Redis للـ caching الأداء

---

## 🤝 المساهمة

للمساهمة في المشروع:

```bash
git checkout -b feature/your-feature
# اكتب كودك
git push origin feature/your-feature
```

---

## 📧 الدعم

للمساعدة والدعم:
- 📧 البريد: support@university-schedule.com
- 🐛 الأخطاء: GitHub Issues
- 💬 النقاشات: GitHub Discussions

---

**تم التحديث في:** مارس 2026  
**الإصدار:** 2.0.0  
**الحالة:** ✅ جاهز للإنتاج
