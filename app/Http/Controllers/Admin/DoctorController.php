<?php


// ══════════════════════════════════════════════════════════
// FILE: app/Http/Controllers/Admin/DoctorController.php
// ══════════════════════════════════════════════════════════
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('user')
            ->withCount('schedules')
            ->latest()->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'department' => 'nullable|string|max:100',
            'phone'      => 'nullable|string|max:20',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8|confirmed',
        ]);

        // إنشاء حساب المستخدم والدكتور في نفس الوقت
        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'doctor',
            ]);

            $doctor = Doctor::create([
                'user_id'    => $user->id,
                'name'       => $request->name,
                'department' => $request->department,
                'phone'      => $request->phone,
            ]);

            $user->update(['doctor_id' => $doctor->id]);
        });

        return redirect()->route('admin.doctors.index')
            ->with('success', 'تم إضافة الدكتور وإنشاء حسابه بنجاح ✅');
    }

    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'department' => 'nullable|string|max:100',
            'phone'      => 'nullable|string|max:20',
            'email'      => 'required|email|unique:users,email,' . $doctor->user_id,
            'password'   => 'nullable|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($request, $doctor) {
            // تحديث بيانات الدكتور
            $doctor->update([
                'name'       => $request->name,
                'department' => $request->department,
                'phone'      => $request->phone,
            ]);

            // تحديث بيانات المستخدم
            $userData = ['name' => $request->name, 'email' => $request->email];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $doctor->user->update($userData);
        });

        return redirect()->route('admin.doctors.index')
            ->with('success', 'تم تعديل بيانات الدكتور بنجاح ✅');
    }

    public function destroy(Doctor $doctor)
    {
        if ($doctor->schedules()->exists()) {
            return back()->with('error', '⚠️ لا يمكن حذف الدكتور لوجود جداول مرتبطة به');
        }

        DB::transaction(function () use ($doctor) {
            $doctor->user->delete(); // cascade يحذف الدكتور تلقائياً
        });

        return back()->with('success', 'تم حذف الدكتور وحسابه');
    }
}
