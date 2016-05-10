<?php namespace HerzGarlan\Profile\Models;

use Model;
use RainLab\User\Models\User;

/**
 * Model
 */
class Profile extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
    'contact_email' => 'between:6,255|email'
    ];
    /*public $rules = [
        'company'       => 'required',
        'contact_name'  => 'required',
        'contact_email' => 'required|between:6,255|email',
        'contact_no'    => 'required|between:3,20',
        'registration_no' => 'required',
        'mailing_addr'  => 'required'
    ];*/

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'herzgarlan_profile_profiles';

    public $belongsTo = [
        'user' => ['RainLab\User\Models\User',  'table' => 'herzgarlan_profile_profiles',  'key' => 'user_id']
    ];

    public $attachOne = [
        'logo' => ['System\Models\File']
    ];

    public static function getFromUser($user)
    {
        if($user->profile)
        return $user->profile;

        $profile = new static;
        $profile->user = $user;
        $profile->save();

        $user->profile = $profile;
        return $profile;
    }
}