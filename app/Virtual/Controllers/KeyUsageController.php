<?php


class KeyUsageController
{
    /**
     * @OA\Post(
     *      path="/api/keyUsages",
     *      operationId="postKeyUsage",
     *      tags={"KeyUsages"},
     *      summary="Post keyUsage",
     *      description="Creates keyUsage",
     *  @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="id",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="virtual_key_id",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="access_granted",
     *                     type="boolean"
     *                 ),
     *                  @OA\Property(
     *                     property="message",
     *                     type="string"
     *                 ),
     *                 example={"id":"c2346a2b-e92b-467e-b09f-9d1f30d871c9","virtual_key_id":"1","access_granted":"1","message": "Access Granted"}
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