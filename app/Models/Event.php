<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Event
 * @package App\Models
 *
 * @property int id
 * @property string username
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
        'username', 'name', 'description', 'date', 'done',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'username', 'username');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'event_tags', 'event_id', 'tag_id');
    }
}
