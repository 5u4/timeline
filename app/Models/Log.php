<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Log
 * @package App\Models
 *
 * @property int id
 * @property string username
 * @property string action
 * @property string data
 * @property string timestamp
 */
class Log extends Model
{
    protected $table = 'logs';

    public $primaryKey = 'id';

    public $timestamps = false;

    /* Actions */
    public const REGISTER = 'register';
    public const LOGIN = 'login';

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
