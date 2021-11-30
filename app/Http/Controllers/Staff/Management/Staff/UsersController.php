<?php

namespace App\Http\Controllers\Staff\Management\Staff;

use App\Models\Staff\User\{Authorise, User, Department, Branches};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use DB;

class UsersController extends Controller
{

    public function read_departments()
    {
        return response()->json(Department::orderBy('name')->get(), 200);
    }

    public function read_Branches()
    {
        return response()->json(Branches::orderBy('name')->get(), 200);
    }

    public function read_awaiting_activation()
    {
        return response()->json(User::where('verified', 0)->orWhere('verified', null)->get(), 200);
    }

    public function update_awaiting_activation($id)
    {
        User::where('id', $id)->firstOrFail()->verify();
        return response()->json([
         'message' => 'The staff account has been activated'
        ], 200);
    }

    public function delete_awaiting_activation($id)
    {
        User::where('id', $id)->where('verified', 0)->delete();
        return response()->json([
         'message' => 'The staff account has been deleted'
        ], 200);
    }

    public function read_active_users()
    {
        return response()->json(User::where('verified', 1)->where('deleted', 0)->orderBy('name')->get(), 200);
    }

    public function update_active_users(Request $request, $id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $validator = Validator::make(request()->all(), [
         'department' => 'required',
         'manager' => 'required',
         'branch_id' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 401);
        }
        $user->update([
         'department' => $request->department,
         'manager' => $request->manager,
         'branch_id' => $request->branch_id,
        ]);
        return response()->json(['success' => true], 200);
    }

    public function delete_active_user($id)
    {
        User::where('id', $id)->firstOrFail()->softDelete();
        return response()->json([
         'message' => 'The staff account has been deactivated'
        ], 200);
    }

    public static function login_as_user($id)
    {
        $admin = User::where('id', session('staff_id'))->where('administrator', 1)->firstOrFail();
        $user = User::where('id', $id)->firstOrFail();
        session(['staff_id' => $user->id]);
        return response()->json([
         'message' => 'You have been logged in, refreshing now.'
        ], 200);
    }




}
