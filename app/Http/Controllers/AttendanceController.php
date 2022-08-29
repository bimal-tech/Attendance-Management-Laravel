<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecords;
use App\Models\Staffs;
use App\Models\Students;
use App\Models\Teachers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendance = DB::table('attendance_records')
            ->join('users', 'users.id', '=', 'attendance_records.user_id')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.name', 'users.phone_number', 'email', 'clock_in', 'clock_out', 'status', 'roles.title as role')
            ->get();
        return response()->json(["success" => true, "data" => $attendance], 200);
    }
    public function dashboard()
    {
        $today = Carbon::today();
        $total_user = User::count();
        $total_teacher = Teachers::count();
        $total_student = Students::count();
        $total_staff = Staffs::count();
        $total_admin = User::where('role_id','=','1')->count();

        $total_present_user = AttendanceRecords::where("clock_in", ">", $today)->count();
        $total_present_admin = DB::table('attendance_records')
            ->join('users', 'users.id', '=', 'attendance_records.user_id')
            ->where("clock_in", ">", $today)
            ->where('users.role_id', '=', '1')
            ->where('status', '=', '0')
            ->count();
        $total_present_teacher = DB::table('attendance_records')
            ->join('users', 'users.id', '=', 'attendance_records.user_id')
            ->where("clock_in", ">", $today)
            ->where('users.role_id', '=', '2')
            ->where('status', '=', '0')
            ->count();

        $total_present_staff = DB::table('attendance_records')
            ->join('users', 'users.id', '=', 'attendance_records.user_id')
            ->where("clock_in", ">", $today)
            ->where('users.role_id', '=', '3')
            ->where('status', '=', '0')
            ->count();
        $total_present_student = DB::table('attendance_records')
            ->join('users', 'users.id', '=', 'attendance_records.user_id')
            ->where("clock_in", ">", $today)
            ->where('users.role_id', '=', '4')
            ->where('status', '=', '0')
            ->count();

        $absent_user = $total_user - $total_present_user;
        $absent_teacher = $total_teacher - $total_present_teacher;
        $absent_student = $total_student - $total_present_student;
        $absent_staff = $total_staff - $total_present_staff;
        $absent_admin = $total_admin - $total_present_admin;


        $data[] = (object) [
            'total_user' => $total_user,
            'total_teacher' => $total_teacher,
            'total_student' => $total_student,
            'total_staff' => $total_staff,
            'total_admin' => $total_admin,
            'total_present_user' => $total_present_user,
            'total_present_admin' => $total_present_admin,
            'total_present_teacher' => $total_present_teacher,
            'total_present_staff' => $total_present_staff,
            'total_present_student' => $total_present_student,
            'absent_user' => $absent_user,
            'absent_teacher' => $absent_teacher,
            'absent_student' => $absent_student,
            'absent_staff' => $absent_staff,
            'absent_admin' => $absent_admin,
        ];
        return response()->json(["success" => true, "data" => $data], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $authenticated =  Auth::attempt($request->only(['email', 'password']));
        if (!$authenticated) {
            return ["success" => false, "msg" => "Not Authorised."];
        } else {
            $user = User::where('email', $email)->firstOrFail();
            if ($user) {
                $is_present = AttendanceRecords::select('id', 'status')->where('user_id', $user->id)
                    ->where('status', '0')->get();
                $time = Carbon::now();
                if (count($is_present) == 0) {
                    $attendance = new AttendanceRecords();
                    $attendance->user_id = $user->id;
                    $attendance->status = "0";
                    $attendance->clock_in = $time;
                    $attendance->save();
                    return ["success" => true, "msg" => "Clock in attendance noted", "user" => $user->name, "clock" => $time, "status" => "0"];
                } else {
                    AttendanceRecords::where('user_id', $user->id)
                        ->where('status', '0')
                        ->update(['status' => '1', 'clock_out' => $time]);
                    return ["success" => true, "msg" => "Clocked out attendance noted", "user" => $user->name, "clock" => $time, "status" => "1"];
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
