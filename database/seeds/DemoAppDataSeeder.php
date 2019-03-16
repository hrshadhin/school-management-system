<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\AppMeta;
use App\AcademicYear;
use App\Http\Helpers\AppHelper;
use App\IClass;
use App\Employee;
use App\Section;

class DemoAppDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //truncate previous data
        echo 'deleting old data.....';
        $this->deletePreviousData();

        //some user with role
        echo PHP_EOL , 'seeding users...';
        $this->userData();

        //seed academic year
        echo PHP_EOL , 'seeding academic year...';
        $this->academicYearData();

        //seed common settings
        echo PHP_EOL , 'seeding institute settings...';
        $this->instituteSettingsData();

        //seed class
        echo PHP_EOL , 'seeding class...';
        $this->classData();

        //seed teacher
        echo PHP_EOL , 'seeding teacher...';
        $this->teacherData();

        //seed section
        echo PHP_EOL , 'seeding section...';
        $this->sectionData();

        //seed subject
        echo PHP_EOL , 'seeding subject...';
        $this->subjectData();

        //seed student
        echo PHP_EOL , 'seeding student...';
        $this->studentData();

        echo PHP_EOL , 'seeding completed.';

    }


    private function deletePreviousData(){
        /***
         * This code is MYSQL specific
         */
        DB::statement("SET foreign_key_checks=0");
        $this->deleteUserData();
        AcademicYear::truncate();
        AppMeta::truncate();
        IClass::truncate();
        Employee::truncate();
        Section::truncate();
        \App\Subject::truncate();
        \App\Student::truncate();
        \App\Registration::truncate();
        DB::statement("SET foreign_key_checks=1");

        //delete images
        $storagePath = storage_path('app/public');
        $storagePath2 = storage_path('app');
        $dirs = [
            $storagePath.'/admission',
            $storagePath.'/employee',
            $storagePath.'/invoice',
            $storagePath.'/leave',
            $storagePath.'/logo',
            $storagePath.'/payroll',
            $storagePath.'/report',
            $storagePath.'/student',
            $storagePath.'/work_outside',
            $storagePath2.'/student-attendance',
            $storagePath2.'/employee-attendance',
        ];

        foreach ($dirs as $dir){
            system("rm -rf ".escapeshellarg($dir));
        }
    }

    private function userData(){
        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $users = factory(App\User::class, 3)
            ->create(['created_by' => $created_by,'created_at' => $created_at]);
        $users->each(function ($user) use($created_at, $created_by) {
            \App\UserRole::create([
                'user_id' => $user->id,
                'role_id' => rand(2,7),
                'created_by' => $created_by,
                'created_at' => $created_at

            ]);
        });
    }

    private function deleteUserData(){
        $userIds = \App\UserRole::where('role_id','!=', AppHelper::USER_ADMIN)->pluck('user_id');
        DB::table('users_permissions')->whereIn('user_id', $userIds)->delete();
        DB::table('user_roles')->whereIn('user_id', $userIds)->delete();
        DB::table('users')->whereIn('id', $userIds)->delete();

    }

    private function academicYearData(){
        $data['title'] = date('Y');
        $data['start_date'] = Carbon::createFromFormat('d/m/Y', '01/01/'.date('Y'));;
        $data['end_date'] = Carbon::createFromFormat('d/m/Y', '31/12/'.date('Y'));
        $data['status'] = '1';

        AcademicYear::create($data);
    }

    private function instituteSettingsData()
    {
        $originFilePath = resource_path('assets/backend/images/');
        $destinationPath = storage_path('app').'/public/logo/';

        if(!is_dir($destinationPath)) {
            mkdir($destinationPath);
        }

        $fileName = 'logo-md.png';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        $data['logo'] = $fileName;

        $fileName = 'logo-xs.png';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        $data['logo_small'] = $fileName;

        $fileName = 'favicon.png';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        $data['favicon'] = $fileName;


        $data['name'] = 'CloudSchool BD';
        $data['short_name'] = 'CSBD';
        $data['establish'] = '2010';
        $data['website_link'] = 'http://cloudschoolbd.com';
        $data['email'] = 'info@cloudschoolbd.com';
        $data['phone_no'] = '+8801554322707';
        $data['address'] = 'Dhanmondi,Dhaka-1207';

        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        //now create
        AppMeta::create([
            'meta_key' => 'institute_settings',
            'meta_value' => json_encode($data),
            'created_by' => $created_by,
            'created_at' => $created_at
        ]);

        if(AppHelper::getInstituteCategory() != 'college') {
            AppMeta::create([
                'meta_key' => 'academic_year',
                'meta_value' => 1,
                'created_by' => $created_by,
                'created_at' => $created_at
            ]);
        }

        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));
        $shiftData = [
            'Morning' => [
                'start' => '08:00 am',
                'end' => '01:00 pm',
            ],
            'Day' => [
                'start' => '02:00 pm',
                'end' => '07:00 pm',
            ],
            'Evening' => [
                'start' => '12:00 am',
                'end' => '12:00 am',
            ]
        ];
        $insertData = [
            ['meta_key' => 'frontend_website' ,'meta_value' => 1, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'language', 'meta_value' =>  'en', 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'disable_language', 'meta_value' => 1, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'institute_type', 'meta_value' => 1, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'shift_data', 'meta_value' => json_encode($shiftData), 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'weekends', 'meta_value' => json_encode([5]), 'created_by' => $created_by, 'created_at' => $created_at]
        ];

        AppMeta::insert($insertData);
    }

    private function classData(){
        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $insertData = [
            [
                'name' => 'One',
                'numeric_value' => 1,
                'order' => 1,
                'group' => 'None',
                'status' => '1',
                'note' => 'demo test',
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Two',
                'numeric_value' => 2,
                'order' => 2,
                'group' => 'None',
                'status' => '1',
                'note' => 'demo test',
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Three',
                'numeric_value' => 3,
                'order' => 3,
                'group' => 'None',
                'status' => '1',
                'note' => 'demo test',
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Four',
                'numeric_value' => 4,
                'order' => 4,
                'group' => 'None',
                'status' => '1',
                'note' => 'demo test',
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Five',
                'numeric_value' => 5,
                'order' => 5,
                'group' => 'None',
                'status' => '1',
                'note' => 'demo test',
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Six',
                'numeric_value' => 6,
                'order' => 6,
                'group' => 'None',
                'status' => '1',
                'note' => 'demo test',
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Seven',
                'numeric_value' => 7,
                'order' => 7,
                'group' => 'None',
                'status' => '1',
                'note' => 'demo test',
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Eight',
                'numeric_value' => 8,
                'order' => 8,
                'group' => 'None',
                'status' => '1',
                'note' => 'demo test',
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Nine Science',
                'numeric_value' => 90,
                'order' => 9,
                'group' => 'Science',
                'status' => '1',
                'note' => 'demo test',
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Nine Humanities',
                'numeric_value' => 91,
                'order' => 10,
                'group' => 'Humanities',
                'status' => '1',
                'note' => 'demo test',
                'created_by' => $created_by,
                'created_at' => $created_at
            ],

        ];

        IClass::insert($insertData);
    }

    private function teacherData() {

        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $teachers = factory(App\Employee::class, 5)
            ->create(['created_by' => $created_by,'created_at' => $created_at]);

        $teachers->each(function ($teacher) use($created_at, $created_by) {
            \App\UserRole::create([
                'user_id' => $teacher->user_id,
                'role_id' => AppHelper::USER_TEACHER,
                'created_by' => $created_by,
                'created_at' => $created_at

            ]);
        });
    }

    private function sectionData() {
        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $section = factory(App\Section::class, 5)
            ->create(['created_by' => $created_by,'created_at' => $created_at]);

        $section = factory(App\Section::class, 2)
            ->create(['class_id'=> 2, 'created_by' => $created_by,'created_at' => $created_at]);

        $section = factory(App\Section::class, 2)
            ->create(['class_id'=> 3, 'created_by' => $created_by,'created_at' => $created_at]);

        $section = factory(App\Section::class, 2)
            ->create(['class_id'=> 4, 'created_by' => $created_by,'created_at' => $created_at]);

        $section = factory(App\Section::class)
            ->create(['class_id'=> 1, 'name' => 'A', 'created_by' => $created_by,'created_at' => $created_at]);

        $section = factory(App\Section::class)
            ->create(['class_id'=> 1, 'name' => 'B', 'created_by' => $created_by,'created_at' => $created_at]);

        $section = factory(App\Section::class)
            ->create(['class_id'=> 1, 'name' => 'C', 'created_by' => $created_by,'created_at' => $created_at]);
    }

    private function subjectData() {
        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $subject = factory(App\Subject::class, 10)
            ->create(['created_by' => $created_by,'created_at' => $created_at]);

        $subject = factory(App\Subject::class)
            ->create(['class_id'=> 1, 'type' => 1, 'name' => 'Bangla', 'code' => '110', 'created_by' => $created_by,'created_at' => $created_at]);

        $subject = factory(App\Subject::class)
            ->create(['class_id'=> 1, 'type' => 1, 'name' => 'English', 'code' => '111', 'created_by' => $created_by,'created_at' => $created_at]);

        $subject = factory(App\Subject::class)
            ->create(['class_id'=> 1, 'type' => 1, 'name' => 'Math', 'code' => '112', 'created_by' => $created_by,'created_at' => $created_at]);

    }

    private function studentData() {
        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $students = factory(App\Student::class, 15)
            ->create(['created_by' => $created_by,'created_at' => $created_at]);

        $students->each(function ($student) use($created_at, $created_by) {
            \App\UserRole::create([
                'user_id' => $student->user_id,
                'role_id' => AppHelper::USER_STUDENT,
                'created_by' => $created_by,
                'created_at' => $created_at

            ]);
        });

        //now register student to classes

        $studentIds = $students->pluck('id');
        $academicYearInfo = AcademicYear::where('id',1)->first();

        $class1Info = IClass::where('id', 1)->first();
        $class1Sections = Section::where('class_id', $class1Info->id)->orderBy('name', 'asc')->take(1)->pluck('id');

        $class2Info = IClass::where('id', 2)->first();
        $class2Sections = Section::where('class_id', $class2Info->id)->orderBy('name', 'asc')->take(1)->pluck('id');

        $class3Info = IClass::where('id', 3)->first();
        $class3Sections = Section::where('class_id', $class3Info->id)->orderBy('name', 'asc')->take(1)->pluck('id');

        $class4Info = IClass::where('id', 4)->first();
        $class4Sections = Section::where('class_id', $class4Info->id)->orderBy('name', 'asc')->take(1)->pluck('id');


        $counter = 1;
        foreach ($studentIds as $studentId){

            //distribute 5 student for class id 1
            if($counter <= 5){

                $regiNo = $academicYearInfo->start_date->format('y') . (string)$class1Info->numeric_value;
                $totalStudent = \App\Registration::where('academic_year_id', $academicYearInfo->id)
                    ->where('class_id', $class1Info->id)->withTrashed()->count();
                $regiNo .= str_pad(++$totalStudent,3,'0',STR_PAD_LEFT);

                $registrationData = [
                    'regi_no' => $regiNo,
                    'student_id' => $studentId,
                    'class_id' => $class1Info->id,
                    'section_id' => $class1Sections[0],
                    'academic_year_id' => $academicYearInfo->id,
                    'roll_no' => $studentId,
                    'shift'    => 'Morning',
                    'card_no'    => null,
                    'board_regi_no' => null,
                    'fourth_subject' => 0,
                    'alt_fourth_subject' => 0,
                    'house' => null,
                    'status' => '1',
                    'created_by' => $created_by,
                    'created_at' => $created_at
                ];


            }
            //distribute 4 student for class id 2
            elseif($counter > 5 && $counter <= 9){
                $regiNo = $academicYearInfo->start_date->format('y') . (string)$class2Info->numeric_value;
                $totalStudent = \App\Registration::where('academic_year_id', $academicYearInfo->id)
                    ->where('class_id', $class2Info->id)->withTrashed()->count();
                $regiNo .= str_pad(++$totalStudent,3,'0',STR_PAD_LEFT);

                $registrationData = [
                    'regi_no' => $regiNo,
                    'student_id' => $studentId,
                    'class_id' => $class2Info->id,
                    'section_id' => $class2Sections[0],
                    'academic_year_id' => $academicYearInfo->id,
                    'roll_no' => $studentId,
                    'shift'    => 'Morning',
                    'card_no'    => null,
                    'board_regi_no' => null,
                    'fourth_subject' => 0,
                    'alt_fourth_subject' => 0,
                    'house' => null,
                    'status' => '1',
                    'created_by' => $created_by,
                    'created_at' => $created_at
                ];

            }
            //distribute 3 student for class id 3
            elseif($counter > 9 && $counter <= 12){
                $regiNo = $academicYearInfo->start_date->format('y') . (string)$class3Info->numeric_value;
                $totalStudent = \App\Registration::where('academic_year_id', $academicYearInfo->id)
                    ->where('class_id', $class3Info->id)->withTrashed()->count();
                $regiNo .= str_pad(++$totalStudent,3,'0',STR_PAD_LEFT);

                $registrationData = [
                    'regi_no' => $regiNo,
                    'student_id' => $studentId,
                    'class_id' => $class3Info->id,
                    'section_id' => $class3Sections[0],
                    'academic_year_id' => $academicYearInfo->id,
                    'roll_no' => $studentId,
                    'shift'    => 'Morning',
                    'card_no'    => null,
                    'board_regi_no' => null,
                    'fourth_subject' => 0,
                    'alt_fourth_subject' => 0,
                    'house' => null,
                    'status' => '1',
                    'created_by' => $created_by,
                    'created_at' => $created_at
                ];
            }
            //distribute 3 student for class id 4
            else{

                $regiNo = $academicYearInfo->start_date->format('y') . (string)$class4Info->numeric_value;
                $totalStudent = \App\Registration::where('academic_year_id', $academicYearInfo->id)
                    ->where('class_id', $class4Info->id)->withTrashed()->count();
                $regiNo .= str_pad(++$totalStudent,3,'0',STR_PAD_LEFT);

                $registrationData = [
                    'regi_no' => $regiNo,
                    'student_id' => $studentId,
                    'class_id' => $class4Info->id,
                    'section_id' => $class4Sections[0],
                    'academic_year_id' => $academicYearInfo->id,
                    'roll_no' => $studentId,
                    'shift'    => 'Morning',
                    'card_no'    => null,
                    'board_regi_no' => null,
                    'fourth_subject' => 0,
                    'alt_fourth_subject' =>  0,
                    'house' => null,
                    'status' => '1',
                    'created_by' => $created_by,
                    'created_at' => $created_at
                ];

            }

            \App\Registration::insert([$registrationData]);
            $counter++;
        }


    }

}
