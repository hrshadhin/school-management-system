<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\AppMeta;
use App\AcademicYear;
use App\Http\Helpers\AppHelper;
use App\IClass;
use App\Employee;
use App\Section;
use App\User;

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

        //seed teacher
        echo PHP_EOL , 'seeding section...';
        $this->sectionData();

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
                'start' => '12:00 am',
                'end' => '01:00 am',
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
            ['meta_key' => 'frontend_website' ,'meta_value' => 0, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'frontend_website' ,'meta_value' => 0, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'language', 'meta_value' =>  'en', 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'disable_language', 'meta_value' => 0, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'institute_type', 'meta_value' => 1, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'shift_data', 'meta_value' => json_encode($shiftData), 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'weekends', 'meta_value' => json_encode([0]), 'created_by' => $created_by, 'created_at' => $created_at]
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
                'group' => 'None',
                'status' => '1',
                'note' => 'demo test',
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Two',
                'numeric_value' => 2,
                'group' => 'None',
                'status' => '1',
                'note' => 'demo test',
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Nine Science',
                'numeric_value' => 90,
                'group' => 'Science',
                'status' => '1',
                'note' => 'demo test',
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Nine Humanities',
                'numeric_value' => 91,
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

    }

    private function sectionData() {

    }

}
