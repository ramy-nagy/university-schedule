<?php
// ══════════════════════════════════════════════════════════
// FILE: database/seeders/DatabaseSeeder.php
// Run: php artisan db:seed
// ══════════════════════════════════════════════════════════
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // HallSeeder::class,
            // DoctorSeeder::class,
            // SubjectSeeder::class,
            // StudentGroupSeeder::class,
            UserSeeder::class,
            // ScheduleSeeder::class,
        ]);
    }
}

// ══════════════════════════════════════════════════════════
// FILE: database/seeders/HallSeeder.php
// ══════════════════════════════════════════════════════════
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Hall;

class HallSeeder extends Seeder
{
    public function run(): void
    {
        $halls = [
            ['name'=>'مدرج 6أ',  'type'=>'lecture_hall','capacity'=>200,'description'=>'مدرج كبير - الطابق السادس'],
            ['name'=>'مدرج 6ب',  'type'=>'lecture_hall','capacity'=>180,'description'=>'مدرج متوسط - الطابق السادس'],
            ['name'=>'مدرج 3أ',  'type'=>'lecture_hall','capacity'=>150,'description'=>'مدرج صغير - الطابق الثالث'],
            ['name'=>'معمل 1',   'type'=>'lab',         'capacity'=>40, 'description'=>'معمل حاسب آلي - الطابق الأول'],
            ['name'=>'معمل 2',   'type'=>'lab',         'capacity'=>40, 'description'=>'معمل شبكات - الطابق الأول'],
            ['name'=>'معمل 3',   'type'=>'lab',         'capacity'=>35, 'description'=>'معمل برمجة - الطابق الثاني'],
        ];
        foreach ($halls as $hall) Hall::create($hall);
    }
}

// ══════════════════════════════════════════════════════════
// FILE: database/seeders/DoctorSeeder.php
// ══════════════════════════════════════════════════════════
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{Doctor, User};
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            ['name'=>'د. أحمد محمد علي',    'department'=>'علوم الحاسب',       'phone'=>'0100-000-0001'],
            ['name'=>'د. سارة إبراهيم',      'department'=>'نظم المعلومات',     'phone'=>'0100-000-0002'],
            ['name'=>'د. محمود حسن',         'department'=>'الشبكات',           'phone'=>'0100-000-0003'],
            ['name'=>'د. نورا عبدالله',      'department'=>'الذكاء الاصطناعي',  'phone'=>'0100-000-0004'],
        ];

        foreach ($doctors as $i => $d) {
            $user = User::create([
                'name'     => $d['name'],
                'email'    => "doctor" . ($i+1) . "@uni.edu",
                'password' => Hash::make('password'),
                'role'     => 'doctor',
            ]);
            $doctor = Doctor::create([...$d, 'user_id' => $user->id]);
            $user->update(['doctor_id' => $doctor->id]);
        }
    }
}

// ══════════════════════════════════════════════════════════
// FILE: database/seeders/SubjectSeeder.php
// ══════════════════════════════════════════════════════════
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['name'=>'برمجة 1',             'doctor_id'=>1],
            ['name'=>'برمجة 2',             'doctor_id'=>1],
            ['name'=>'قواعد البيانات',       'doctor_id'=>2],
            ['name'=>'نظم المعلومات',        'doctor_id'=>2],
            ['name'=>'شبكات الحاسب',        'doctor_id'=>3],
            ['name'=>'أمن المعلومات',        'doctor_id'=>3],
            ['name'=>'تعلم الآلة',           'doctor_id'=>4],
            ['name'=>'معالجة اللغات الطبيعية','doctor_id'=>4],
        ];
        foreach ($subjects as $s) Subject::create($s);
    }
}

// ══════════════════════════════════════════════════════════
// FILE: database/seeders/StudentGroupSeeder.php
// ══════════════════════════════════════════════════════════
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\StudentGroup;

class StudentGroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            ['name'=>'الفرقة  الأولى',  'study_days'=>'السبت,الاثنين,الأربعاء', 'description'=>'تبدأ 8 صباحاً'],
            ['name'=>'الفرقة  الثانية', 'study_days'=>'الأحد,الثلاثاء,الخميس',  'description'=>'تبدأ 10 صباحاً'],
            ['name'=>'الفرقة  الثالثة', 'study_days'=>'السبت,الاثنين,الأربعاء', 'description'=>'تبدأ 12 ظهراً'],
        ];
        foreach ($groups as $g) StudentGroup::create($g);
    }
}

// ══════════════════════════════════════════════════════════
// FILE: database/seeders/UserSeeder.php
// ══════════════════════════════════════════════════════════
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@uni.edu',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // // Students (3 per group)
        // $students = [
        //     ['name'=>'علي محمد',    'group'=>1],
        //     ['name'=>'فاطمة أحمد',  'group'=>1],
        //     ['name'=>'خالد حسن',    'group'=>1],
        //     ['name'=>'منى سعيد',    'group'=>2],
        //     ['name'=>'عمر طارق',    'group'=>2],
        //     ['name'=>'ريم عادل',    'group'=>2],
        //     ['name'=>'يوسف كمال',   'group'=>3],
        //     ['name'=>'دينا وليد',   'group'=>3],
        //     ['name'=>'أسامة فتحي',  'group'=>3],
        // ];
        // foreach ($students as $i => $s) {
        //     User::create([
        //         'name'             => $s['name'],
        //         'email'            => "student" . ($i+1) . "@uni.edu",
        //         'password'         => Hash::make('password'),
        //         'role'             => 'student',
        //         'student_group_id' => $s['group'],
        //     ]);
        // }
    }
}

// ══════════════════════════════════════════════════════════
// FILE: database/seeders/ScheduleSeeder.php
// ══════════════════════════════════════════════════════════
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Schedule;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $schedules = [
            // Group 1 - السبت والاثنين والأربعاء (08:00 - 14:00)
            // Saturday
            ['doctor_id'=>1,'subject_id'=>1,'hall_id'=>1,'student_group_id'=>1,'day_of_week'=>'saturday','start_time'=>'08:00','end_time'=>'10:00','type'=>'lecture'],
            ['doctor_id'=>2,'subject_id'=>3,'hall_id'=>2,'student_group_id'=>1,'day_of_week'=>'saturday','start_time'=>'10:00','end_time'=>'12:00','type'=>'lecture'],
            ['doctor_id'=>3,'subject_id'=>5,'hall_id'=>3,'student_group_id'=>1,'day_of_week'=>'saturday','start_time'=>'12:00','end_time'=>'14:00','type'=>'lecture'],
            // Monday
            ['doctor_id'=>1,'subject_id'=>1,'hall_id'=>4,'student_group_id'=>1,'day_of_week'=>'monday','start_time'=>'08:00','end_time'=>'10:00','type'=>'lab'],
            ['doctor_id'=>2,'subject_id'=>3,'hall_id'=>5,'student_group_id'=>1,'day_of_week'=>'monday','start_time'=>'10:00','end_time'=>'12:00','type'=>'lab'],
            ['doctor_id'=>4,'subject_id'=>7,'hall_id'=>1,'student_group_id'=>1,'day_of_week'=>'monday','start_time'=>'12:00','end_time'=>'14:00','type'=>'lecture'],
            // Wednesday
            ['doctor_id'=>3,'subject_id'=>5,'hall_id'=>2,'student_group_id'=>1,'day_of_week'=>'wednesday','start_time'=>'08:00','end_time'=>'10:00','type'=>'lecture'],
            ['doctor_id'=>1,'subject_id'=>2,'hall_id'=>3,'student_group_id'=>1,'day_of_week'=>'wednesday','start_time'=>'10:00','end_time'=>'12:00','type'=>'lecture'],
            ['doctor_id'=>2,'subject_id'=>4,'hall_id'=>6,'student_group_id'=>1,'day_of_week'=>'wednesday','start_time'=>'12:00','end_time'=>'14:00','type'=>'lab'],

            // Group 2 - الأحد والثلاثاء والخميس (10:00 - 14:00)
            // Sunday
            ['doctor_id'=>3,'subject_id'=>5,'hall_id'=>1,'student_group_id'=>2,'day_of_week'=>'sunday','start_time'=>'10:00','end_time'=>'12:00','type'=>'lecture'],
            ['doctor_id'=>4,'subject_id'=>7,'hall_id'=>2,'student_group_id'=>2,'day_of_week'=>'sunday','start_time'=>'12:00','end_time'=>'14:00','type'=>'lecture'],
            // Tuesday
            ['doctor_id'=>1,'subject_id'=>1,'hall_id'=>4,'student_group_id'=>2,'day_of_week'=>'tuesday','start_time'=>'10:00','end_time'=>'12:00','type'=>'lab'],
            ['doctor_id'=>3,'subject_id'=>6,'hall_id'=>5,'student_group_id'=>2,'day_of_week'=>'tuesday','start_time'=>'12:00','end_time'=>'14:00','type'=>'lab'],
            // Thursday
            ['doctor_id'=>2,'subject_id'=>3,'hall_id'=>3,'student_group_id'=>2,'day_of_week'=>'thursday','start_time'=>'10:00','end_time'=>'12:00','type'=>'lecture'],
            ['doctor_id'=>4,'subject_id'=>8,'hall_id'=>1,'student_group_id'=>2,'day_of_week'=>'thursday','start_time'=>'12:00','end_time'=>'14:00','type'=>'lecture'],

            // Group 3 - السبت والاثنين والأربعاء (12:00 - 14:00)
            // Saturday
            ['doctor_id'=>2,'subject_id'=>4,'hall_id'=>3,'student_group_id'=>3,'day_of_week'=>'saturday','start_time'=>'12:00','end_time'=>'14:00','type'=>'lecture'],
            // Monday
            ['doctor_id'=>3,'subject_id'=>6,'hall_id'=>4,'student_group_id'=>3,'day_of_week'=>'monday','start_time'=>'10:00','end_time'=>'12:00','type'=>'lab'],
            ['doctor_id'=>1,'subject_id'=>2,'hall_id'=>5,'student_group_id'=>3,'day_of_week'=>'monday','start_time'=>'12:00','end_time'=>'14:00','type'=>'lab'],
            // Wednesday
            ['doctor_id'=>4,'subject_id'=>8,'hall_id'=>2,'student_group_id'=>3,'day_of_week'=>'wednesday','start_time'=>'10:00','end_time'=>'12:00','type'=>'lecture'],
            ['doctor_id'=>2,'subject_id'=>3,'hall_id'=>1,'student_group_id'=>3,'day_of_week'=>'wednesday','start_time'=>'12:00','end_time'=>'14:00','type'=>'lecture'],
        ];
        foreach ($schedules as $s) Schedule::create($s);
    }
}