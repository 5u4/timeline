<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App\Models
 *
 * @property int id
 * @property string name
 * @property string email
 * @property string password
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    public $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function events()
    {
        return $this->hasMany('App\Models\Event', 'user_id', 'id');
    }

    public function tags()
    {
        $this->hasMany('App\Models\Tag', 'user_id', 'id');
    }

    public function logs()
    {
        $this->hasMany('App\Models\Log', 'user_id', 'id');
    }
}
