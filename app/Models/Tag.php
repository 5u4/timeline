<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Tag
 * @package App\Models
 *
 * @property int id
 * @property string username
 * @property string name
 * @property string color
 * @property string deleted_at
 */
class Tag extends Model
{
    use SoftDeletes;

    protected $table = 'tags';

    public $primaryKey = 'id';

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    /** Hex Color Regular Expression */
    public const COLOR_REGEX = '([A-Fa-f0-9]{6})';

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
        return $this->belongsToMany('App\Models\Event', 'event_tags', 'tag_id', 'event_id');
    }
}
