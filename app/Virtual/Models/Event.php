<?php

/**
 * Class Event
 *
 * @OA\Schema(
 *     description=""
 * )
 */

class Event
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
     * @var \DateTime
     */
    public $scan_time;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    public $qr_code;

    /**
     * @OA\Property(
     * )
     *
     * @var boolean
     */
    public $status;

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