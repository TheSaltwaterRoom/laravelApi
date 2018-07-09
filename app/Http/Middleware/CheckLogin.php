<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class CheckLogin extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 检查此次请求中是否带有 token，如果没有则抛出异常。
        $this->checkForToken($request);

        try {
            // 检测用户的登录状态，如果正常则通过
            if ($this->auth->parseToken()->authenticate()) {
                $requestToken = $this->auth->getToken();
                if ($this->auth->getPayload($requestToken)->get('iat') < strtotime('midnight')) {
                    return $this->sendResponse("TOKEN已失效");
                }
            }else{
                return $this->sendResponse("TOKEN已失效");
            }

        } catch (\Exception $e) {
            return $this->sendResponse("TOKEN已失效");
        }

        return $next($request);
    }


    private function sendResponse(string $message, int $status = 401, int $httpStatus = 401)
    {
        return response([
            "status_code" => $status,
            "messages"    => $message,
        ], $httpStatus);
    }
}
