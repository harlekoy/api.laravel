<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * App - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
namespace App\Api\Controllers\Auth;

use Dingo\Api\Facade\API;
use App\Api\Controllers\BaseController;
use App\Api\Eloquent\Navlink;
use App\Api\Eloquent\User;
use App\Api\Requests\UserRequest;
use App\Api\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Swagger\Annotations as SWG;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
    /**
     * @param Request $request
     *
     * @return mixed
     *
     * @author Bertrand Kintanar <bertrand@idearobin.com>
     */
    public function me(Request $request)
    {
        $data = JWTAuth::parseToken()->authenticate();

        return $this->item(User::findOrFail($data->id), new UserTransformer());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand@idearobin.com>
     */
    public function sidebar()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $sidebar = Navlink::sidebar($user);

        return response()->json(compact('sidebar'));
    }

    /**
     * Authenticates guest user by logging in.
     *
     * @SWG\Post(
     *     path="/login",
     *     tags={"Authentication"},
     *     summary="Authenticates guest user by logging in.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="token", type="string"),
     *         )
     *     ),
     *     @SWG\Response(response="401", description="Invalid credentials",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="error", type="string", default="invalid_credentials"),
     *         )
     *     ),
     *     @SWG\Response(response="500", description="Could not create token",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="error", type="string", default="could_not_create_token"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         description="Registered user's email address",
     *         required=true,
     *         type="string",
     *         default="bertrand@idearobin.com",
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         description="Registered user's password",
     *         required=true,
     *         type="string",
     *         default="retardko",
     *     ),
     * )
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand@idearobin.com>
     */
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = array_filter($request->only('email', 'password'));

        $claims = ['company' => 'App'];

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials, $claims)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    /**
     * @return mixed
     *
     * @author Bertrand Kintanar <bertrand@idearobin.com>
     */
    public function validateToken()
    {
        // Our routes file should have already authenticated this token, so we just return success here
        return API::response()->array(['status' => 'success'])->statusCode(200);
    }

    /**
     * @param UserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand@idearobin.com>
     */
    public function register(UserRequest $request)
    {
        $newUser = [
            'email'    => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ];
        $user = User::create($newUser);
        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token'));
    }

    /**
     * Logout currently authenticated user.
     *
     * @SWG\Get(
     *     path="/logout",
     *     tags={"Authentication"},
     *     summary="Logout currently authenticated user.",
     *     @SWG\Response(response="200", description="Signed out",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="message", type="string", default="signed_out"),
     *             @SWG\Property(property="status_code", type="integer", default=200),
     *         )
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="message", type="string", default="Token not provided"),
     *             @SWG\Property(property="status_code", type="integer", default=400),
     *             @SWG\Property(property="debug", type="object"),
     *         )
     *     ),
     *     @SWG\Response(response="417", description="Cannot sign out",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="message", type="string", default="cannot_sign_out"),
     *             @SWG\Property(property="status_code", type="integer", default=417),
     *         )
     *     ),
     *     @SWG\Response(response="500", description="Could not create token",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="message", type="string", default="could_not_create_token"),
     *             @SWG\Property(property="status_code", type="integer", default=500),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="JWT Token",
     *         required=true,
     *         type="string",
     *         default="Bearer ",
     *         @SWG\Items(type="string")
     *     ),
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand@idearobin.com>
     */
    public function logout()
    {
        $response = [];
        try {
            if (JWTAuth::parseToken()->invalidate()) {
                $response['message'] = 'signed_out';
                $response['status_code'] = 200;
            } else {
                $response['message'] = 'cannot_sign_out';
                $response['status_code'] = 417;
            }
        } catch (JWTException $e) {
            $response['message'] = $e->getMessage();
            $response['status_code'] = 500;
        }

        return API::response()->array(['status' => $response['message'], 'status_code' => $response['status_code']])->statusCode($response['status_code']);
    }
}
