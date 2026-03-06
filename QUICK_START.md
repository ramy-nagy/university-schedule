# 🚀 دليل البدء السريع للـ APIs والـ AJAX

## ✅ ما تم إنجازه

### 1. API Controllers
- ✅ `DoctorApiController` - إدارة الدكاترة
- ✅ `HallApiController` - إدارة القاعات
- ✅ `SubjectApiController` - إدارة المواد
- ✅ `StudentGroupApiController` - إدارة مجموعات الطلاب
- ✅ `ScheduleApiController` - إدارة الجداول
- ✅ `StudentApiController` - إدارة الطلاب
- ✅ `DashboardApiController` - إحصائيات المسؤول
- ✅ Doctor و Student Dashboard APIs

### 2. Routes
- ✅ `/routes/api.php` - جميع الـ API routes مع النماذج

### 3. JavaScript Libraries
- ✅ `resources/js/api.js` - مكتبة AJAX كاملة
- ✅ `resources/js/datatable.js` - DataTable ديناميكي
- ✅ `resources/css/notifications.css` - نظام إشعارات محسّن

### 4. Views المحدثة
- ✅ Doctor Dashboard - بتصميم جديد
- ✅ Student Dashboard - بتصميم جديد
- ✅ Doctor Index - مع AJAX بالكامل
- ✅ Admin Layout - مع تضمين المكتبات الجديدة

---

## 🔧 الخطوات المتبقية للتحكم الكامل

### 1. تحديث باقي الـ Views (مهم!)

قم بتحديث الملفات التالية مثل Doctor Index:

#### `resources/views/admin/halls/index.blade.php`
```blade
<!-- استبدل النموذج التقليدي هذا: -->
<form method="POST" action="{{ route('admin.halls.destroy', $hall) }}">
    @csrf @method('DELETE')
    <button>Delete</button>
</form>

<!-- بـ AJAX: -->
<button onclick="deleteHall({{ $hall->id }})">Delete</button>
```

#### الملفات الأخرى المراد تحديثها:
- `resources/views/admin/subjects/index.blade.php`
- `resources/views/admin/student-groups/index.blade.php`
- `resources/views/admin/schedules/index.blade.php`
- `resources/views/admin/students/index.blade.php`

### 2. إضافة Models إذا لزم الأمر

تأكد من وجود العلاقات في:
- `User.php` - guardian, studentGroup, doctor
- `StudentGroup.php` - students, schedules
- `Schedule.php` - جميع العلاقات

### 3. تعديل الـ Controllers التقليدية (اختياري)

يمكن حذف الـ create/edit views واستخدام modals AJAX بدلاً منها.

---

## 📚 طريقة الاستخدام

### لجدول بسيط:

```html
<div class="card">
    <div class="card-header">
        <input type="text" placeholder="ابحث..." class="form-control" data-search-input>
    </div>
    <div class="card-body">
        <table class="table" id="data-table">
            <thead>
                <tr>
                    <th><input type="checkbox" data-select-all></th>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>البريد</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="card-footer" id="pagination"></div>
</div>

<script>
const api = new ScheduleAPI();

const table = new DataTable({
    containerId: 'data-table',
    apiMethod: api.getHalls.bind(api),
    columns: [
        { key: 'name', type: 'text' },
        { key: 'capacity', type: 'badge' },
    ],
    actions: {
        delete: async (item) => {
            if (confirm('حذف؟')) {
                await api.deleteHall(item.id);
                table.refresh();
            }
        }
    }
});
</script>
```

---

## 🎨 تخصيص الإشعارات

```javascript
// إشعار نجاح
api.showNotification('✓ نجاح', 'تم الحفظ بنجاح', 'success', 3000);

// إشعار خطأ
api.showNotification('✗ خطأ', 'فشل الحفظ', 'error', 5000);

// إشعار تحذير
api.showNotification('⚠ تحذير', 'تنبيه مهم', 'warning', 0);

// إشعار معلومات
api.showNotification('ℹ معلومات', 'رسالة معلومات', 'info', 5000);
```

---

## 🔍 اختبار الـ APIs

### استخدام Postman:

1. **الحصول على الدكاترة:**
   - Method: `GET`
   - URL: `http://localhost:8000/api/admin/doctors?page=1`
   - Headers: `Authorization: Bearer YOUR_TOKEN`

2. **إضافة دكتور:**
   - Method: `POST`
   - URL: `http://localhost:8000/api/admin/doctors`
   - Body (JSON):
   ```json
   {
       "name": "أحمد محمد",
       "email": "ahmed@example.com",
       "password": "password123",
       "password_confirmation": "password123",
       "department": "الهندسة",
       "phone": "01234567890"
   }
   ```

3. **تعديل دكتور:**
   - Method: `PUT`
   - URL: `http://localhost:8000/api/admin/doctors/1`
   - Body: نفس البيانات (بدون password إذا لم تريد تغييره)

4. **حذف دكتور:**
   - Method: `DELETE`
   - URL: `http://localhost:8000/api/admin/doctors/1`

---

## ⚙️ إعدادات مهمة

### في `config/auth.php`:
```php
'guards' => [
    'api' => [
        'driver' => 'sanctum',
        'provider' => 'users',
    ],
],
```

### في `config/cors.php`:
```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_methods' => ['*'],
'allowed_origins' => ['*'],
```

---

## 💡 أمثلة إضافية

### البحث والفرز:
```javascript
const response = await api.getDoctors(
    page = 1,
    search = 'أحمد',  // البحث عن الدكاترة التي تحتوي على "أحمد"
    per_page = 10
);
```

### الحذف المجموعي:
```javascript
const ids = [1, 2, 3, 4, 5];
await api.bulkDeleteDoctors(ids);
```

### التحقق من تضاربات الجداول:
```javascript
const conflict = await api.checkScheduleConflicts({
    doctor_id: 1,
    hall_id: 2,
    date: '2024-03-10',
    start_time: '09:00',
    end_time: '10:30'
});

if (conflict.has_conflict) {
    api.showNotification('تحذير', conflict.conflict_message, 'warning');
}
```

---

## 🐛 استكشاف الأخطاء

### الخطأ: "CSRF token mismatch"
**الحل:** تأكد من وجود meta tag CSRF في الـ layout:
```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

### الخطأ: "Unauthorized"
**الحل:** تحقق من أن المستخدم مسجل دخول وله الصلاحيات المناسبة

### الخطأ: "Method Not Allowed"
**الحل:** تأكد من أن الـ route موجود في `routes/api.php`

---

## 📈 أفضل الممارسات

1. ✅ استخدم `async/await` بدلاً من `.then()`
2. ✅ تحقق من `response.success` قبل معالجة البيانات
3. ✅ اعرض إشعارات للمستخدم على كل عملية
4. ✅ استخدم `try/catch` لمعالجة الأخطاء
5. ✅ حدّث الجدول بعد كل عملية ناجحة

---

## 🎓 معايير الكود

```javascript
// ✅ صحيح
async function saveDoctor(data) {
    const response = await api.createDoctor(data);
    if (response) {
        api.showNotification('نجاح', 'تم الحفظ', 'success');
        table.refresh();
    }
}

// ❌ خطأ
function saveDoctor(data) {
    api.createDoctor(data);  // لا تنتظر النتيجة
}
```

---

**آخر تحديث:** مارس 2026  
**الحالة:** ✅ جاهز للاستخدام الفوري
