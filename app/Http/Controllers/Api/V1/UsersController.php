<?php
/**
 * Created by PhpStorm.
 * User: wangwentong
 * Date: 2018/7/9
 * Time: 下午2:04
 */

namespace App\Http\Controllers\Api\V1;


use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;

class UsersController extends Controller
{
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


    public function index(){
//        return User::all();
        $user = $this->auth->user();
        return $this->response->array($user->toArray());
    }
}
