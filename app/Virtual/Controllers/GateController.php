<?php


class GateController
{
    /**
     * @OA\Get(
     *      path="/api/gates/teamId/{id}",
     *      operationId="getGatesTeamList",
     *      tags={"Gates"},
     *      summary="Get list of gates from Team",
     *      security={{"sanctum":{}}},
     *      description="Returns list of gates of Team",
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
     *      path="/api/gates/virtualKeyId/{virtualKeyId}",
     *      operationId="getGatesByVirtualKey",
     *      tags={"Gates"},
     *      summary="Get list of gates by Virtual Key",
     *      security={{"sanctum":{}}},
     *      description="Returns list of gates of Virtual Key",
     * 
     *     @OA\Parameter(
     *         description="Pass ID of Virtual Key",
     *         in="path",
     *         name="virtualKeyId",
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
     *      path="/api/gates/userId/{id}/teams",
     *      operationId="getUserGates",
     *      tags={"Gates"},
     *      security={{"sanctum":{}}},
     *      summary="Get Gates of User",
     *      description="Returns gates from User",
     * 
     *     @OA\Parameter(
     *         description="Pass ID of User",
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
     * @OA\Post(
     *      path="/gates",
     *      operationId="postGate",
     *      tags={"Gates"},
     *      security={{"sanctum":{}}},
     *      summary="Post gate",
     *      description="Creates gate",
     *  @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="serial_number",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="magic_code",
     *                     type="string"
     *                 ),
     * 
     *                 example={"name": "Office","serial_number":"ADJF93DI12","magic_code":"c7cf6353-9211-4987-a4ba-2c394f445d26"}
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

      /**
     * @OA\Delete(
     *      path="/gates/{gateId}",
     *      operationId="deleteGate",
     *      tags={"Gates"},
     *      security={{"sanctum":{}}},
     *      summary="Delete Gate",
     *      description="Deletes Gate by gateId",
     * 
     *     @OA\Parameter(
     *         description="Pass ID of Gate",
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