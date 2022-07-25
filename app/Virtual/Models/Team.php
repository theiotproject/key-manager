<?php

/**
 * Class Team
 *
 * @OA\Schema(
 *     description=""
 * )
 */

class Team
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
     * @var integer
     */
    private $user_id;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $name;

            /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $personal_team;

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