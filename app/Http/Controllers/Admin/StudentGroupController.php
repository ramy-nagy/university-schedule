<?php


// ══════════════════════════════════════════════════════════
// FILE: app/Http/Controllers/Admin/StudentGroupController.php
// ══════════════════════════════════════════════════════════
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudentGroupController extends Controller
{
    public function index()
    {
        $groups = StudentGroup::withCount(['students', 'schedules'])
            ->latest()->paginate(10);
        return view('admin.student-groups.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.student-groups.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:student_groups,name',
            'study_days'  => 'required|array',
            'description' => 'nullable|string|max:500',
        ], [
            'name.required'       => 'اسم المجموعة مطلوب',
            'name.unique'         => 'اسم المجموعة موجود بالفعل',
            'name.max'            => 'لا يتجاوز الاسم 100 حرف',
            'study_days.required' => 'يجب تحديد أيام الدراسة',
            'study_days.max'      => 'لا تتجاوز أيام الدراسة 200 حرف',
            'description.max'     => 'لا يتجاوز الوصف 500 حرف',
        ]);

        StudentGroup::create($validated);

        return redirect()->route('admin.student-groups.index')
            ->with('success', 'تم إضافة المجموعة بنجاح ✅');
    }

    public function edit(StudentGroup $studentGroup)
    {
        return view('admin.student-groups.edit', ['group' => $studentGroup]);
    }

    public function update(Request $request, StudentGroup $studentGroup)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:student_groups,name,' . $studentGroup->id,
            'study_days'  => 'required|array',
            'description' => 'nullable|string|max:500',
        ], [
            'name.required'       => 'اسم المجموعة مطلوب',
            'name.unique'         => 'اسم المجموعة موجود بالفعل',
            'name.max'            => 'لا يتجاوز الاسم 100 حرف',
            'study_days.required' => 'يجب تحديد أيام الدراسة',
            'study_days.max'      => 'لا تتجاوز أيام الدراسة 200 حرف',
            'description.max'     => 'لا يتجاوز الوصف 500 حرف',
        ]);
        
        $studentGroup->update($validated);

        return redirect()->route('admin.student-groups.index')
            ->with('success', 'تم تعديل المجموعة بنجاح ✅');
    }

    public function destroy(StudentGroup $studentGroup)
    {
        if ($studentGroup->schedules()->exists()) {
            return back()->with('error', '⚠️ لا يمكن حذف المجموعة لوجود جداول مرتبطة بها');
        }

        if ($studentGroup->students()->exists()) {
            return back()->with('error', '⚠️ لا يمكن حذف المجموعة لوجود طلاب مسجلين فيها');
        }

        $studentGroup->delete();
        return back()->with('success', 'تم حذف المجموعة');
    }
}