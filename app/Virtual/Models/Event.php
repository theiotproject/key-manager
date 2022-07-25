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
     * @var integer
     */
    private $id;

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