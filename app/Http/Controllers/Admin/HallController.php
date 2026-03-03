<?php


// ══════════════════════════════════════════════════════════
// FILE: app/Http/Controllers/Admin/HallController.php
// ══════════════════════════════════════════════════════════
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hall;
use Illuminate\Http\Request;

class HallController extends Controller
{
    public function index()
    {
        $halls = Hall::withCount('schedules')->latest()->paginate(10);
        return view('admin.halls.index', compact('halls'));
    }

    public function create()
    {
        return view('admin.halls.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100|unique:halls,name',
            'type'        => 'required|in:lecture_hall,lab',
            'capacity'    => 'required|integer|min:1',
            'description' => 'nullable|string|max:500',
        ]);

        Hall::create($request->all());

        return redirect()->route('admin.halls.index')
            ->with('success', 'تم إضافة القاعة بنجاح ✅');
    }

    public function edit(Hall $hall)
    {
        return view('admin.halls.edit', compact('hall'));
    }

    public function update(Request $request, Hall $hall)
    {
        $request->validate([
            'name'        => 'required|string|max:100|unique:halls,name,' . $hall->id,
            'type'        => 'required|in:lecture_hall,lab',
            'capacity'    => 'required|integer|min:1',
            'description' => 'nullable|string|max:500',
        ]);

        $hall->update($request->all());

        return redirect()->route('admin.halls.index')
            ->with('success', 'تم تعديل القاعة بنجاح ✅');
    }

    public function destroy(Hall $hall)
    {
        // منع الحذف لو فيه جداول مرتبطة
        if ($hall->schedules()->exists()) {
            return back()->with('error', '⚠️ لا يمكن حذف القاعة لوجود جداول مرتبطة بها');
        }

        $hall->delete();
        return back()->with('success', 'تم حذف القاعة');
    }
}
