<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Teachers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = DB::table('teachers')
            ->join('users', 'users.id', '=', 'teachers.user_id')
            ->select('teachers.id', 'users.name', 'users.phone_number', 'email')
            ->get();
        return response()->json(["data" => $teachers], 200);
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
            'post' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["success" => false, "error" => $validator->errors()], 400);
        } else {
            $user = User::create($data);
            $pw = Hash::make($data['phone_number']);
            $user->password = $pw;
            $user->save();
            $staff = Teachers::create($data);
            $staff_id = User::all()->where('email', $data['email'])[0]->id;
            $staff->user_id = $staff_id;
            $staff->save();
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
        $teachers = DB::table('teachers')
            ->join('users', 'users.id', '=', 'teachers.user_id')
            ->select('teachers.id', 'users.name', 'users.phone_number', 'email','teachers.*')
            ->where('teachers.id','=',$id)
            ->get();
        return response()->json(["data" => $teachers], 200);
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
        $teachers = Teachers::find($id);
        $user=User::find($teachers->user_id);
        
        $data = $request->all();
        foreach ($data as $key => $value) {
            if (is_null($value)) {
                unset($data[$key]);
            }
        }

        $teachers->update($data);
        $user->update($data);
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
        $teachers = Teachers::find($id);
        $user = User::find($teachers->user_id);
        $user->delete();
        $teachers->delete();
        return response()->json(["msg" => "User deleted Successfully"], 200);
    }
}
