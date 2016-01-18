<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * IdeaRobin - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
namespace IdeaRobin\Api\Controllers;

use Dingo\Api\Facade\API;
use Exception;
use IdeaRobin\Api\Eloquent\User;
use IdeaRobin\Api\Eloquent\UserInformation;
use IdeaRobin\Api\Requests\UserRequest;
use IdeaRobin\Api\Transformers\UserInformationTransformer;
use Illuminate\Http\Request;
use Swagger\Annotations as SWG;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends BaseController
{
    /**
     * The User instance.
     *
     * @var User
     */
    protected $user;

    /**
     * The Logged In User.
     *
     * @var JWTAuth
     */
    protected $user_loggedin;

    /**
     * The User Information instance.
     *
     * @var UserInformation
     */
    protected $user_information;

    /**
     * Create a new controller instance.
     *
     * @param User            $user
     * @param UserInformation $user_information
     *
     * @return void
     *
     * @author Donna Borja <donna@idearobin.com>
     */
    public function __construct(User $user, UserInformation $user_information)
    {
        $this->user_loggedin = JWTAuth::parseToken()->authenticate();

        $this->user = $user;
        $this->user_information = $user_information;
    }

    /**
     * Get all Users.
     *
     * @SWG\Get(
     *     path="/users",
     *     tags={"Users"},
     *     summary="Retrieves all Users",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="data", type="array"),
     *         )
     *     ),
     *     @SWG\Response(response="500", description="Could not retrieve users",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="error", type="string", default="could_not_retrieve_data"),
     *         )
     *     )
     * )
     *
     * @param Request $request
     *
     * @return \League\Fractal\Resource\Collection
     *
     * @author Donna Borja <donna@idearobin.com>
     */
    public function index(Request $request)
    {
        $users = $this->user_information->get();

        return $this->collection($users, new UserInformationTransformer());
    }

    /**
     * Get user details.
     *
     * @SWG\Get(
     *     path="/users/profile/{user_id}",
     *     tags={"Users"},
     *     summary="Retrieve single User details",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="data", type="object"),
     *         )
     *     ),
     *     @SWG\Response(response="500", description="Could not retrieve data",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="error", type="string", default="could_not_retrieve_data"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="USER_ID to retrieve",
     *         required=true,
     *         type="integer",
     *         default="1",
     *     )
     * )
     *
     * @param Request $request
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Donna Borja <donna@idearobin.com>
     */
    public function details(Request $request)
    {
        // Check if selected User exists or not
        $user = $this->user->whereId($request->user_id)->first();
        if (!$user) {
            return API::response()->array(['status' => USER_DOES_NOT_EXIST])->statusCode(500);
        }

        $user = $this->user_information->whereUserId($request->user_id)->first();

        return $this->item($user, new UserInformationTransformer());
    }

    /**
     * Get logged in user profile.
     *
     * @SWG\Get(
     *     path="/users/profile",
     *     tags={"Users"},
     *     summary="Retrieves User Profile",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="data", type="array"),
     *         )
     *     ),
     *     @SWG\Response(response="500", description="Could not retrieve data",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="error", type="string", default="could_not_retrieve_data"),
     *         )
     *     )
     * )
     *
     * @param Request $request
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Donna Borja <donna@idearobin.com>
     */
    public function profile(Request $request)
    {
        $user_id = $this->user_loggedin->id;
        $user = $this->user_information->whereUserId($user_id)->first();

        return $this->item($user, new UserInformationTransformer());
    }

    /**
     * Add User.
     *
     * @SWG\Post(
     *     path="/users/profile",
     *     tags={"Users"},
     *     summary="Add User",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"status", "user"},
     *             @SWG\Property(property="status", type="string", default="Record successfully added.", description="Status message from server"),
     *             @SWG\Property(property="user", ref="#/definitions/User"),
     *         )
     *     ),
     *     @SWG\Response(response="500", description="Could not add data",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="error", type="string", default="could_not_add_data"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="user",
     *         in="body",
     *         description="User object to add",
     *         required=true,
     *         type="object",
     *         @SWG\Schema(title="user", type="object",
     *             @SWG\Property(property="user", ref="#/definitions/User")
     *         )
     *     )
     * )
     *
     * @param UserRequest $request
     *
     * @return mixed
     *
     * @author Donna Borja <donna@idearobin.com>
     */
    public function store(UserRequest $request)
    {
        $_user = $request->get('user');

        // Create main user data in users table
        $newUser = [
            'email'    => $_user['email'],
            'password' => bcrypt($_user['password']),
        ];

        // Re-use laravel's create user
        $user = User::create($newUser);
        if (!$user) {
            return API::response()->array(['status' => USER_CREATE_FAIL])->statusCode(500);
        }

        // Create user information in user_information table
        try {
            $user_information_params = array_merge($_user, [
                'user_id' => $user->id,
            ]);
            $this->user_information->create($user_information_params);
        } catch (Exception $e) {
            return API::response()->array(['status' => USER_CREATE_FAIL])->statusCode(500);
        }

        // Exclude password information in returning data of what has been just added
        unset($_user['password'], $_user['password_confirmation']);

        return API::response()->array(['status' => USER_CREATE_SUCCESS, 'user' => $_user])->statusCode(200);
    }

    /**
     * Edit User.
     *
     * @SWG\Patch(
     *     path="/users/profile/{user_id}",
     *     tags={"Users"},
     *     summary="Edit User",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"status", "user"},
     *             @SWG\Property(property="status", type="string", default="Record successfully updated.", description="Status message from server"),
     *             @SWG\Property(property="user", ref="#/definitions/User"),
     *         )
     *     ),
     *     @SWG\Response(response="500", description="Could not update data",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="error", type="string", default="could_not_update_data"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="USER_ID to edit",
     *         required=true,
     *         type="integer",
     *         default=8
     *     ),
     *     @SWG\Parameter(
     *         name="user",
     *         in="body",
     *         description="User object to edit",
     *         required=true,
     *         type="object",
     *         @SWG\Schema(title="user", type="object",
     *             @SWG\Property(property="user", ref="#/definitions/User")
     *         )
     *     )
     * )
     *
     * @param UserRequest $request
     *
     * @return mixed
     *
     * @author Donna Borja <donna@idearobin.com>
     */
    public function update(UserRequest $request)
    {
        $_user = $request->get('user');

        // check if user exists
        $user = $this->user->whereId($request->user_id)->first();
        if (!$user) {
            return API::response()->array(['status' => USER_DOES_NOT_EXIST])->statusCode(500);
        }

        // update users table
        try {
            $user_params = [
                'email'    => $_user['email'],
                'password' => bcrypt($_user['password']),
            ];
            $this->user->whereId($request->user_id)->update($user_params);
        } catch (Exception $e) {
            return API::response()->array(['status' => USER_UPDATE_FAIL])->statusCode(500);
        }

        // update user_information table
        try {
            $user_information_params = [
                'first_name' => $_user['first_name'],
                'last_name'  => $_user['last_name'],
                'phone'      => $_user['phone'],
                'address'    => $_user['address'],
                'suburb'     => $_user['suburb'],
                'postcode'   => $_user['postcode'],
                'state_id'   => $_user['state_id'],
            ];
            $this->user_information->whereUserId($request->user_id)->update($user_information_params);
        } catch (Exception $e) {
            return API::response()->array(['status' => USER_UPDATE_FAIL])->statusCode(500);
        }

        // Exclude password information in returning data of what has been just updated
        unset($_user['password'], $_user['password_confirmation']);

        return API::response()->array(['status' => USER_UPDATE_SUCCESS, 'user' => $_user])->statusCode(200);
    }

    /**
     * Delete User.
     *
     * @SWG\Delete(
     *     path="/users/profile/{user_id}",
     *     tags={"Users"},
     *     summary="Delete User",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="status", type="string", default="Record successfully deleted.", description="Status message from server"),
     *             @SWG\Property(property="user", ref="#/definitions/User"),
     *         )
     *     ),
     *     @SWG\Response(response="500", description="Could not delete data",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="error", type="string", default="could_not_delete_data"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="USER_ID to delete",
     *         required=true,
     *         type="integer",
     *         default=8
     *     )
     * )
     *
     * @param Request $request
     *
     * @return mixed
     *
     * @author Donna Borja <donna@idearobin.com>
     */
    public function destroy(Request $request)
    {
        // check if user exists
        $user = $this->user->whereId($request->user_id)->first();
        if (!$user) {
            return API::response()->array(['status' => USER_DOES_NOT_EXIST])->statusCode(500);
        }

        // update users table
        try {
            $this->user->whereId($request->user_id)->delete();
        } catch (Exception $e) {
            return API::response()->array(['status' => USER_DELETE_FAIL])->statusCode(500);
        }

        return API::response()->array(['status' => USER_DELETE_SUCCESS, 'user' => $user])->statusCode(200);
    }
}
