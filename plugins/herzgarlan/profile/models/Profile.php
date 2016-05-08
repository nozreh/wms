<?php namespace HerzGarlan\Profile\Models;

use Model;

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
        'user' => ['RainLab\User\Models\User']
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