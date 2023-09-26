<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class AuthController extends Controller
{
    //register
    public function register(Request $request)
    {

        $request->validate([
            'username' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'password_confirmation' => bcrypt($request->input('password_confirmation')),
        ]);
        // เริ่มใช้ได้
        if (!empty($avatar = $request->file('file'))) {
            $destinationPath = public_path('/image/avatar');
            $file_name = "avatar_" . time() . "." . $avatar->getClientOriginalExtension();
            $avatar->move($destinationPath, $file_name);
            $user['avatar'] = url('/') . '/image/avatar/' . $file_name;
            $user->save();
        } else {
            $user['avatar'] = url('/') . '/image/avatar/no_img.png';
            $user->save();
        }
        // จบใช้ได้
        $token = $user->createToken($request->userAgent())->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'username' => 'required|string',
            'email' => 'required|string|unique:users,email,' . $id, // ใช้ $id เพื่อยกเว้นการตรวจสอบซ้ำกับข้อมูลเดิม
            'password' => 'required|string|confirmed',
        ]);

        $user = User::find($id);

        if ($user) {
            $user->update([
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'password_confirmation' => bcrypt($request->input('password_confirmation')),
            ]);

            // เริ่มใช้ได้
            if (!empty($avatar = $request->file('file'))) {
                $destinationPath = public_path('/image/avatar');
                $file_name = "avatar_" . time() . "." . $avatar->getClientOriginalExtension();
                $avatar->move($destinationPath, $file_name);
                $user->avatar = url('/') . '/image/avatar/' . $file_name;
                $user->save();
            } else {
                $user->avatar = url('/') . '/image/avatar/no_img.png';
                $user->save();
            }
            // จบใช้ได้

            $token = $user->createToken($request->userAgent())->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response($response, 201);
        } else {
            // ไม่พบผู้ใช้ที่ต้องการอัพเดต
            return response(['message' => 'ไม่พบผู้ใช้ที่ต้องการอัพเดต'], 404);
        }
    }
    public function destroy($id)
    {
        return User::destroy($id);
    }
    public function login(Request $request)
    {
        // validate field
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        // check email
        $user = User::Where('email', $fields['email'])->first();

        // check password'
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'massage' => 'Invalid login'
            ], 401);
        } else {
            // ลบ token ของเก่าออก
            $user->tokens()->delete();
            // login สำเร็จ
            $token = $user->createToken($request->userAgent())->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            // config สำเร็จขึ้น 201
            return response($response, 201);
        }
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            // logout สำเร็จแสดง
            'massage' => 'logged out'
        ];
    }

    public function show($id)
    {
        // ดึงข้อมูลผู้ใช้จากฐานข้อมูลตาม $id
        return User::find($id);
    }

    public function index()
    {
        // แสดงข้อมูล ของ user ทีละ 10 ชือ่
        $users = User::orderBy('id', 'desc')->paginate(8);
        return response()->json($users);
    }
}
