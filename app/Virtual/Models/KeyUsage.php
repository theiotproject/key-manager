<?php

/**
 * Class KeyUsage
 *
 * @OA\Schema(
 *     description=""
 * )
 */

class KeyUsage
{
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $id;

    /**
     * @OA\Property(
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var integer
     */
    public $virtual_key_id;

    /**
     * @OA\Property(
     * )
     *
     * @var boolean
     */
    public $access_granted;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    public $message;

    /**
     * @OA\Property(
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;

}