<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    use Helpers;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request(['name','email', 'password']);
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => '账户或密码错误'], 401);
        }else{
            $user = User::where('email', $request->email)->orWhere('name', $request->name)->first();
            $this->getToken($user,$token);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * 生成token
     * @param AppUser $userModel 后台用户模型
     * @return mixed
     */
    private function getToken(User $userModel,$token)
    {
        if ($userModel->remember_token) {
            $this->outToken($userModel->remember_token);
        }
        $userModel->remember_token = $token;
        $userModel->save();
        return $userModel->remember_token;
    }

    /**
     * 校验存储的token，并且把之前的token设置为无效
     * @param $remember_token 被记录的上次登录token
     */
    private function outToken($remember_token)
    {
        if (!empty($remember_token)) {
            auth()->setToken($remember_token);
            if (auth()->check()) {
                auth()->invalidate();
            }
        }
    }


}

