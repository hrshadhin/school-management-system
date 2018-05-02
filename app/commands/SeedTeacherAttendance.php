<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SeedTeacherAttendance extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'attendance:seedTeacher';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'automated teacher attendance seeder from txt file.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        // log something to storage/logs/teacherAttendance-date-xxxx.log
        \Log::useDailyFiles(storage_path().'/logs/teacherAttendance.log');

        //now fetch the file from web link and read it
        $fileUrl = "http://l4.school.test/attendance.txt";
        $errorMSG = null;
        $rawString=null;

        try{
            $rawString =  file_get_contents($fileUrl);
        }
        catch (Exception $e){
            $errorMSG = $e->getMessage();
            \Log::critical($errorMSG);
            return false;
        }


        $rawAtdnData = mb_split('\n', $rawString);
        //check if file has content of not
        if(count($rawAtdnData)) {

            //now parse data for date wise
            $dateWiseData = [];
            foreach ($rawAtdnData as $key => $value) {
                if (strlen($value)) {
                    $stringPart = mb_split(':', $value);
                    $dateWiseData[$stringPart[2]][] = [
                        'empId' => $stringPart[1],
                        'time' => $stringPart[3]
                    ];

                }
            }

            //now process data for one day
            foreach ($dateWiseData as $key => $oneDayData) {
                //build employee wise data
                $empWiseData = [];
                foreach ($oneDayData as $data) {
                    $empWiseData[$data['empId']][] = $data['time'];
                }

                $atndDate = $key;

                //now clean employee multiple entry
                $cleanEmpWiseData = [];
                foreach ($empWiseData as $empId => $entries) {
                    $entryCount = count($entries);
                    $inTime = $entries[0];
                    $outTime = $entryCount > 1 ? $entries[$entryCount - 1] : $inTime;
                    $tDiff = strtotime($outTime) - strtotime($inTime);
                    $hours = number_format(($tDiff / 3600), 2);
                    $cleanEmpWiseData[$empId] = [
                        'inTime' => $inTime,
                        'outTime' => $outTime,
                        'workingHours' => $hours
                    ];

                }

                //now push back one day data to $dateWiseDate  array
                $dateWiseData[$atndDate] = $cleanEmpWiseData;

            }

            //ready to insert data to db
            //fetch all teacher
            $allTeachers = \Teachers::where('isActive', 1)->lists('regNo', 'regNo');
            $totalTeacherInSystem = count($allTeachers);

            if($totalTeacherInSystem) {
                foreach ($dateWiseData as $date => $employees) {
                    $atd = new \DateTime(date('Ymd', strtotime($date)));
                    $atndDate = $atd->format('Y-m-d');
                    //check if this date data exists on db or not
                    $entryExists = \TeacherAttendance::whereDate('date', '=', $atndDate)->count();
                    if (!$entryExists) {
                        \DB::beginTransaction();
                        try {
                            //now build data array for insert into db table
                            foreach ($allTeachers as $key => $value) {
                                if (array_key_exists($key, $employees)) {
                                    $atndData = [
                                        'regNo' => $key,
                                        'date' => $atndDate,
                                        'dIN_TIME' => date('H:i:s', strtotime($employees[$key]['inTime'])),
                                        'dOUT_TIME' => date('H:i:s', strtotime($employees[$key]['outTime'])),
                                        'nWorkingHOUR' => $employees[$key]['workingHours'],
                                        'vSTATUS' => "P"
                                    ];
                                } else {
                                    $atndData = [
                                        'regNo' => $key,
                                        'date' => $atndDate,
                                        'dIN_TIME' => date('H:i:s', strtotime("000000")),
                                        'dOUT_TIME' => date('H:i:s', strtotime("000000")),
                                        'nWorkingHOUR' => 0.00,
                                        'vSTATUS' => "A"
                                    ];
                                }
                                $atndData['created_at'] = new \DateTime();
                                \TeacherAttendance::insert($atndData);

                            }

                            \DB::commit();
                            $msg =  "Date '".$atd->format('d/m/Y')."' Total ".$totalTeacherInSystem." entry successfully stored.";
                            \Log::info($msg);

                        }catch (\Exception $e) {
                            \DB::rollback();
                            $msg =  "Date '".$atd->format('d/m/Y')."' data insert problem. ".$e->getMessage();
                            \Log::error($msg);
                        }


                        //write log in more entry found rather than db teachear list
                        $totalTeacherInFile = count($employees);
                        if($totalTeacherInSystem<$totalTeacherInFile) {
                            $msg =   "Date '".$atd->format('d/m/Y')."' > ".($totalTeacherInFile-$totalTeacherInSystem)." teacher not found in db but found in attendance.txt file!";
                            \Log::warning($msg);
                        }

                    } else {
                        $msg =  "Date '".$atd->format('d/m/Y')."' data already exists in the system!";
                        \Log::warning($msg);
                    }



                }
            }
            else{
                \Log::warning("Teachers not found on Database!");
            }

        }
        else{
            \Log::warning("File has no contents!");
        }


        echo "\n========Task Complete========\n";
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
    }

}
