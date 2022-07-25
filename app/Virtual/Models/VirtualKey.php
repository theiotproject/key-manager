<?php

/**
 * Class VirtualKey
 *
 * @OA\Schema(
 *     description=""
 * )
 */

class VirtualKey
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
    public $label;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    public $user_id;

        /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    public $valid_days;

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