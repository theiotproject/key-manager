<?php

/**
 * Class User
 *
 * @OA\Schema(
 *     description=""
 * )
 */

class User
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
    private $name;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $email;


    /**
     * @OA\Property(
     * format="datetime",
     * type="string"
     * )
     *
     * @var \DateTime
     */
    private $email_verified_at;

        /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $password;

        /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $two_factor_secret;

        /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $two_factor_recovery_codes;

        /**
     * @OA\Property(
     *     format="datetime",
     *     type="string"
     * )
     *
     *  @var \DateTime
     */
    private $two_factor_confirmed_at;

        /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $remember_token;

                /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $current_team_id;

            /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $profile_photo_path;


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