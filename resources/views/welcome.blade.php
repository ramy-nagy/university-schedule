<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniSchedule — نظام إدارة الجداول الجامعية</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap');

        :root {
            --primary: #1a3a6e;
            --accent: #3b82f6;
            --green: #10b981;
            --orange: #f59e0b;
            --light: #f0f4ff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: #fff;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* ── Navbar ── */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 999;
            padding: 14px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(10, 20, 60, .85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            transition: all .3s;
        }

        nav.scrolled {
            background: rgba(10, 20, 60, .98);
            padding: 10px 40px;
        }

        .nav-logo {
            color: #fff;
            font-size: 1.3rem;
            font-weight: 900;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-logo span {
            color: #3b82f6;
        }

        .nav-links {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .nav-links a {
            color: rgba(255, 255, 255, .8);
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: .9rem;
            font-weight: 600;
            transition: .2s;
        }

        .nav-links a:hover {
            color: #fff;
            background: rgba(255, 255, 255, .1);
        }

        .btn-nav {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: #fff !important;
            border-radius: 10px !important;
            box-shadow: 0 4px 15px rgba(59, 130, 246, .4);
        }

        .btn-nav:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, .5) !important;
        }

        /* ── Hero ── */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #020818 0%, #0a1628 40%, #0f2952 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero-bg-circles {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, .15), transparent 70%);
            animation: pulse-circle 6s ease-in-out infinite;
        }

        .c1 {
            width: 600px;
            height: 600px;
            top: -150px;
            right: -150px;
            animation-delay: 0s;
        }

        .c2 {
            width: 400px;
            height: 400px;
            bottom: -100px;
            left: -100px;
            animation-delay: 2s;
            background: radial-gradient(circle, rgba(16, 185, 129, .12), transparent 70%);
        }

        .c3 {
            width: 300px;
            height: 300px;
            top: 40%;
            left: 40%;
            animation-delay: 4s;
            background: radial-gradient(circle, rgba(245, 158, 11, .08), transparent 70%);
        }

        @keyframes pulse-circle {

            0%,
            100% {
                transform: scale(1);
                opacity: .6
            }

            50% {
                transform: scale(1.1);
                opacity: 1
            }
        }

        /* floating particles */
        .particles {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: #3b82f6;
            border-radius: 50%;
            animation: float-up linear infinite;
            opacity: 0;
        }

        @keyframes float-up {
            0% {
                transform: translateY(100vh) scale(0);
                opacity: 0;
            }

            10% {
                opacity: .8;
            }

            90% {
                opacity: .4;
            }

            100% {
                transform: translateY(-100px) scale(1);
                opacity: 0;
            }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 0 20px;
            max-width: 900px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(59, 130, 246, .15);
            border: 1px solid rgba(59, 130, 246, .3);
            color: #93c5fd;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: .85rem;
            font-weight: 600;
            margin-bottom: 28px;
            animation: fadeDown .8s ease;
        }

        .hero-badge .dot {
            width: 8px;
            height: 8px;
            background: #3b82f6;
            border-radius: 50%;
            animation: blink 1.5s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .3
            }
        }

        .hero h1 {
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            font-weight: 900;
            color: #fff;
            line-height: 1.2;
            animation: fadeUp .8s ease .2s both;
        }

        .hero h1 .highlight {
            background: linear-gradient(135deg, #3b82f6, #06b6d4, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            color: rgba(255, 255, 255, .65);
            font-size: 1.15rem;
            margin: 20px auto 36px;
            max-width: 620px;
            line-height: 1.8;
            animation: fadeUp .8s ease .4s both;
        }

        .hero-btns {
            display: flex;
            gap: 14px;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeUp .8s ease .6s both;
        }

        .btn-primary-hero {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: #fff;
            padding: 16px 36px;
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 8px 30px rgba(59, 130, 246, .4);
            transition: .3s;
            border: none;
            cursor: pointer;
        }

        .btn-primary-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(59, 130, 246, .5);
            color: #fff;
        }

        .btn-outline-hero {
            background: transparent;
            color: #fff;
            padding: 16px 36px;
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            border: 2px solid rgba(255, 255, 255, .25);
            transition: .3s;
        }

        .btn-outline-hero:hover {
            background: rgba(255, 255, 255, .1);
            border-color: rgba(255, 255, 255, .5);
            color: #fff;
            transform: translateY(-3px);
        }

        /* hero stats */
        .hero-stats {
            display: flex;
            gap: 40px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 60px;
            animation: fadeUp .8s ease .8s both;
        }

        .stat-item {
            text-align: center;
        }

        .stat-item .num {
            font-size: 2rem;
            font-weight: 900;
            color: #fff;
        }

        .stat-item .num span {
            color: #3b82f6;
        }

        .stat-item .lbl {
            color: rgba(255, 255, 255, .5);
            font-size: .85rem;
        }

        /* scroll indicator */
        .scroll-ind {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, .4);
            font-size: .8rem;
            text-align: center;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateX(-50%) translateY(0)
            }

            50% {
                transform: translateX(-50%) translateY(8px)
            }
        }

        /* ── Section Base ── */
        section {
            padding: 90px 0;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 0 24px;
        }

        .section-badge {
            display: inline-block;
            background: var(--light);
            color: var(--accent);
            padding: 6px 18px;
            border-radius: 50px;
            font-size: .8rem;
            font-weight: 700;
            margin-bottom: 12px;
            border: 1px solid rgba(59, 130, 246, .2);
        }

        .section-title {
            font-size: clamp(1.7rem, 3vw, 2.5rem);
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 12px;
        }

        .section-sub {
            color: #64748b;
            font-size: 1rem;
            line-height: 1.8;
            max-width: 560px;
        }

        /* ── Features ── */
        .features {
            background: #f8faff;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-top: 50px;
        }

        .feature-card {
            background: #fff;
            border-radius: 20px;
            padding: 32px 28px;
            border: 1px solid #e2e8f0;
            transition: .3s;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--c1), var(--c2));
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, .1);
            border-color: transparent;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .feature-card h3 {
            font-size: 1.15rem;
            font-weight: 800;
            margin-bottom: 10px;
            color: #0f172a;
        }

        .feature-card p {
            color: #64748b;
            font-size: .9rem;
            line-height: 1.7;
        }

        /* ── How It Works ── */
        .steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 50px;
        }

        .step {
            text-align: center;
            padding: 36px 24px;
            background: #fff;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            position: relative;
        }

        .step-num {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: #fff;
            font-size: 1.3rem;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            box-shadow: 0 8px 20px rgba(59, 130, 246, .3);
        }

        .step h4 {
            font-weight: 800;
            margin-bottom: 8px;
        }

        .step p {
            color: #64748b;
            font-size: .88rem;
            line-height: 1.6;
        }

        .step-arrow {
            position: absolute;
            left: -14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.5rem;
            color: #cbd5e1;
        }

        /* ── Roles ── */
        .roles-bg {
            background: linear-gradient(135deg, #020818, #0f2952);
        }

        .roles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-top: 50px;
        }

        .role-card {
            border-radius: 20px;
            padding: 36px 28px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .08);
            transition: .3s;
        }

        .role-card:hover {
            transform: translateY(-6px);
        }

        .role-card.admin {
            background: linear-gradient(135deg, rgba(59, 130, 246, .15), rgba(29, 78, 216, .08));
        }

        .role-card.doctor {
            background: linear-gradient(135deg, rgba(16, 185, 129, .15), rgba(5, 150, 105, .08));
        }

        .role-card.student {
            background: linear-gradient(135deg, rgba(245, 158, 11, .15), rgba(217, 119, 6, .08));
        }

        .role-icon {
            font-size: 2.5rem;
            margin-bottom: 18px;
        }

        .role-card h3 {
            color: #fff;
            font-weight: 800;
            font-size: 1.2rem;
            margin-bottom: 8px;
        }

        .role-card .role-tag {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 50px;
            font-size: .75rem;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .admin .role-tag {
            background: rgba(59, 130, 246, .3);
            color: #93c5fd;
        }

        .doctor .role-tag {
            background: rgba(16, 185, 129, .3);
            color: #6ee7b7;
        }

        .student .role-tag {
            background: rgba(245, 158, 11, .3);
            color: #fcd34d;
        }

        .role-features {
            list-style: none;
        }

        .role-features li {
            color: rgba(255, 255, 255, .75);
            font-size: .9rem;
            padding: 7px 0;
            border-bottom: 1px solid rgba(255, 255, 255, .05);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .role-features li:last-child {
            border: none;
        }

        .role-features li i {
            font-size: .75rem;
        }

        .admin .role-features li i {
            color: #3b82f6;
        }

        .doctor .role-features li i {
            color: #10b981;
        }

        .student .role-features li i {
            color: #f59e0b;
        }

        /* ── Conflict Detection Feature ── */
        .conflict-section {
            background: #f8faff;
        }

        .conflict-visual {
            background: linear-gradient(135deg, #020818, #0f2952);
            border-radius: 24px;
            padding: 36px;
            position: relative;
            overflow: hidden;
        }

        .conflict-visual .glow {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(239, 68, 68, .2), transparent 70%);
            top: -50px;
            left: -50px;
            border-radius: 50%;
        }

        .conflict-item {
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            z-index: 1;
        }

        .conflict-item .check {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: .85rem;
        }

        .conflict-item.ok .check {
            background: rgba(16, 185, 129, .2);
            color: #10b981;
        }

        .conflict-item.warn .check {
            background: rgba(239, 68, 68, .2);
            color: #ef4444;
        }

        .conflict-item .text {
            color: #fff;
            font-size: .9rem;
            font-weight: 600;
        }

        .conflict-item .sub {
            color: rgba(255, 255, 255, .5);
            font-size: .78rem;
        }

        .conflict-badge {
            background: rgba(239, 68, 68, .15);
            border: 1px solid rgba(239, 68, 68, .3);
            border-radius: 10px;
            padding: 12px 18px;
            margin-top: 14px;
            color: #fca5a5;
            font-size: .85rem;
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            z-index: 1;
        }

        /* ── Tech Stack ── */
        .tech-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            justify-content: center;
            margin-top: 40px;
        }

        .tech-chip {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: .9rem;
            color: #334155;
            transition: .3s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
        }

        .tech-chip:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .1);
            border-color: #3b82f6;
            color: #3b82f6;
        }

        .tech-chip i {
            font-size: 1.3rem;
        }

        /* ── CTA ── */
        .cta-section {
            background: linear-gradient(135deg, #020818, #0a1e4a, #0f2952);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at center, rgba(59, 130, 246, .2) 0%, transparent 70%);
        }

        .cta-section h2 {
            color: #fff;
            font-size: clamp(1.8rem, 3vw, 2.8rem);
            font-weight: 900;
            margin-bottom: 16px;
            position: relative;
        }

        .cta-section p {
            color: rgba(255, 255, 255, .6);
            font-size: 1rem;
            max-width: 500px;
            margin: 0 auto 36px;
            position: relative;
        }

        .cta-btns {
            display: flex;
            gap: 14px;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
        }

        /* ── Footer ── */
        footer {
            background: #020818;
            color: rgba(255, 255, 255, .5);
            text-align: center;
            padding: 30px 24px;
            font-size: .87rem;
            border-top: 1px solid rgba(255, 255, 255, .06);
        }

        footer span {
            color: #3b82f6;
        }

        /* ── Animations ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes fadeDown {
            from {
                opacity: 0;
                transform: translateY(-20px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: .7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ── Responsive ── */
        @media(max-width:768px) {
            nav {
                padding: 12px 20px;
            }

            .nav-links a:not(.btn-nav) {
                display: none;
            }

            .hero-stats {
                gap: 24px;
            }

            .step-arrow {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- ── Navbar ──────────────────────────────────────────────── -->
    <nav id="navbar">
        <div class="nav-logo">
            <i class="bi bi-mortarboard-fill" style="color:#3b82f6;font-size:1.5rem"></i>
            KHELO<span>Schedule</span>
        </div>
        <div class="nav-links">
            <a href="#features">المميزات</a>
            <a href="#how">كيف يعمل</a>
            <a href="#roles">الأدوار</a>
            <a href="#tech">التقنيات</a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn-nav">لوحة التحكم</a>
            @else
                <a href="{{ route('login') }}" class="btn-nav">ابدأ الآن</a>

            @endauth
        </div>
    </nav>

    <!-- ── Hero ────────────────────────────────────────────────── -->
    <section class="hero" id="home">
        <div class="hero-bg-circles">
            <div class="circle c1"></div>
            <div class="circle c2"></div>
            <div class="circle c3"></div>
        </div>
        <div class="particles" id="particles"></div>

        <div class="hero-content">
            <div class="hero-badge">
                <div class="dot"></div>
                نظام جامعي متكامل — مدعوم بـ Laravel & Bootstrap
            </div>

            <h1>
                نظام إدارة<br>
                <span class="highlight">الجداول الجامعية</span><br>
                الذكي
            </h1>

            <p>
                منصة متكاملة تربط الأدمن والدكاترة والطلاب في مكان واحد،
                مع كشف تلقائي للتعارضات وجداول دراسية منظمة بدقة عالية.
            </p>

            <div class="hero-btns">
                <a href="#cta" class="btn-primary-hero">
                    <i class="bi bi-rocket-takeoff-fill me-2"></i>ابدأ الاستخدام
                </a>
                <a href="#features" class="btn-outline-hero">
                    <i class="bi bi-play-circle me-2"></i>اكتشف المميزات
                </a>
            </div>

            <div class="hero-stats">
                <div class="stat-item">
                    <div class="num">3<span>+</span></div>
                    <div class="lbl">أدوار مستخدمين</div>
                </div>
                <div class="stat-item">
                    <div class="num">0<span>%</span></div>
                    <div class="lbl">تعارض في المواعيد</div>
                </div>
                <div class="stat-item">
                    <div class="num">100<span>%</span></div>
                    <div class="lbl">عربي RTL</div>
                </div>
                <div class="stat-item">
                    <div class="num">24<span>/7</span></div>
                    <div class="lbl">وصول مستمر</div>
                </div>
            </div>
        </div>

        <div class="scroll-ind">
            <i class="bi bi-chevron-double-down d-block fs-5 mb-1"></i>
            اكتشف أكثر
        </div>
    </section>

    <!-- ── Features ─────────────────────────────────────────────── -->
    <section class="features" id="features">
        <div class="container">
            <div class="reveal">
                <span class="section-badge">✦ المميزات الرئيسية</span>
                <h2 class="section-title">كل ما تحتاجه في مكان واحد</h2>
                <p class="section-sub">نظام شامل يوفر إدارة كاملة للعملية التعليمية من إعداد القاعات وحتى عرض الجداول
                    للطلاب.</p>
            </div>

            <div class="features-grid">

                <div class="feature-card reveal" style="--c1:#3b82f6;--c2:#06b6d4">
                    <div class="feature-icon" style="background:#eff6ff;color:#3b82f6"><i
                            class="bi bi-building-fill"></i></div>
                    <h3>إدارة القاعات والمعامل</h3>
                    <p>أضف وعدل القاعات الدراسية والمعامل مع تحديد الطاقة الاستيعابية والنوع لكل قاعة بسهولة تامة.</p>
                </div>

                <div class="feature-card reveal" style="--c1:#10b981;--c2:#06b6d4">
                    <div class="feature-icon" style="background:#ecfdf5;color:#10b981"><i
                            class="bi bi-person-badge-fill"></i></div>
                    <h3>إدارة أعضاء هيئة التدريس</h3>
                    <p>سجّل الدكاترة وأنشئ لهم حسابات تلقائية وربطهم بالمواد التعليمية الخاصة بهم في لحظات.</p>
                </div>

                <div class="feature-card reveal" style="--c1:#f59e0b;--c2:#ef4444">
                    <div class="feature-icon" style="background:#fffbeb;color:#f59e0b"><i
                            class="bi bi-shield-fill-check"></i></div>
                    <h3>كشف التعارض التلقائي</h3>
                    <p>السيستم يفحص تلقائياً أي تعارض في القاعة أو الدكتور أو الفرقة  قبل حفظ أي موعد جديد.</p>
                </div>

                <div class="feature-card reveal" style="--c1:#8b5cf6;--c2:#3b82f6">
                    <div class="feature-icon" style="background:#f5f3ff;color:#8b5cf6"><i class="bi bi-people-fill"></i>
                    </div>
                    <h3>إدارة الفرق الطلابية</h3>
                    <p>عرّف الفرق وأيام دراستها وربط كل طالب بمجموعته للحصول على جداول دقيقة ومنظمة.</p>
                </div>

                <div class="feature-card reveal" style="--c1:#ef4444;--c2:#f59e0b">
                    <div class="feature-icon" style="background:#fef2f2;color:#ef4444"><i
                            class="bi bi-calendar-week-fill"></i></div>
                    <h3>جداول ديناميكية تفاعلية</h3>
                    <p>كل مستخدم يرى الجدول الخاص به فقط — مرتب بالتاريخ مع كامل التفاصيل من دكتور وقاعة ووقت.</p>
                </div>

                <div class="feature-card reveal" style="--c1:#06b6d4;--c2:#10b981">
                    <div class="feature-icon" style="background:#ecfeff;color:#06b6d4"><i class="bi bi-lock-fill"></i>
                    </div>
                    <h3>نظام صلاحيات متقدم</h3>
                    <p>ثلاثة أدوار مستقلة (Admin / Doctor / Student) مع توجيه ذكي تلقائي لكل دور بعد تسجيل الدخول.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ── How It Works ──────────────────────────────────────────── -->
    <section id="how">
        <div class="container">
            <div class="reveal" style="text-align:center">
                <span class="section-badge">✦ خطوات العمل</span>
                <h2 class="section-title">كيف يعمل النظام؟</h2>
                <p class="section-sub" style="margin:auto">أربع خطوات بسيطة وجدولك الدراسي جاهز بدون أي تعارضات</p>
            </div>

            <div class="steps" style="margin-top:50px">

                <div class="step reveal">
                    <div class="step-num">1</div>
                    <h4>إعداد البيانات</h4>
                    <p>الأدمن يضيف القاعات والدكاترة والمواد التعليمية والفرق الطلابية على النظام.</p>
                </div>

                <div class="step reveal" style="position:relative">
                    <div class="step-arrow"><i class="bi bi-chevron-left"></i></div>
                    <div class="step-num">2</div>
                    <h4>جدولة المواعيد</h4>
                    <p>الأدمن ينشئ التوقيتات الدراسية ويحدد الدكتور والمادة والقاعة والفرقة  والوقت.</p>
                </div>

                <div class="step reveal" style="position:relative">
                    <div class="step-arrow"><i class="bi bi-chevron-left"></i></div>
                    <div class="step-num">3</div>
                    <h4>الفحص التلقائي</h4>
                    <p>النظام يفحص التعارضات فورياً ويمنع الحفظ في حالة وجود أي تضارب في المواعيد.</p>
                </div>

                <div class="step reveal" style="position:relative">
                    <div class="step-arrow"><i class="bi bi-chevron-left"></i></div>
                    <div class="step-num">4</div>
                    <h4>عرض الجداول</h4>
                    <p>كل دكتور وطالب يدخل على حسابه ويجد جدوله الخاص مرتباً وجاهزاً للاطلاع.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ── Roles ─────────────────────────────────────────────────── -->
    <section class="roles-bg" id="roles" style="padding:90px 0">
        <div class="container">
            <div class="reveal" style="text-align:center">
                <span class="section-badge"
                    style="background:rgba(59,130,246,.15);border-color:rgba(59,130,246,.3);color:#93c5fd">✦ أدوار
                    النظام</span>
                <h2 class="section-title" style="color:#fff">ثلاثة أدوار — تجربة واحدة سلسة</h2>
                <p class="section-sub" style="color:rgba(255,255,255,.55);margin:auto">كل مستخدم يحصل على واجهة مخصصة
                    وصلاحيات محددة تناسب دوره تماماً.</p>
            </div>

            <div class="roles-grid">

                <div class="role-card admin reveal">
                    <div class="role-icon">🛡️</div>
                    <h3>المشرف (Admin)</h3>
                    <span class="role-tag">صلاحيات كاملة</span>
                    <ul class="role-features">
                        <li><i class="bi bi-check-circle-fill"></i> إضافة وتعديل وحذف القاعات</li>
                        <li><i class="bi bi-check-circle-fill"></i> إدارة الدكاترة وحساباتهم</li>
                        <li><i class="bi bi-check-circle-fill"></i> إدارة المواد التعليمية</li>
                        <li><i class="bi bi-check-circle-fill"></i> إدارة الفرق الطلابية</li>
                        <li><i class="bi bi-check-circle-fill"></i> إنشاء الجداول مع كشف التعارض</li>
                        <li><i class="bi bi-check-circle-fill"></i> لوحة تحكم إحصائية شاملة</li>
                    </ul>
                </div>

                <div class="role-card doctor reveal">
                    <div class="role-icon">👨‍🏫</div>
                    <h3>الدكتور (Doctor)</h3>
                    <span class="role-tag">عرض الجدول الشخصي</span>
                    <ul class="role-features">
                        <li><i class="bi bi-check-circle-fill"></i> عرض جدوله الأسبوعي كاملاً</li>
                        <li><i class="bi bi-check-circle-fill"></i> تفاصيل كل محاضرة (قاعة + فرقة )</li>
                        <li><i class="bi bi-check-circle-fill"></i> عرض محاضرات اليوم بوضوح</li>
                        <li><i class="bi bi-check-circle-fill"></i> المحاضرات القادمة مرتبة بالتاريخ</li>
                        <li><i class="bi bi-check-circle-fill"></i> badge عدد محاضرات اليوم</li>
                        <li><i class="bi bi-check-circle-fill"></i> واجهة sidebar احترافية</li>
                    </ul>
                </div>

                <div class="role-card student reveal">
                    <div class="role-icon">🎓</div>
                    <h3>الطالب (Student)</h3>
                    <span class="role-tag">جدول الفرقة </span>
                    <ul class="role-features">
                        <li><i class="bi bi-check-circle-fill"></i> عرض جدول مجموعته كاملاً</li>
                        <li><i class="bi bi-check-circle-fill"></i> اسم الدكتور والقاعة لكل حصة</li>
                        <li><i class="bi bi-check-circle-fill"></i> تمييز بين المحاضرة والمعمل</li>
                        <li><i class="bi bi-check-circle-fill"></i> محاضرات اليوم في الواجهة الرئيسية</li>
                        <li><i class="bi bi-check-circle-fill"></i> المحاضرات القادمة مرتبة</li>
                        <li><i class="bi bi-check-circle-fill"></i> واجهة navbar بسيطة وسهلة</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- ── Conflict Detection Visual ─────────────────────────────── -->
    <section class="conflict-section">
        <div class="container">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center" class="reveal">

                <div>
                    <span class="section-badge">✦ الميزة الأهم</span>
                    <h2 class="section-title">كشف التعارض الذكي</h2>
                    <p style="color:#64748b;line-height:1.8;margin-bottom:20px">
                        قبل ما يحفظ أي موعد، النظام بيفحص 3 حاجات في نفس الوقت فوراً بدون أي تأخير.
                    </p>
                    <div style="display:flex;flex-direction:column;gap:14px">
                        <div
                            style="display:flex;align-items:center;gap:12px;padding:14px 18px;background:#f0fdf4;border-radius:12px;border:1px solid #bbf7d0">
                            <i class="bi bi-building" style="color:#10b981;font-size:1.2rem"></i>
                            <div>
                                <div style="font-weight:700;color:#065f46">القاعة فاضية؟</div>
                                <div style="font-size:.82rem;color:#6b7280">هل في حصة تانية في نفس القاعة في نفس الوقت
                                </div>
                            </div>
                        </div>
                        <div
                            style="display:flex;align-items:center;gap:12px;padding:14px 18px;background:#eff6ff;border-radius:12px;border:1px solid #bfdbfe">
                            <i class="bi bi-person-badge" style="color:#3b82f6;font-size:1.2rem"></i>
                            <div>
                                <div style="font-weight:700;color:#1e3a8a">الدكتور فاضي؟</div>
                                <div style="font-size:.82rem;color:#6b7280">هل الدكتور عنده محاضرة تانية في نفس الوقت
                                </div>
                            </div>
                        </div>
                        <div
                            style="display:flex;align-items:center;gap:12px;padding:14px 18px;background:#fffbeb;border-radius:12px;border:1px solid #fde68a">
                            <i class="bi bi-people" style="color:#f59e0b;font-size:1.2rem"></i>
                            <div>
                                <div style="font-weight:700;color:#78350f">الفرقة  فاضية؟</div>
                                <div style="font-size:.82rem;color:#6b7280">هل الفرقة  الطلابية عندها حصة في نفس الوقت
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="conflict-visual">
                    <div class="glow"></div>
                    <div style="color:rgba(255,255,255,.6);font-size:.8rem;margin-bottom:16px;font-weight:600">⚡ فحص
                        فوري عند إضافة موعد جديد</div>

                    <div class="conflict-item ok">
                        <div class="check"><i class="bi bi-check-lg"></i></div>
                        <div>
                            <div class="text">مدرج 6أ</div>
                            <div class="sub">القاعة متاحة في هذا الوقت ✓</div>
                        </div>
                    </div>

                    <div class="conflict-item ok">
                        <div class="check"><i class="bi bi-check-lg"></i></div>
                        <div>
                            <div class="text">د. أحمد محمد</div>
                            <div class="sub">الدكتور ليس لديه محاضرة ✓</div>
                        </div>
                    </div>

                    <div class="conflict-item warn">
                        <div class="check"><i class="bi bi-x-lg"></i></div>
                        <div>
                            <div class="text">الفرقة  الأولى</div>
                            <div class="sub">لديها محاضرة في نفس الوقت ✗</div>
                        </div>
                    </div>

                    <div class="conflict-badge">
                        <i class="bi bi-exclamation-triangle-fill" style="font-size:1.1rem"></i>
                        <div>
                            <div style="font-weight:700;margin-bottom:2px">⚠️ تعارض في المواعيد!</div>
                            <div style="font-size:.78rem;opacity:.8">الفرقة  الطلابية لديها محاضرة أخرى في هذا الوقت
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ── Tech Stack ────────────────────────────────────────────── -->
    <section id="tech" style="background:#f8faff">
        <div class="container" style="text-align:center">
            <div class="reveal">
                <span class="section-badge">✦ التقنيات المستخدمة</span>
                <h2 class="section-title">مبني بأحدث التقنيات</h2>
                <p class="section-sub" style="margin:auto">مزيج مثالي من تقنيات الفرونت اند والباك اند لبناء تجربة
                    سلسة وموثوقة.</p>
            </div>
            <div class="tech-grid reveal">
                <div class="tech-chip"><i class="bi bi-filetype-php" style="color:#8892be"></i> PHP 8.2</div>
                <div class="tech-chip"><i class="bi bi-box-seam" style="color:#ff2d20"></i> Laravel 11</div>
                <div class="tech-chip"><i class="bi bi-database-fill" style="color:#00758f"></i> MySQL</div>
                <div class="tech-chip"><i class="bi bi-bootstrap-fill" style="color:#7952b3"></i> Bootstrap 5</div>
                <div class="tech-chip"><i class="bi bi-filetype-html" style="color:#e44d26"></i> HTML5 & CSS3</div>
                <div class="tech-chip"><i class="bi bi-filetype-js" style="color:#f7df1e"></i> JavaScript</div>
                <div class="tech-chip"><i class="bi bi-layout-text-window" style="color:#ff2d20"></i> Blade Templates
                </div>
                <div class="tech-chip"><i class="bi bi-shield-lock-fill" style="color:#10b981"></i> Laravel Breeze
                </div>
            </div>
        </div>
    </section>

    <!-- ── CTA ───────────────────────────────────────────────────── -->
    <section class="cta-section" id="cta" style="padding:100px 0">
        <div class="container">
            <div class="reveal">
                <h2>جاهز تبدأ مشروعك؟ 🚀</h2>
                <p>كل الكود جاهز ومنظم — اشتغل عليه وسلّمه بثقة في يوم المناقشة</p>
                <div class="cta-btns">
                    <a href="#home" class="btn-primary-hero">
                        <i class="bi bi-code-slash me-2"></i>استعرض الكود
                    </a>
                    <a href="#features" class="btn-outline-hero">
                        <i class="bi bi-eye me-2"></i>استعرض المميزات
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ── Footer ────────────────────────────────────────────────── -->
    <footer>
        <i class="bi bi-mortarboard-fill me-2" style="color:#3b82f6"></i>
        <span>UniSchedule</span> — نظام إدارة الجداول الجامعية &copy; 2025
        &nbsp;·&nbsp; مبني بـ <span>Laravel</span> + <span>Bootstrap 5</span>
    </footer>

    <script>
        // ── Navbar scroll effect ──
        window.addEventListener('scroll', () => {
            document.getElementById('navbar').classList.toggle('scrolled', scrollY > 50);
        });

        // ── Scroll reveal ──
        const observer = new IntersectionObserver(entries => {
            entries.forEach((e, i) => {
                if (e.isIntersecting) {
                    setTimeout(() => e.target.classList.add('visible'), i * 80);
                }
            });
        }, {
            threshold: 0.1
        });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // ── Floating particles ──
        const container = document.getElementById('particles');
        for (let i = 0; i < 30; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            p.style.cssText = `
    left:${Math.random()*100}%;
    width:${Math.random()*3+1}px;
    height:${Math.random()*3+1}px;
    animation-duration:${Math.random()*10+8}s;
    animation-delay:${Math.random()*10}s;
    opacity:${Math.random()*.5+.2};
    background:${['#3b82f6','#10b981','#f59e0b','#8b5cf6'][Math.floor(Math.random()*4)]};
  `;
            container.appendChild(p);
        }

        // ── Smooth anchor scroll ──
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                e.preventDefault();
                const t = document.querySelector(a.getAttribute('href'));
                if (t) t.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });
    </script>
</body>

</html>
