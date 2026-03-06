<?php
// ══════════════════════════════════════════════════════════
// FILE: app/Http/Controllers/Admin/StudentController.php
// ══════════════════════════════════════════════════════════
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, StudentGroup, Schedule};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    // ── قائمة كل الطلاب ──────────────────────────────────
    public function index(Request $request)
    {
        $students = User::where('role', 'student')
            ->with('studentGroup')
            ->when($request->search, fn($q) =>
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
            )
            ->when($request->group_id, fn($q) =>
                $q->where('student_group_id', $request->group_id)
            )
            ->latest()->paginate(15)->withQueryString();

        $groups = StudentGroup::all();

        return view('admin.students.index', compact('students', 'groups'));
    }

    // ── فورم إضافة طالب ──────────────────────────────────
    public function create()
    {
        $groups = StudentGroup::orderBy('name')->get();
        return view('admin.students.create', compact('groups'));
    }

    // ── حفظ طالب جديد ────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:100',
            'email'            => 'required|email|unique:users,email',
            'student_group_id' => 'required|exists:student_groups,id',
            'password'         => 'required|string|min:8|confirmed',
        ], [
            'name.required'             => 'اسم الطالب مطلوب',
            'email.unique'              => 'هذا البريد مسجل بالفعل',
            'student_group_id.required' => 'يجب اختيار الفرقة  الدراسية',
            'password.min'              => 'كلمة المرور 8 أحرف على الأقل',
            'password.confirmed'        => 'كلمتا المرور غير متطابقتين',
        ]);

        User::create([
            'name'             => $request->name,
            'email'            => $request->email,
            'password'         => Hash::make($request->password),
            'role'             => 'student',
            'student_group_id' => $request->student_group_id,
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', '✅ تم إضافة الطالب بنجاح وإنشاء حسابه');
    }

    // ── عرض جدول طالب معين ───────────────────────────────
    public function show(User $student)
    {
        abort_if($student->role !== 'student', 404);

        $schedules = Schedule::with(['doctor', 'subject', 'hall'])
            ->where('student_group_id', $student->student_group_id)
            ->orderByRaw(DB::raw("CASE day_of_week
                WHEN 'saturday' THEN 0
                WHEN 'sunday' THEN 1
                WHEN 'monday' THEN 2
                WHEN 'tuesday' THEN 3
                WHEN 'wednesday' THEN 4
                WHEN 'thursday' THEN 5
                WHEN 'friday' THEN 6
            END"))
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week_label');

        // Get today's day of week
        $dayOfWeekMap = [
            'Saturday' => 'saturday',
            'Sunday' => 'sunday',
            'Monday' => 'monday',
            'Tuesday' => 'tuesday',
            'Wednesday' => 'wednesday',
            'Thursday' => 'thursday',
            'Friday' => 'friday',
        ];
        $todayEnglishDay = today()->format('l');
        $todayKey = $dayOfWeekMap[$todayEnglishDay] ?? 'monday';

        $stats = [
            'total'    => Schedule::where('student_group_id', $student->student_group_id)->count(),
            'upcoming' => Schedule::where('student_group_id', $student->student_group_id)->count(),
            'today'    => Schedule::where('student_group_id', $student->student_group_id)->where('day_of_week', $todayKey)->count(),
            'lectures' => Schedule::where('student_group_id', $student->student_group_id)->where('type', 'lecture')->count(),
            'labs'     => Schedule::where('student_group_id', $student->student_group_id)->where('type', 'lab')->count(),
        ];

        return view('admin.students.show', compact('student', 'schedules', 'stats'));
    }

    // ── فورم تعديل طالب ──────────────────────────────────
    public function edit(User $student)
    {
        abort_if($student->role !== 'student', 404);
        $groups = StudentGroup::orderBy('name')->get();
        return view('admin.students.edit', compact('student', 'groups'));
    }

    // ── تحديث بيانات طالب ────────────────────────────────
    public function update(Request $request, User $student)
    {
        abort_if($student->role !== 'student', 404);

        $request->validate([
            'name'             => 'required|string|max:100',
            'email'            => 'required|email|unique:users,email,' . $student->id,
            'student_group_id' => 'required|exists:student_groups,id',
            'password'         => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name'             => $request->name,
            'email'            => $request->email,
            'student_group_id' => $request->student_group_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $student->update($data);

        return redirect()->route('admin.students.index')
            ->with('success', '✅ تم تعديل بيانات الطالب بنجاح');
    }

    // ── حذف طالب ─────────────────────────────────────────
    public function destroy(User $student)
    {
        abort_if($student->role !== 'student', 404);
        $student->delete();
        return back()->with('success', 'تم حذف الطالب');
    }
}