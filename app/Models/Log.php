<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Log
 * @package App\Models
 *
 * @property int id
 * @property int user_id
 * @property string action
 * @property string data
 * @property string timestamp
 */
class Log extends Model
{
    protected $table = 'logs';

    public $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'action', 'data',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->timestamp = $model->freshTimestamp();
        });
    }
}
