<?php


class AuthController
{
    /**
     * @OA\Post(
     *      path="/api/auth/token",
     *      operationId="LogIn",
     *      tags={"Auth"},
     *      summary="Log In to the API",
     *      description="Returns API token",
     *  @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="device_name",
     *                     type="string"
     *                 ),
     * 
     *                 example={"email":"user@gmail.com","password":"password123","device_name":"redmi"}
     *             )
     *         )
     *     ),
     * 
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    
     /**
     * @OA\Get(
     *      path="/api/auth/permission/teamId/{team_id}/request",
     *      operationId="getRequestUserPermissionByTeamId",
     *      tags={"Auth"},
     *      summary="get User Permission By TeamId",
     *      security={{"sanctum":{}}},
     *      description="Returns User Permission of user by TeamId",
     * 
     *     @OA\Parameter(
     *         description="Pass ID of Team",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     * 
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */

     /**
     * @OA\Get(
     *      path="/auth/permission/teamId/{team_id}",
     *      operationId="getAuthUserPermissionByTeamId",
     *      tags={"Auth"},
     *      security={{"sanctum":{}}},
     *      summary="Get Permission of User by TeamId",
     *      description="Returns Permission of User",
     * 
     *     @OA\Parameter(
     *         description="Pass ID of Team",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */

      /**
     * @OA\Get(
     *      path="/auth/users/{team_id}",
     *      operationId="indexUsersByTeamId",
     *      tags={"Auth"},
     *      security={{"sanctum":{}}},
     *      summary="Get Users By TeamId",
     *      description="Return User List",
     * 
     *     @OA\Parameter(
     *         description="Pass ID of Team",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
}