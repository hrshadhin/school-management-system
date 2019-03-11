<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\AppMeta;
use App\AcademicYear;
use App\Http\Helpers\AppHelper;
use App\IClass;

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

        //seed academic year
        echo PHP_EOL , 'seeding academic year...';
        $this->academicYearData();

        //seed common settings
        echo PHP_EOL , 'seeding institute settings...';
        $this->instituteSettingsData();

        //seed class
        echo PHP_EOL , 'seeding class...';
        $this->classData();

        echo PHP_EOL , 'seeding completed.';

    }


    private function deletePreviousData(){
        /***
         * This code is MYSQL specific
         */
        DB::statement("SET foreign_key_checks=0");
        AcademicYear::truncate();
        AppMeta::truncate();
        IClass::truncate();
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

        $insertData = [
            ['meta_key' => 'frontend_website' ,'meta_value' => 0, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'frontend_website' ,'meta_value' => 0, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'language', 'meta_value' =>  'en', 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'disable_language', 'meta_value' => 0, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'institute_type', 'meta_value' => 1, 'created_by' => $created_by, 'created_at' => $created_at]
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

}
