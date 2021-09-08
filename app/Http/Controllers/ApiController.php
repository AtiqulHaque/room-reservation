<?php

namespace App\Http\Controllers;

use App\Contracts\Service\UserServiceContract;
use Illuminate\Http\Response;
use JWTAuth;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\RegistrationFormRequest;

class ApiController extends BaseController
{
    /**
    * @OA\Info(title="Booking system API", version="0.1")
    */

    /**
     * @var bool
     */
    public $loginAfterSignUp = true;
    /**
     * @var UserServiceContract
     */
    private $userService;


    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *      path="/login",
     *      operationId="login",
     *      tags={"Authentication"},
     *      summary="Login to the project",
     *      description="Login to the project",
     *      * @OA\RequestBody(
     *          required=true,
     *          description="Pass user credentials",
     *          @OA\JsonContent(
     *                  required={"email","password"},
     *                  @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *                  @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function login(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'email'    => 'required|string|email|max:255',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendApiValidationError($validator->errors());
        }

        try {
            $input = $request->only('email', 'password');
            $token = null;

            if (!$token = JWTAuth::attempt($input)) {
                return $this->sendApiError("invalid_credentials", Response::HTTP_UNAUTHORIZED);
            }

        } catch (JWTException $e) {
            return $this->sendApiError("could_not_create_token", Response::HTTP_INTERNAL_SERVER_ERROR);
        }



        return response()->json([
            'success' => true,
            'token'   => $token,
        ]);
    }


    /**
     * @OA\Post(
     *      path="/logout",
     *      operationId="logout",
     *      tags={"Authentication"},
     *      summary="Logout from auth session",
     *      description="Logout from auth session",
     *      * @OA\RequestBody(
     *          required=true,
     *          description="Pass user credentials",
     *          @OA\JsonContent(
     *                  required={"token"},
     *                  @OA\Property(property="token", type="string", example="jwt token"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }


    /**
     * @OA\Post(
     *      path="/register",
     *      operationId="register",
     *      tags={"Authentication"},
     *      summary="Register Or create user for the sysytem",
     *      description="Register Or create user for the sysytem",
     *      * @OA\RequestBody(
     *          required=true,
     *          description="Pass user information",
     *          @OA\JsonContent(
     *                  required={"first_name","last_name","email", "password"},
     *                  @OA\Property(property="first_name", type="string", format="email", example="Atiqul"),
     *                  @OA\Property(property="last_name", type="string", format="string", example="Haque"),
     *                  @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *                  @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */


    /**
     * @param RegistrationFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $response = $this->userService->createUser($request->all());

        if (!empty($response['status']) && $response['status'] == 'validation-error') {
            return $this->sendApiValidationError($response['error']);
        }


        if (!empty($response['status']) && $response['status'] == 'success') {
            return $this->sendApiResponse("Success",$response['data']);
        }

        return $this->sendApiError($response['html']);
    }
}
