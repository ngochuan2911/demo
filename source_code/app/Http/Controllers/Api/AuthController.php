<?php

namespace App\Http\Controllers\Api;

use App\{
    Http\Controllers\Controller,
    Http\Controllers\FunctionController,
    User
};
use Illuminate\Http\{
    JsonResponse,
    Request
};
use JWTAuth,
    Tymon\JWTAuth\Exceptions\JWTException;
use function response;

class AuthController extends Controller {

    /**
     * API Login, on success return JWT Auth token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request) {
        //lấy thông tin đăng nhập
        $credentials = $request->only('email', 'password');

        //kiểm tra email hoặc pass rỗng
        if ($credentials['email'] == '' || $credentials['password'] == '') {
            return response()->json(['message' => '400', 'error' => 'Email hoặc password không đúng']);
        }

        try {
            // success(JWTAuth thư viện của laravel, check login)
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => '400', 'error' => 'Email hoặc password không đúng']);
            }
        } catch (JWTException $e) {
            // fail
            return response()->json(['message' => '400', 'error' => 'Xảy ra 1 số vấn đề nên không thể tạo được token']);
        }

        // get user info
        $userInfo = User::where('email', $credentials['email'])->get()->toArray();
        $userInfo = $userInfo[0];

        // sinh random token
        $token = \Hash::make(FunctionController::random(40));

        if (isset($userInfo['token']) && $userInfo['token']) {
            $token = $userInfo['token'];
        } else {
            // cập nhật token nếu chưa có token
            User::where('email', $credentials['email'])->update([
                'token' => $token,
                'created_at' => $userInfo['created_at']
            ]);

            $userInfo['token'] = $token;
        }

        //status code
        $message = '200';

        //trả lại data
        return response()->json(compact('message', 'token', 'userInfo'));
    }

    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     * 
     * @param Request $request
     */
    public function logout(Request $request) {
        $this->validate($request, [
            'token' => 'required'
        ]);

        JWTAuth::invalidate($request->input('token'));
    }

}
