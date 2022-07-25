<?php

/**
 * Class Gate
 *
 * @OA\Schema(
 *     description=""
 * )
 */

class Gate
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
    public $name;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    public $serial_number;

        /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    public $magic_code;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    public $team_id;

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