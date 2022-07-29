<?php


class VirtualKeyController
{
    /**
     * @OA\Get(
     *      path="/api/virtualKeys/teamId/{team_id}",
     *      operationId="indexVirtualKeysByTeamId",
     *      tags={"VirtualKeys"},
     *      summary="index VirtualKeys By TeamId",
     *      security={{"sanctum":{}}},
     *      description="Returns list of VirtualKeys",
     * 
     *     @OA\Parameter(
     *         description="Pass ID of Team",
     *         in="path",
     *         name="team_id",
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
     *      path="/api/virtualKeys/teamId/{team_id}/token",
     *      operationId="indexByTeamIdForLoggedUser",
      *      tags={"VirtualKeys"},
     *      summary="Get list of VirtualKeys for team",
     *      security={{"sanctum":{}}},
     *      description="Returns list of VirtualKeys",
     * 
     *     @OA\Parameter(
     *         description="Pass ID of Team",
     *         in="path",
     *         name="team_id",
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
     *      path="/api/virtualKeys/code/{team_id}",
     *      operationId="generateCode",
     *      tags={"VirtualKeys"},
     *      security={{"sanctum":{}}},
     *      summary="Generate Code",
     *      description="Returns code",
     * 
     *     @OA\Parameter(
     *         description="Pass ID of VirtualKey",
     *         in="path",
     *         name="team_id",
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
     *      path="/virtualKeys/teamId/{team_id}/users/gates",
     *      operationId="indexVirtualKeysByTeamIdWithUsersAndGatesData",
     *      tags={"VirtualKeys"},
     *      security={{"sanctum":{}}},
     *      summary="index Virtual Keys With Users And Gates Data",
     *      description="Returns Virtual Keys with Users and Gates Data",
     * 
     *     @OA\Parameter(
     *         description="Pass ID of team",
     *         in="path",
     *         name="team_id",
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
     * @OA\Delete(
     *      path="/virtualKeys/{virtualKey}",
     *      operationId="deleteVirtualKey",
     *      tags={"VirtualKeys"},
     *      security={{"sanctum":{}}},
     *      summary="delete Virtual Key by Id",
     *      description="Deletes Virtual Key by Id",
     * 
     *     @OA\Parameter(
     *         description="Pass ID of Virtual Key",
     *         in="path",
     *         name="virtualKey",
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
     * @OA\Post(
     *      path="/api/virtualKeys",
     *      operationId="postVirtualKey",
     *      tags={"VirtualKeys"},
     *      security={{"sanctum":{}}},
     *      summary="Post VirtualKey",
     *      description="Creates VirtualKey",
     *  @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="users",
     *                     type="array",
     *                      @OA\Items(
     *                           @OA\Property(property="id", type="integer"),
     *                           @OA\Property(property="label", type="string"),
     *                      )
     *                 ),
     *                 @OA\Property(
     *                     property="valid_days",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="gates",
     *                     type="array",
     *                     @OA\Items(
     *                          @OA\Property(property="id", type="integer", ),
     *                     ),
     * 
     *                 ),
     * 
     *                 example={"users": {"id": 1,"label": "Key opens office"},"gates": 1,"valid_days": "MTWRF"}
     *             )
     *         )
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