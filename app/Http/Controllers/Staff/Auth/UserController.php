<?php

namespace App\Http\Controllers\Staff\Auth;

use App\Models\Staff\User\{User, Authorise, Failed, Reset, Log};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Mail, Hash, Validator};
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return view('staff.auth');
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
         'name' => 'required',
         'email' => 'required|email|unique:staff.users',
         'password_1' => 'required|min:6|max:64',
        ]);
        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()->first()], 422);
        }
        (new User())->insert([
         'name' => $request->name,
         'email' => $request->email,
         'password' => Hash::make($request->password_1)
        ]);
        return response()->json(['success' => true], 201);
    }

    public function getFailures($request)
    {
        $failed_logins = Failed::where('email', $request->email)->where('created_at', '>', Carbon::now()->subMinutes(5))->count();
        if ($failed_logins >= 3) {
            return true;
        }
        return false;
    }

    public function getAuthorisation($request, $user)
    {
        $authorised_all = Authorise::where('ip', 'LIKE', $request->getClientIp())->where('user_id', 0)->where('deleted_at', 0)->exists();
        $authorised_user = Authorise::where('ip', 'LIKE', $request->getClientIp())->where('user_id', (int) $user->id)->where('deleted_at', 0)->exists();
        if (!$authorised_all && !$authorised_user) {
            $log = (new Log())->createLog($user->id, 'Attempt to login from unauthorised IP:' . $request->getClientIp());
            return true;
        }
        Authorise::where('ip', 'LIKE', $request->getClientIp())->update(['updated_at' => Carbon::now()]);
        return false;
    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
         'email' => 'required|min:6|max:64',
         'password' => 'required|min:6|max:64',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->validate(), 422);
        }
        if ($this->getFailures($request)) {
            return response()->json([
            'message' => 'Too many login attempts, your account has been blocked for 5 minutes'
            ], 422);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            (new Failed())->createFailure($request->email);
            return response()->json([
            'message' => 'An account with the supplied email and password could not be found.'
            ], 422);
        }
        if ((int) $user->deleted === 1) {
            return response()->json([
            'message' => 'This account has been disabled, please contact support.'
            ], 422);
        }
        if ((int) $user->verified === 0) {
            return response()->json([
            'message' => 'Your account is awaiting verification by the admin team.'
            ], 422);
        }
        if ($this->getAuthorisation($request, $user) && (bool) !$user->administrator) {
            return response()->json([
            'message' => 'You are trying to login from an unauthorised IP address ' . $request->getClientIp()
            ], 422);
        }
        Failed::where('email', $request->email)->delete();
        session(['staff_id' => $user->id]);
        Authorise::last_login($request);
        return response()->json(['res' => $user,'success' => true], 200);
    }

    public function passwordReset(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
            'message' => 'A user matching the supplied information could not be found.'
            ], 422);
        }
        $this->destroyResets($user->username);
        $reset = (new Reset())->createReset($user);
        $mail = [
         'token' => $reset->token,
         'to' => $reset->email,
         'name' => $user->name,
        ];
        Mail::send('mail.staff.auth.password_reset', $mail, function ($message) use ($mail) {
            $message->from('join@cavalrycare.co.uk');
            $message->to($mail['to'], $mail['name'])->subject('Password Reset');
        });
        return response()->json([
         'message' => 'A password reset link has been sent, please check your inbox.'
        ], 201);
    }

    public function destroyResets($email)
    {
        Reset::where('email', $email)->delete();
        return response()->json(['success' => true], 200);
    }

    public function validateRecovery(Request $request)
    {
        $validation = Validator::make($request->all(), ['token' => 'required']);
        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()->first()], 422);
        }
        Reset::where('token', $request->token)
         ->where('created_at', '>', Carbon::now()->subHour())
         ->firstOrFail();
        return response()->json(['success' => true], 200);
    }

    public function updateRecovery(Request $request)
    {
        $validation =  Validator::make($request->all(), [
         'password' => 'required|min:6|max:64',
         'token' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors()->first(), 422);
        }
        if (!$reset = Reset::where('token', $request->token)->first()) {
            return response()->json(['message' => 'No password reset request found!'], 422);
        }
        $user = User::where('email', $reset->email)->first();
        $user->updatePassword($request->password);
        $this->destroyResets($reset->email);
        Failed::where('email', $reset->email)->delete();
        return response()->json(['message' => 'Password updated successfully'], 200);
    }

    public function logout()
    {
        session()->forget('staff_id');
        return response()->json(['success' => true], 200);
    }

    public function show()
    {
        $user = User::where('id', session('staff_id'))->select('*', 'department as department_array')->first();
        if (!$user) {
            return response()->json(['success' => false], 422);
        }
        $user->profile_name = $user->sub_name ?? $user->name;
        return response()->json(['user' => $user], 200);
    }
}
