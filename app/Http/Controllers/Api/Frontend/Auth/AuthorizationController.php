<?php

namespace App\Http\Controllers\Api\Frontend\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use Illuminate\Auth\AuthenticationException;

class AuthorizationController extends Controller
{
    const GUARD='web';

    /**
     * @param LoginRequest $request
     * @return mixed
     * @throws \ErrorException
     */
    public function store(LoginRequest $request)
    {
        if (!$token = auth(self::GUARD)->attempt($request->all())) {

            throw new AuthenticationException('用户名或密码错误');
        }
        return $this->respondWithToken($token);
    }

    public function update()
    {
        $token = auth(self::GUARD)->refresh();
        return self::respondWithToken($token,200);
    }

    /** 刷新token
     * @param string $token
     * @param int $code
     * @return mixed
     * @throws \ErrorException
     */

    private function respondWithToken($token ='',$code=201)
    {
        $token = $token ? $token : auth(self::GUARD)->user();
        $expiresIn = auth(self::GUARD)->factory()->getTTL() * config('api.jwt.ttl');
        $expiresDate = now()->addSeconds($expiresIn)->toDateTimeString();

        return response()->json([
            'token' => 'Bearer'.' '.$token,
            'expires_in' => $expiresIn,
            'token_expired_at' => $expiresDate
        ])
            ->setStatusCode($code);
    }

    public function destroy(){
        return response(null, 204);
    }
}
