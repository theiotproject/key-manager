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
     *      path="/gates/{id}",
     *      operationId="getGate",
     *      tags={"Gates"},
     *      summary="Get Gate",
     *      description="Returns single gate",
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

      /**
     * @OA\Post(
     *      path="/gates",
     *      operationId="postGate",
     *      tags={"Gates"},
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
}