<?php


class GateController
{
    /**
     * @OA\Get(
     *      path="/api/teams/userId/{user_id}",
     *      operationId="indexTeamsByUser",
     *      tags={"Teams"},
     *      summary="index Teams By User",
     *      security={{"sanctum":{}}},
     *      description="Returns Teams",
     * 
     *     @OA\Parameter(
     *         description="Pass ID of User",
     *         in="path",
     *         name="user_id",
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
}