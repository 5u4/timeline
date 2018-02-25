<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 * @package App\Models
 *
 * @property int id
 * @property string username
 * @property string name
 * @property string color
 */
class Tag extends Model
{
    protected $table = 'tags';

    public $primaryKey = 'id';

    public $timestamps = false;

    /** Hex Color Regular Expression */
    public const COLOR_REGEX = '^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'color',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'username', 'username');
    }

    public function events()
    {
        return $this->belongsToMany('App\Models\Event', 'event_tags', 'event_id', 'tag_id');
    }
}
