<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Event
 * @package App\Models
 *
 * @property int id
 * @property string username
 * @property string name
 * @property string description
 * @property string date
 * @property boolean done
 * @property string deleted_at
 */
class Event extends Model
{
    use SoftDeletes;

    protected $table = 'events';

    public $primaryKey = 'id';

    public $timestamps = false;

    protected $dates = ['deleted_at'];

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
