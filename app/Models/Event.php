<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Event
 * @package App\Models
 *
 * @property int id
 * @property int user_id
 * @property string name
 * @property mixed description
 * @property mixed date
 * @property boolean done
 */
class Event extends Model
{
    protected $table = 'events';

    public $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'description', 'date', 'done',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
