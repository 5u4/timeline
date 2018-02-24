<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 * @package App\Models
 *
 * @property int id
 * @property int user_id
 * @property string name
 * @property string color
 */
class Tag extends Model
{
    protected $table = 'tags';

    public $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'color',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
