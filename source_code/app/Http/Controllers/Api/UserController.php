<?php

namespace App\Http\Controllers\Api;

use App\{
    Http\Controllers\Controller,
    User
};
use Illuminate\Http\Request;
use function bcrypt,
             response;

class UserController extends Controller {

    public function GetProfile(Request $request) {
        //get token
        $token = $request->only('token');

        //get userInfo
        $userInfo = User::where('token', $token['token'])->first();

        //check pass login
        if (!$userInfo || !$token['token']) {
            return response()->json(['message' => '400', 'error' => 'Chưa login']);
        }

        $message = '200';
        return response()->json(compact('message', 'userInfo'));
    }

    public function UpdateProfile() {
        // phương thức get demo cho dễ
        $info = $_GET;

        //check token
        if (!$info['token']) {
            return response()->json(['message' => '400', 'error' => 'Chưa login']);
        }

        // field được phép update
        $fields = [
            'name',
            'password',
            'tel',
            'andress'
        ];

        $userID = $this->getUserID($info['token']);
        if (!$userID) {
            return response()->json(['message' => '400', 'error' => 'Không tồn tại tài khoản']);
        } else {
            foreach ($info as $key => $value) {
                //bỏ qua nếu ko phải fiels được update
                if (!in_array($key, $fields)) {
                    continue;
                }
                if ($key == 'password') {
                    $value = bcrypt($value);
                }
                User::where('id', $userID)->update([$key => $value]);
            }
        }

        $newUser = User::where('token', $info['token'])->first();
        $message = '200';

        //trả lại thông tin user sau khi cập nhật
        return response()->json(compact('message', 'newUser'));
    }

    protected function getUserID($token) {
        $user = User::where('token', $token)->first();
        if (!$user) {
            return null;
        } else {
            return $user->id;
        }
    }

}
