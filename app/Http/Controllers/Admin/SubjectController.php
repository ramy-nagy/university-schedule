<?php


// ══════════════════════════════════════════════════════════
// FILE: app/Http/Controllers/Admin/SubjectController.php
// ══════════════════════════════════════════════════════════
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Doctor;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('doctor')
            ->withCount('schedules')
            ->latest()->paginate(10);
        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $doctors = Doctor::orderBy('name')->get();
        return view('admin.subjects.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'code'        => 'required|string|max:20|unique:subjects,code',
            'doctor_id'   => 'required|exists:doctors,id',
            'description' => 'nullable|string|max:500',
        ]);

        Subject::create($request->all());

        return redirect()->route('admin.subjects.index')
            ->with('success', 'تم إضافة المادة بنجاح ✅');
    }

    public function edit(Subject $subject)
    {
        $doctors = Doctor::orderBy('name')->get();
        return view('admin.subjects.edit', compact('subject', 'doctors'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'code'        => 'required|string|max:20|unique:subjects,code,' . $subject->id,
            'doctor_id'   => 'required|exists:doctors,id',
            'description' => 'nullable|string|max:500',
        ]);

        $subject->update($request->all());

        return redirect()->route('admin.subjects.index')
            ->with('success', 'تم تعديل المادة بنجاح ✅');
    }

    public function destroy(Subject $subject)
    {
        if ($subject->schedules()->exists()) {
            return back()->with('error', '⚠️ لا يمكن حذف المادة لوجود جداول مرتبطة بها');
        }

        $subject->delete();
        return back()->with('success', 'تم حذف المادة');
    }
}