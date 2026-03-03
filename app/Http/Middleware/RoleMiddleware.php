<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    // ── خريطة الـ roles والـ routes الخاصة بيهم ──────────
    protected array $dashboards = [
        'admin'   => 'admin.dashboard',
        'doctor'  => 'doctor.dashboard',
        'student' => 'student.dashboard',
    ];

    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        // 1. لو مش مسجل دخول خالص → روح login
        if (!$request->user()) {
            return redirect()->route('login')
                ->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $userRole = $request->user()->role;

        // 2. لو الـ role مش في القائمة المسموح بيها
        if (!in_array($userRole, $roles)) {

            // بدل ما يطلع 403، يحوله على الداشبورد بتاعه هو
            $redirectRoute = $this->dashboards[$userRole] ?? 'login';

            return redirect()->route($redirectRoute)
                ->with('warning', $this->getWarningMessage($userRole));
        }

        // 3. كل حاجة تمام → كمّل
        return $next($request);
    }

    // ── رسالة تحذير مناسبة لكل role ─────────────────────
    private function getWarningMessage(string $role): string
    {
        return match($role) {
            'doctor'  => '🔒 هذه الصفحة للمشرفين فقط. تم تحويلك لجدولك الشخصي.',
            'student' => '🔒 هذه الصفحة غير متاحة لك. تم تحويلك لجدولك الدراسي.',
            'admin'   => '🔒 تم تحويلك للوحة التحكم.',
            default   => '🔒 غير مصرح لك بالدخول لهذه الصفحة.',
        };
    }
}
