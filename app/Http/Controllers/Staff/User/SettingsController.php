<?php

namespace App\Http\Controllers\Staff\User;

use App\Models\Staff\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    private $user;

    public function user()
    {
        $this->user = User::where('id', session('staff_id'))->first();
    }

    public function profile(Request $request)
    {
        $this->user();
        if (!$this->user) {
            return response()->json(['success' => false], 401);
        }
        $form = $request->user;
        $this->user->name = $form['name'] ?? $this->user->name;
        if (isset($form['email'])) {
            if (User::where('email', $form['email'])->where('id', '!=', $this->user->id)->exists()) {
                return response()->json([
                'message' => 'a user with this email address already exists'
                ], 422);
            }
        }
        $this->user->updateProfile($form);
        return response()->json([
         'message' => 'Your profile has been updated'
        ], 200);
    }

    public function password(Request $request)
    {
        $this->user();
        if (!$this->user) {
            return response()->json(['success' => false], 401);
        }
        $form = $request->password;
        if (!Hash::check($form['current_password'], $this->user->password)) {
            return response()->json([
            'message' => 'The password supplied does not match your current password'
            ], 404);
        }
        if (!isset($form['password_1'])) {
            return response()->json([
            'message' => 'Please fill all required form fields'
            ], 404);
        }
        $this->user->updatePassword($form['password_1']);
        return response()->json([
         'message' => 'Your password has been updated.'
        ], 200);
    }
}
