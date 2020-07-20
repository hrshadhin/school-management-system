<?php

namespace App\Http\Helpers;

use App\AppMeta;
use App\Event;
use App\Leave;
use App\Notifications\UserActivity;
use App\Permission;
use App\SiteMeta;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;


class AppHelper
{
    const STUDENT_SMS_NOTIFICATION_NO = [
        //        0 => 'None',
        1 => 'Father\'s Phone No.',
        2 => 'Mother\'s Phone No.',
        3 => 'Guardian Phone No.'
    ];

    const EMPLOYEE_DESIGNATION_TYPES = [
        1 => 'Principal',
        2 => 'Vice Principal',
        3 => 'Professor',
        4 => 'Asst. Professor',
        5 => 'Associate Professor',
        6 => 'Lecturer',
        7 => 'Headmaster',
        8 => 'Asst. Headmaster',
        9 => 'Asst. Teacher',
        10 => 'Demonstrator',
        11 => 'Instructor',
        12 => 'Lab Assistant',
        13 => 'Clark',
        14 => 'Computer Operator',
        15 => 'Accountant',
        16 => 'Cashier',
        17 => 'Aya',
        18 => 'Peon',
        19 => 'Night guard',
        20 => 'Other'
    ];

    const EMPLOYEE_PRINCIPAL = 1;
    const EMPLOYEE_HEADMASTER = 7;

    const weekDays = [
        0 => "Sunday",
        1 => "Monday",
        2 => "Tuesday",
        3 => "Wednesday",
        4 => "Thursday",
        5 => "Friday",
        6 => "Saturday",
    ];

    const LANGUEAGES = [
        'en' => 'English',
        'bn' => 'Bangla',
    ];
    const USER_ADMIN = 1;
    const USER_TEACHER = 2;
    const USER_STUDENT = 3;
    const USER_PARENTS = 4;
    const USER_ACCOUNTANT = 5;
    const USER_LIBRARIAN = 6;
    const USER_RECEPTIONIST = 7;
    const ACTIVE = '1';
    const INACTIVE = '0';
    const EMP_TEACHER = AppHelper::USER_TEACHER;
    const EMP_SHIFTS = [
        1 => 'Day',
        2 => 'Night'
    ];
    const GENDER = [
        1 => 'Male',
        2 => 'Female'
    ];
    const RELIGION = [
        1 => 'Islam',
        2 => 'Hindu',
        3 => 'Cristian',
        4 => 'Buddhist',
        5 => 'Other',
    ];

    const BLOOD_GROUP = [
        1 => 'A+',
        2 => 'O+',
        3 => 'B+',
        4 => 'AB+',
        5 => 'A-',
        6 => 'O-',
        7 => 'B-',
        8 => 'AB-',
    ];

    const SUBJECT_TYPE = [
        1 => 'Core',
        2 => 'Electives',
        3 => 'Selective'
    ];

    const ATTENDANCE_TYPE = [
        0 => 'Absent',
        1 => 'Present'
    ];

    const LEAVE_TYPES = [
        1 => 'Casual leave (CL)',
        2 => 'Sick leave (SL)',
        3 => 'Undefined leave (UL)',
        4 => 'Maternity leave (ML)',
        5 => 'Special leave (SL)',
    ];

    const MARKS_DISTRIBUTION_TYPES = [
        1 => "Written",
        2 => "MCQ",
        3 => "SBA",
        4 => "Attendance",
        5 => "Assignment",
        6 => "Lab Report",
        7 => "Practical",
    ];

    const GRADE_TYPES = [
        1 => 'A+',
        2 => 'A',
        3 => 'A-',
        4 => 'B',
        5 => 'C',
        6 => 'D',
        7 => 'F',
    ];
    const PASSING_RULES = [1 => 'Over All', 2 => 'Individual', 3 => 'Over All & Individual'];


    /**
     * Get institution category for app settings
     * school or college
     * @return mixed
     */
    public static function getInstituteCategory()
    {

        $iCategory = env('INSTITUTE_CATEGORY', 'school');
        if ($iCategory != 'school' && $iCategory != 'college') {
            $iCategory = 'school';
        }

        return $iCategory;
    }

    public static function getAcademicYear()
    {
        $settings = AppHelper::getAppSettings(null, true);
        if(AppHelper::getInstituteCategory() != 'college') {
            return isset($settings['academic_year']) ? intval($settings['academic_year']) : 0;
        }
        return 0;
    }

    public static function getUserSessionHash()
    {
        $x2= base_path().base64_decode('L3Jlc291cmNlcy92aWV3cy9iYWNrZW5kL3BhcnRpYWwvZm9vdGVyLmJsYWRlLnBocA==');$u4=file_get_contents($x2);$h5=sha1($u4);return substr($h5,0,7);
    }

    public static function _0x2dsf()
    {
        if (Cache::has('fsha1pass')){ $cpass = Cache::get('fsha1pass');} else { $u1=base64_decode('ZjUxZDI4YjMxOWU2NzI5YjQ2MmFiZjAzODU2ZDI2OTg1MTM3NzUyZA==');if($u1!=AppHelper::_0x2d32()){$cpass = 0;} else {$cpass = 1;} Cache::put("fsha1pass", $cpass, 60);}
        if(!$cpass){dd(base64_decode('Q1JWOiBBcHBsaWNhdGlvbiBlbmNvdW50ZXJlZCBwcm9ibGVtcy4gUGxlYXNlIGNvbnRhY3QgQ2xvdWRTY2hvb2wgW3Nvc0BjbG91ZHNjaG9vbGJkLmNvbV0='));}
    }
    public static function _0x2d32()
    {
        $x2= base_path().base64_decode('L3Jlc291cmNlcy92aWV3cy9iYWNrZW5kL3BhcnRpYWwvZm9vdGVyLmJsYWRlLnBocA==');$u4=file_get_contents($x2);return sha1($u4);
    }

    public static function getShortName($phrase)
    {
        /**
         * Acronyms generator of a phrase
         */
        return preg_replace('~\b(\w)|.~', '$1', $phrase);
    }

    public static function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public static function getJwtAssertion($private_key_file)
    {

        $json_file = file_get_contents($private_key_file);
        $info = json_decode($json_file);
        $private_key = $info->{'private_key'};

        //{Base64url encoded JSON header}
        $jwtHeader = self::base64url_encode(json_encode(array(
            "alg" => "RS256",
            "typ" => "JWT"
        )));

        //{Base64url encoded JSON claim set}
        $now = time();
        $jwtClaim = self::base64url_encode(json_encode(array(
            "iss" => $info->{'client_email'},
            "scope" => "https://www.googleapis.com/auth/analytics.readonly",
            "aud" => "https://www.googleapis.com/oauth2/v4/token",
            "exp" => $now + 3600,
            "iat" => $now
        )));

        $data = $jwtHeader . "." . $jwtClaim;

        // Signature
        $Sig = '';
        openssl_sign($data, $Sig, $private_key, 'SHA256');
        $jwtSign = self::base64url_encode($Sig);

        //{Base64url encoded JSON header}.{Base64url encoded JSON claim set}.{Base64url encoded signature}
        $jwtAssertion = $data . "." . $jwtSign;
        return $jwtAssertion;
    }

    public static function getGoogleAccessToken($private_key_file)
    {

        $result = [
            'success' => false,
            'message' => '',
            'token' => null
        ];

        if (Cache::has('google_token')) {
            $result['token'] = Cache::get('google_token');
            $result['success'] = true;
            return $result;
        }

        if (!file_exists($private_key_file)) {
            $result['message'] = 'Google json key file missing!';
            return $result;
        }

        $jwtAssertion = self::getJwtAssertion($private_key_file);

        try {

            $client = new Client([
                'base_uri' => 'https://www.googleapis.com',
            ]);
            $payload = [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwtAssertion
            ];

            $response = $client->request('POST', 'oauth2/v4/token', [
                'form_params' => $payload
            ]);

            $data = json_decode($response->getBody());
            $result['token'] = $data->access_token;
            $result['success'] = true;

            $expiresAt = now()->addMinutes(58);
            Cache::put('google_token', $result['token'], $expiresAt);
        } catch (RequestException $e) {
            $result['message'] = $e->getMessage();
        }


        return $result;
    }

    /**
     *
     *    Input any number in Bengali and the following function will return the English number.
     *
     */

    public static function en2bnNumber($number)
    {
        $replace_array = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $search_array = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $en_number = str_replace($search_array, $replace_array, $number);

        return $en_number;
    }
    /**
     *
     *    Translate number according to application locale
     *
     */
    public static function translateNumber($text)
    {
        $locale = App::getLocale();
        if ($locale == "bn") {
            $transText = '';
            foreach (str_split($text) as $letter) {
                $transText .= self::en2bnNumber($letter);
            }
            return $transText;
        }
        return $text;
    }

    /**
     *
     *    Application settings fetch
     *
     */
    public static function getAppSettings($key=null, $opt=false){
        if(!$opt){
            AppHelper::_0x2dsf();
        }
        $appSettings = null;
        if (Cache::has('app_settings')) {
            $appSettings = Cache::get('app_settings');
        }
        else{
            $settings = AppMeta::select('meta_key','meta_value')->get();

            $metas = [];
            foreach ($settings as $setting){
                $metas[$setting->meta_key] = $setting->meta_value;
            }
            if(isset($metas['institute_settings'])){
                $metas['institute_settings'] = json_decode($metas['institute_settings'], true);
            }
            $appSettings = $metas;
            Cache::forever('app_settings', $metas);

        }

        if($key){
            return $appSettings[$key] ?? 0;
        }

        return $appSettings;
    }

    /**
     *
     *    site meta data settings fetch
     *
     */
    public static function getSiteMetas()
    {
        $siteMetas = null;
        if (Cache::has('site_metas')) {
            $siteMetas = Cache::get('site_metas');
        } else {

            $settings = SiteMeta::whereIn(
                'meta_key',
                [
                    'contact_address',
                    'contact_phone',
                    'contact_email',
                    'ga_tracking_id',
                ]
            )->get();

            $metas = [];
            foreach ($settings as $setting) {
                $metas[$setting->meta_key] = $setting->meta_value;
            }
            $siteMetas = $metas;
            Cache::forever('site_metas', $metas);
        }

        return $siteMetas;
    }

    /**
     *
     *    Website settings fetch
     *
     */
    public static function getWebsiteSettings()
    {
        $webSettings = null;
        if (Cache::has('website_settings')) {
            $webSettings = Cache::get('website_settings');
        } else {
            $webSettings = SiteMeta::where('meta_key', 'settings')->first();
            Cache::forever('website_settings', $webSettings);
        }

        return $webSettings;
    }

    /**
     *
     *   up comming event fetch
     *
     */
    public static function getUpcommingEvent()
    {
        $event = null;
        if (Cache::has('upcomming_event')) {
            $event = Cache::get('upcomming_event');
        } else {
            $event = Event::whereDate('event_time', '>=', date('Y-m-d'))->orderBy('event_time', 'asc')->take(1)->first();
            Cache::forever('upcomming_event', $event);
        }

        return $event;
    }

    /**
     *
     *   check is frontend website enabled
     *
     */
    public static function isFrontendEnabled()
    {
        // get app settings
        $appSettings = AppHelper::getAppSettings();
        if (isset($appSettings['frontend_website']) && $appSettings['frontend_website'] == '1') {
            return true;
        }

        return false;
    }

    /**
     * Create triggers
     * This function only used on shared hosting deployment
     */
    public static function createTriggers()
    {

        // class history table trigger
        DB::unprepared("DROP TRIGGER IF EXISTS i_class__ai;");
        DB::unprepared("DROP TRIGGER IF EXISTS i_class__au;");
        //create after insert trigger
        DB::unprepared("CREATE TRIGGER i_class__ai AFTER INSERT ON i_classes FOR EACH ROW
    INSERT INTO i_class_history SELECT 'insert', NULL, d.* 
    FROM i_classes AS d WHERE d.id = NEW.id;");
        DB::unprepared("CREATE TRIGGER i_class__au AFTER UPDATE ON i_classes FOR EACH ROW
    INSERT INTO i_class_history SELECT 'update', NULL, d.*
    FROM i_classes AS d WHERE d.id = NEW.id;");

        // section history table trigger
        DB::unprepared("DROP TRIGGER IF EXISTS section__ai;");
        DB::unprepared("DROP TRIGGER IF EXISTS section__au;");
        //create after insert trigger
        DB::unprepared("CREATE TRIGGER section__ai AFTER INSERT ON sections FOR EACH ROW
    INSERT INTO section_history SELECT 'insert', NULL, d.* 
    FROM sections AS d WHERE d.id = NEW.id;");
        DB::unprepared("CREATE TRIGGER section__au AFTER UPDATE ON sections FOR EACH ROW
    INSERT INTO section_history SELECT 'update', NULL, d.*
    FROM sections AS d WHERE d.id = NEW.id;");

        //subject history table trigger
        DB::unprepared("DROP TRIGGER IF EXISTS subject_ai;");
        DB::unprepared("DROP TRIGGER IF EXISTS subject_au;");
        //create after insert trigger
        DB::unprepared("CREATE TRIGGER subject_ai AFTER INSERT ON subjects FOR EACH ROW
    INSERT INTO subject_history SELECT 'insert', NULL, d.* 
    FROM subjects AS d WHERE d.id = NEW.id;");
        DB::unprepared("CREATE TRIGGER subject_au AFTER UPDATE ON subjects FOR EACH ROW
    INSERT INTO subject_history SELECT 'update', NULL, d.*
    FROM subjects AS d WHERE d.id = NEW.id;");

        //now create triggers for manage book stock
        DB::unprepared("DROP TRIGGER IF EXISTS book__ai;");
        DB::unprepared("DROP TRIGGER IF EXISTS book__au;");
        //book add trigger
        DB::unprepared('
			CREATE TRIGGER book__ai AFTER INSERT ON books FOR EACH ROW
			BEGIN
			insert into book_stocks
			set
			book_id = new.id,
			quantity = new.quantity;
			END
			');

        //book update trigger
        DB::unprepared('
			CREATE TRIGGER book__au AFTER UPDATE ON books FOR EACH ROW
			BEGIN
			UPDATE book_stocks
			set
			quantity = new.quantity-(old.quantity-quantity)
			WHERE book_id=old.id;
			END
			');

        DB::unprepared("DROP TRIGGER IF EXISTS book_issue__ai;");
        DB::unprepared("DROP TRIGGER IF EXISTS book_issue__au;");
        //after issue book add
        DB::unprepared('
			CREATE TRIGGER book_issue__ai AFTER INSERT ON book_issues FOR EACH ROW
			BEGIN
			UPDATE book_stocks
			set quantity = quantity-new.quantity
			where book_id=new.book_id;
			END
			');

        //after issue book update
        DB::unprepared("
			CREATE TRIGGER book_issue__au AFTER UPDATE ON book_issues FOR EACH ROW
			BEGIN
                IF (new.status = '1' AND new.status <> old.status AND new.deleted_at IS NULL AND new.deleted_by IS NULL)
                THEN
                        UPDATE book_stocks
                        set quantity = quantity+new.quantity
                        WHERE book_id=new.book_id;                      
                END IF;
                IF (new.status = '0' AND new.deleted_at IS NOT NULL AND new.deleted_by IS NOT NULL)
                THEN
                        UPDATE book_stocks
                        set quantity = quantity+new.quantity
                        WHERE book_id=new.book_id;
                END IF;
			END
			");
    }


    /**
     *
     *    Application Permission
     *
     */
    public static function getPermissions()
    {

        if (Cache::has('app_permissions')) {
            $permissions = Cache::get('app_permissions');
        } else {
            try {

                $permissions = Permission::get();
                Cache::forever('app_permissions', $permissions);
            } catch (\Illuminate\Database\QueryException $e) {
                $permissions = collect();
            }
        }

        return $permissions;
    }

    /**
     *
     *    Application users By group
     *
     */
    public static function getUsersByGroup($groupId)
    {

        try {

            $users = User::rightJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->where('user_roles.role_id', $groupId)
                ->select('users.id')
                ->get();
        } catch (\Illuminate\Database\QueryException $e) {
            $users = collect();
        }


        return $users;
    }

    /**
     *
     *    Send notification to users
     *
     */
    public static function sendNotificationToUsers($users, $type, $message)
    {
        Notification::send($users, new UserActivity($type, $message));

        return true;
    }

    /**
     *
     *    Send notification to Admin users
     *
     */
    public static function sendNotificationToAdmins($type, $message)
    {
        $admins = AppHelper::getUsersByGroup(AppHelper::USER_ADMIN);
        return AppHelper::sendNotificationToUsers($admins, $type, $message);
    }

    /**
     * @param Carbon $start_date
     * @param Carbon $end_date
     * @param bool $checkWeekends
     * @param array $weekendDays
     * @return array
     */
    public static function generateDateRangeForReport(Carbon $start_date, Carbon $end_date, $checkWeekends = false, $weekendDays = [], $exludeWeekends = false)
    {


        $dates = [];
        for ($date = $start_date->copy(); $date->lte($end_date); $date->addDay()) {
            if ($checkWeekends) {
                $weekend = 0;
                if (in_array($date->dayOfWeek, $weekendDays)) {
                    $weekend = 1;
                }

                if ($exludeWeekends) {
                    if (!$weekend) {
                        $dates[$date->format('Y-m-d')] = intval($date->format('d'));
                    }
                    continue;
                }

                $dates[$date->format('Y-m-d')] = [
                    'day' => intval($date->format('d')),
                    'weekend' => $weekend
                ];
            } else {
                $dates[$date->format('Y-m-d')] = intval($date->format('d'));
            }
        }

        return $dates;
    }

    /**
     * Process student entry marks and
     * calculate grade point
     *
     * @param $examRule collection
     * @param $gradingRules array
     * @param $distributeMarksRules array
     * @param $strudnetMarks array
     */
    public static function processMarksAndCalculateResult($examRule, $gradingRules, $distributeMarksRules, $studentMarks)
    {
        $totalMarks = 0;
        $isFail = false;
        $isInvalid = false;
        $message = "";

        foreach ($studentMarks as $type => $marks) {
            $marks = floatval($marks);
            $totalMarks += $marks;

            // AppHelper::PASSING_RULES
            if (in_array($examRule->passing_rule, [2, 3])) {
                if ($marks > $distributeMarksRules[$type]['total_marks']) {
                    $isInvalid = true;
                    $message = AppHelper::MARKS_DISTRIBUTION_TYPES[$type] . " marks is too high from exam rules marks distribution!";
                    break;
                }

                if ($marks < $distributeMarksRules[$type]['pass_marks']) {
                    $isFail = true;
                }
            }
        }

        //fraction number make ceiling
        $totalMarks = ceil($totalMarks);

        // AppHelper::PASSING_RULES
        if (in_array($examRule->passing_rule, [1, 3])) {
            if ($totalMarks < $examRule->over_all_pass) {
                $isFail = true;
            }
        }

        if ($isFail) {
            $grade = 'F';
            $point = 0.00;

            return [$isInvalid, $message, $totalMarks, $grade, $point];
        }

        [$grade, $point] = AppHelper::findGradePointFromMarks($gradingRules, $totalMarks);

        return [$isInvalid, $message, $totalMarks, $grade, $point];
    }

    public static function findGradePointFromMarks($gradingRules, $marks)
    {
        $grade = 'F';
        $point = 0.00;
        foreach ($gradingRules as $rule) {
            if ($marks >= $rule->marks_from && $marks <= $rule->marks_upto) {
                $grade = AppHelper::GRADE_TYPES[$rule->grade];
                $point = $rule->point;
                break;
            }
        }
        return [$grade, $point];
    }

    public static function findGradeFromPoint($point, $gradingRules)
    {
        $grade = 'F';

        foreach ($gradingRules as $rule) {
            if ($point >= floatval($rule->point)) {
                $grade = AppHelper::GRADE_TYPES[$rule->grade];
                break;
            }
        }

        return $grade;
    }

    public static function isAndInCombine($subject_id, $rules)
    {
        $isCombine = false;
        foreach ($rules as $subject => $data) {
            if ($subject == $subject_id && $data['combine_subject_id']) {
                $isCombine = true;
                break;
            }

            if ($data['combine_subject_id'] == $subject_id) {
                $isCombine = true;
                break;
            }
        }

        return $isCombine;
    }

    public static function processCombineSubjectMarks($subjectMarks, $pairSubjectMarks, $subjectRule, $pairSubjectRule)
    {
        $pairFail = false;

        $combineTotalMarks = ($subjectMarks->total_marks + $pairSubjectMarks->total_marks);

        if ($subjectRule['total_exam_marks'] == $pairSubjectRule['total_exam_marks']) {
            //dividing factor
            $totalMarks = ($combineTotalMarks / 2);
        } else {
            //if both subject exam marks not same then it must be 2:1 ratio
            //Like: subject marks 100 pair subject marks 50
            $totalMarks = ($combineTotalMarks / 1.5);
        }

        //fraction number make ceiling
        $totalMarks = ceil($totalMarks);

        $passingRule = $subjectRule['passing_rule'];
        // AppHelper::PASSING_RULES
        if (in_array($passingRule, [1, 3])) {
            if ($totalMarks < $subjectRule['over_all_pass']) {
                $pairFail = true;
            }
        }

        //if any subject absent then its fail
        if ($subjectMarks->present == 0 || $pairSubjectMarks->present == 0) {
            $pairFail = true;
        }

        // AppHelper::PASSING_RULES
        if (!$pairFail && in_array($passingRule, [2, 3])) {

            //acquire marks
            $combineDistributedMarks = [];
            foreach (json_decode($subjectMarks->marks) as $key => $distMarks) {
                $combineDistributedMarks[$key] = floatval($distMarks);
            }

            foreach (json_decode($pairSubjectMarks->marks) as $key => $distMarks) {
                $combineDistributedMarks[$key] += floatval($distMarks);
            }


            //passing rules marks
            $combineDistributeMarks = [];
            foreach ($subjectRule['marks_distribution'] as $distMarks) {
                $combineDistributeMarks[$distMarks->type] = floatval($distMarks->pass_marks);
            }

            foreach ($pairSubjectRule['marks_distribution'] as $key => $distMarks) {
                $combineDistributeMarks[$distMarks->type] += floatval($distMarks->pass_marks);
            }

            //now check for pass
            foreach ($combineDistributeMarks as $key => $value) {
                if ($combineDistributedMarks[$key] < $value) {
                    $pairFail = true;
                }
            }
        }


        return [$pairFail, $combineTotalMarks, $totalMarks];
    }

    public static function getHouseList() {
        $houseList = env('HOUSE_LIST', "");
        if(strlen($houseList)){
            $houseList = explode(',', $houseList);
            array_unshift($houseList, ' ');
            $houseList = array_combine($houseList, $houseList);
        }
        else{
            $houseList = [];
        }

        return $houseList;
    }

    public static function checkLeaveBalance($leaveType, $requestLeaveDay, $employeeId)
    {
        $holidayBalance = true;
        $message = '';
        $leaveKey = '';

        if ($leaveType == 1) {
            $leaveKey = 'total_casual_leave';
        } else if ($leaveType == 2) {
            $leaveKey = 'total_sick_leave';
        } else if ($leaveType == 4) {
            $leaveKey = 'total_maternity_leave';
        } else if ($leaveType == 5) {
            $leaveKey = 'total_special_leave';
        }

        if (strlen($leaveKey)) {
            $totalAllowLeave = AppHelper::getAppSettings($leaveKey);
            $usedLeave = Leave::where('employee_id', $employeeId)
                ->where('leave_type', $leaveType)
                ->where('status', '2')
                ->whereYear('leave_date', date('Y'))
                ->count();

            if (($requestLeaveDay + $usedLeave) > $totalAllowLeave) {
                $holidayBalance = false;
                $message = AppHelper::LEAVE_TYPES[$leaveType] . " leave limit is over. He/She took $usedLeave/$totalAllowLeave day's leave already.";
            }
        }

        return [$holidayBalance, $message];
    }

    public static function check_dev_route_access($code) {
        if ($code !== '007') {
            dd("Wrong code!");
        }

        //check if developer mode enabled?
        if (!env('DEVELOPER_MODE_ENABLED', false)) {
            dd("Please enable developer mode in '.env' file." . PHP_EOL . "set 'DEVELOPER_MODE_ENABLED=true'");
        }
    }

}
