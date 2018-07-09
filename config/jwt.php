<?php

/*
 * This file is part of jwt-auth.
 *
 * (c) Sean Tymon <tymon148@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | JWT Authentication Secret
    |--------------------------------------------------------------------------
    |
    | Don't forget to set this, as it will be used to sign your tokens.
    | A helper command is provided for this: `php artisan jwt:generate`
    |
    */

    'secret' => env('JWT_SECRET', 'changeme'),

    /*
    |--------------------------------------------------------------------------
    | JWT time to live
    |--------------------------------------------------------------------------
    |
    | 指定 access_token 有效的时间长度（以分钟为单位），默认为1小时，您也可以将其设置为空，以产生永不过期的标记
    |
    */

    'ttl' => env('JWT_TTL', 60),

    /*
    |--------------------------------------------------------------------------
    | Refresh time to live
    |--------------------------------------------------------------------------
    |
    | 指定 access_token 可刷新的时间长度（以分钟为单位）。默认的时间为 2 周。
    | 大概意思就是如果用户有一个 access_token，那么他可以带着他的 access_token
    | 过来领取新的 access_token，直到 2 周的时间后，他便无法继续刷新了，需要重新登录。
    |
    */

    'refresh_ttl' => env('JWT_REFRESH_TTL', 20160),

    /*
    |--------------------------------------------------------------------------
    | JWT hashing algorithm
    |--------------------------------------------------------------------------
    |
    | Specify the hashing algorithm that will be used to sign the token.
    |
    | See here: https://github.com/namshi/jose/tree/2.2.0/src/Namshi/JOSE/Signer
    | for possible values
    | 指定将用于对令牌进行签名的散列算法。
    */

    'algo' => env('JWT_ALGO', 'HS256'),

    /*
    |--------------------------------------------------------------------------
    | User Model namespace
    |--------------------------------------------------------------------------
    |
    | Specify the full namespace to your User model.
    | e.g. 'Acme\Entities\User'
    |
    */

    'user' => 'App\User',

    /*
    |--------------------------------------------------------------------------
    | User identifier
    |--------------------------------------------------------------------------
    |
    | Specify a unique property of the user that will be added as the 'sub'
    | claim of the token payload.
    |
    */

    'identifier' => 'id',

    /*
    |--------------------------------------------------------------------------
    | Required Claims
    |--------------------------------------------------------------------------
    |
    | Specify the required claims that must exist in any token.
    | A TokenInvalidException will be thrown if any of these claims are not
    | present in the payload.
    |
    */

    'required_claims' => ['iss', 'iat', 'exp', 'nbf', 'sub', 'jti'],

    /*
    |--------------------------------------------------------------------------
    | Blacklist Enabled
    |--------------------------------------------------------------------------
    |
    | In order to invalidate tokens, you must have the blacklist enabled.
    | If you do not want or need this functionality, then set this to false.
    |
    */

    'blacklist_enabled' => env('JWT_BLACKLIST_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Providers
    |--------------------------------------------------------------------------
    |
    | Specify the various providers used throughout the package.
    |
    */

    'providers' => [

        /*
        |--------------------------------------------------------------------------
        | User Provider
        |--------------------------------------------------------------------------
        |
        | Specify the provider that is used to find the user based
        | on the subject claim
        |
        */

        'user' => 'Tymon\JWTAuth\Providers\User\EloquentUserAdapter',

        /*
        |--------------------------------------------------------------------------
        | JWT Provider
        |--------------------------------------------------------------------------
        |
        | Specify the provider that is used to create and decode the tokens.
        |
        */

        'jwt' => 'Tymon\JWTAuth\Providers\JWT\Namshi',

        /*
        |--------------------------------------------------------------------------
        | Authentication Provider
        |--------------------------------------------------------------------------
        |
        | Specify the provider that is used to authenticate users.
        |
        */

        'auth' => 'Tymon\JWTAuth\Providers\Auth\Illuminate',

        /*
        |--------------------------------------------------------------------------
        | Storage Provider
        |--------------------------------------------------------------------------
        |
        | Specify the provider that is used to store tokens in the blacklist
        |
        */

        'storage' => 'Tymon\JWTAuth\Providers\Storage\Illuminate',

    ],

];
