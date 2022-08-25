<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Students;
use App\Models\Teachers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->select('students.id','users.name','users.phone_number','email')
            ->get();
        
        return response()->json(["data"=>$students],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'class'=>'required',
            'fee_structure_id'=>'numeric',
            'scholarship_type_id'=>'numeric',
            'roll_no'=>'required',
            'batch'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["success" => false, "error" => $validator->errors()], 400);
        } else {
            $user = User::create($data);
            $pw = Hash::make($data['roll_no']);
            $user->password = $pw;
            $user->save();
            $student=Students::create($data);
            $student_id=User::all()->where('email',$data['email'])[0]->id;
            $student->user_id=$student_id;
            $student->save();
            return response()->json(["msg" => "User Created Successfully"], 200);
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
        
        $students = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->select('students.id','users.name','users.phone_number','email','students.*')
            ->where('students.id',$id)
            ->get();
        
        return response()->json(["data"=>$students],200);
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
        $students = Students::find($id);
        $data = $request->all();
        $user=User::find($students->user_id);
        foreach ($data as $key => $value) {
            if (is_null($value)) {
                unset($data[$key]);
            }
        }
        $user->update($data);
        $students->update($data);
        return response()->json(["msg" => "Data updated Successfully"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $students=Students::find($id);
        $user=User::find($students->user_id);
        $user->delete();
        $students->delete();
        return response()->json(["msg" => "User deleted Successfully"], 200);
    }
}
