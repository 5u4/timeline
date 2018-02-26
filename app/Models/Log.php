<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Log
 * @package App\Models
 *
 * @property int id
 * @property string username
 * @property string action
 * @property string data
 * @property string timestamp
 * @property string deleted_at
 */
class Log extends Model
{
    use SoftDeletes;

    protected $table = 'logs';

    public $primaryKey = 'id';

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    /* User Actions */
    public const REGISTER = 'register';
    public const LOGIN = 'login';
    public const CHANGE_PASSWORD = 'change_password';
    public const DELETE_USER = 'delete_user';

    /* Event Actions */
    public const CREATE_EVENT = 'create_event';
    public const EDIT_EVENT = 'edit_event';
    public const TAG_EVENT = 'tag_event';
    public const DELETE_EVENT = 'delete_event';

    /* Tag Actions */
    public const CREATE_TAG = 'create_tag';
    public const EDIT_TAG = 'edit_tag';
    public const DELETE_TAG = 'delete_tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'action', 'data',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'username', 'username');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->timestamp = $model->freshTimestamp();
        });
    }
}
