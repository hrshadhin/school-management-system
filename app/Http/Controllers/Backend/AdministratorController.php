<?php

namespace App\Http\Controllers\Backend;

use App\Http\Helpers\AppHelper;
use App\Permission;
use App\Registration;
use App\User;
use App\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AcademicYear;
use Illuminate\Support\Facades\DB;


class AdministratorController extends Controller
{
    /**
     * academic year  manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function academicYearIndex(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {//
            $this->validate($request, [
                'hiddenId' => 'required|integer',
            ]);
            $year = AcademicYear::findOrFail($request->get('hiddenId'));

            // now check is academic year set or not
            $settings = AppHelper::getAppSettings();
            $haveStudent = Registration::where('academic_year_id', $year->id)->count();
            if((isset($settings['academic_year']) && (int)$settings['academic_year'] == $year->id) || ($haveStudent > 0)){
                return redirect()->route('administrator.academic_year')->with('error', 'Can not delete it because this year have student or have in default setting.');
            }
            $year->delete();

            return redirect()->route('administrator.academic_year')->with('success', 'Record deleted!');
        }


        //for ajax request

        if($request->ajax()){
            //for promotion
            $currentAcademicYearId = $request->query->get('current_academic_year_id',0);
            $academicYears = AcademicYear::where('status', AppHelper::ACTIVE)
                ->when($currentAcademicYearId, function ($query) use($currentAcademicYearId){
                    $query->where('id', '!=', $currentAcademicYearId);
                })
                ->orderBy('id', 'desc')
                ->select('id','title as text')
                ->get();

            return response()->json($academicYears);

        }

        //for get request
        $academicYears = AcademicYear::orderBy('id', 'desc')->get();

        return view('backend.administrator.academic.list', compact('academicYears'));
    }

    /**
     * academic year  manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function academicYearCru(Request $request, $id=0)
    {
        //for save on POST request
        if ($request->isMethod('post')) {
            ;
            $this->validate($request, [
                'title' => 'required|min:4|max:255',
                'start_date' => 'required|min:10|max:255',
                'end_date' => 'required|min:10|max:255',
            ]);

            $data = $request->all();
            $datetime = Carbon::createFromFormat('d/m/Y',$data['start_date']);
            $data['start_date'] = $datetime;
            $datetime = Carbon::createFromFormat('d/m/Y',$data['end_date']);
            $data['end_date'] = $datetime;
            if($request->has('is_open_for_admission')){
                $data['is_open_for_admission'] = 1;
            }
            else{
                $data['is_open_for_admission'] = 0;
            }
            if(!$id){
                $data['status'] = '1';
            }

            AcademicYear::updateOrCreate(
                ['id' => $id],
                $data
            );
            $msg = "Academic year ";
            $msg .= $id ? 'updated.' : 'added.';

            return redirect()->route('administrator.academic_year')->with('success', $msg);
        }

        //for get request
        $academicYear = AcademicYear::find($id);
        $is_open_for_admission = 0;
        if($academicYear){
            $is_open_for_admission = $academicYear->is_open_for_admission;
        }

        return view('backend.administrator.academic.add', compact('academicYear','is_open_for_admission'));
    }

    /**
     * academic year  manage
     *
     * @param Request $request
     * @return array
     */
    public function academicYearChangeStatus(Request $request, $id=0)
    {
        $year =  AcademicYear::findOrFail($id);
        if(!$year){
            return [
                'success' => false,
                'message' => 'Record not found!'
            ];
        }

        $settings = AppHelper::getAppSettings();
        if(isset($settings['academic_year']) && (int)$settings['academic_year'] == $year->id){
            return [
                'success' => false,
                'message' => 'Can not change status! Year is using as academic year right now.'
            ];
        }

        $year->status = (string)$request->get('status');

        $year->save();

        return [
            'success' => true,
            'message' => 'Status updated.'
        ];

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userIndex()
    {

        $users = User::rightJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->leftJoin('roles', 'user_roles.role_id', '=', 'roles.id')
            ->where('user_roles.role_id', '=', AppHelper::USER_ADMIN)
            ->where('users.is_super_admin', false)
            ->select('users.*','roles.name as role')
            ->get();

        return view('backend.administrator.user.list', compact('users'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userCreate()
    {
        $user = null;
        return view('backend.administrator.user.add', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userStore(Request $request)
    {

        $this->validate(
            $request, [
                'name' => 'required|min:5|max:255',
                'email' => 'email|max:255|unique:users,email',
                'username' => 'required|min:5|max:255|unique:users,username',
                'password' => 'required|min:6|max:50',
                'phone_no' => 'nullable|max:15',

            ]
        );

        $data = $request->all();


        DB::beginTransaction();
        try {
            //now create user
            $user = User::create(
                [
                    'name' => $data['name'],
                    'username' => $request->get('username'),
                    'email' => $data['email'],
                    'phone_no' => $data['phone_no'],
                    'password' => bcrypt($request->get('password')),
                    'remember_token' => null,
                ]
            );
            //now assign the user to role
            UserRole::create(
                [
                    'user_id' => $user->id,
                    'role_id' => AppHelper::USER_ADMIN
                ]
            );

            DB::commit();
            return redirect()->route('administrator.user_create')->with('success', 'System User added!');

        }
        catch(\Exception $e){
            DB::rollback();
            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
            return redirect()->route('administrator.user_create')->with("error",$message);
        }

    }

    public function useredit($id)
    {

        $user = User::rightJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id', '=', AppHelper::USER_ADMIN)
            ->where('users.id', $id)
            ->where('users.is_super_admin', false)
            ->select('users.*','user_roles.role_id')
            ->first();

        if(!$user){
            abort(404);
        }


        return view('backend.administrator.user.add', compact('user'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function userUpdate(Request $request, $id)
    {
        $user = User::rightJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id', '=', AppHelper::USER_ADMIN)
            ->where('users.id', $id)
            ->where('users.is_super_admin', false)
            ->select('users.*','user_roles.role_id')
            ->first();

        if(!$user){
            abort(404);
        }

        //validate form
        $this->validate(
            $request, [
                'name' => 'required|min:5|max:255',
                'email' => 'email|max:255|unique:users,email,'.$user->id,
                'phone_no' => 'nullable|max:15',
            ]
        );

        $data['name'] = $request->get('name');
        $data['email'] = $request->get('email');
        $data['phone_no'] = $request->get('phone_no');
        $user->fill($data);
        $user->save();

        return redirect()->route('administrator.user_index')->with('success', 'System User updated!');


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userDestroy($id)
    {

        $user =  User::where('is_super_admin', false)->where('id', $id)->first();
        if(!$user){
            abort(404);
        }

        if($user->id == auth()->user()->id){
            return redirect()->route('administrator.user_index')->with('error', 'You can\'t delete yourself!');

        }


        $userRole = UserRole::where('user_id', $user->id)
            ->first();

        if(!$userRole){
            return redirect()->route('administrator.user_index')->with('error', 'Don not mess with the system');

        }

        $user->delete();
        return redirect()->route('administrator.user_index')->with('success', 'Admin user deleted.');

    }

    /**
     * status change
     * @return mixed
     */
    public function userChangeStatus(Request $request, $id=0)
    {

        $user =  User::where('is_super_admin', false)->where('id', $id)->first();

        if(!$user){
            return [
                'success' => false,
                'message' => 'Record not found!'
            ];
        }

        if($user->id == auth()->user()->id){
            return [
                'success' => false,
                'message' => 'You can\'t change your own status!'
            ];

        }

        $status = (string)$request->get('status');

        $user->status = $status;
        $user->force_logout = (int)$status ? 0 : 1;
        $user->save();

        return [
            'success' => true,
            'message' => 'Status updated.'
        ];

    }

    /* Handle an user password change
    *
    * @return Response
    */
    public function userResetPassword(Request $request)
    {

        if ($request->isMethod('post')) {

            //validate form
            $this->validate($request, [
                'password' => 'required|confirmed|min:6|max:50',
            ]);

            $user = User::where('is_super_admin', false)->where('id', $request->get('user_id'))->first();
            if(!$user){
                abort(404);
            }

            $user->password = bcrypt($request->get('password'));
            $user->force_logout = 1;
            $user->save();

            return redirect()->route('administrator.user_password_reset')->with('success', 'Password successfully changed.');

        }

        $users = User::select(DB::raw("CONCAT(name,'[',username,']') AS name"),'id')
            ->where('is_super_admin', false)
            ->where('status', '1')
            ->pluck('name','id');

        return view('backend.administrator.user.change_password', compact('users'));
    }


    private function formatPermissions($permissions, $rolePermissions=null){
        //now build the structure to view on blade
        //$permissionList[group_name][module_name][permission_verb][permission_ids]
        $permissionList = [];

        foreach ($permissions as $permission){

            $namePart = preg_split("/\s+(?=\S*+$)/",$permission->name);
            $moduleName = $namePart[0];
            $verb = $namePart[1];

            $permissionList[$permission->group][$moduleName][$verb]['ids'][] = $permission->id;

            if($rolePermissions){
                $permissionList[$permission->group][$moduleName][$verb]['checked'] = in_array($permission->id, $rolePermissions) ? 1 : 0;

            }
            else{
                $permissionList[$permission->group][$moduleName][$verb]['checked'] = 0;

            }
        }

        return $permissionList;

    }

    private function proccessInputPermissions($permissionList, $type, $roleOrUserId, $loggedInUser){

        $rolePermissions = [];

        $now = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        if(count($permissionList)) {

            foreach ($permissionList as $permissions) {
                $permissions = explode(',', $permissions);
                foreach ($permissions as $permission) {
                    $rolePermissions[] = [
                        $type => $roleOrUserId,
                        'permission_id' => $permission,
                        'created_at' => $now,
                        'updated_at' => $now,
                        'created_by' => $loggedInUser,
                        'updated_by' => $loggedInUser,
                    ];
                }
            }


        }

        //now add common permissions
        $permissions = Permission::select('id')->where('group', 'Common')->get();
        foreach ($permissions as $permission) {
            $rolePermissions[] = [
                $type => $roleOrUserId,
                'permission_id' => $permission->id,
                'created_at' => $now,
                'updated_at' => $now,
                'created_by' => $loggedInUser,
                'updated_by' => $loggedInUser,
            ];
        }

        return $rolePermissions;
    }

}
