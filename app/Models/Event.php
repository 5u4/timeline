<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 * @property integer $category_id
 * @property integer $tag_id
 *
 * Class Event
 * @package App\Models
 */
class Event extends Model
{
    use softDeletes;

    protected $fillable = [
        'name', 'user_id', 'category_id', 'tag_id',
    ];

    protected $dates = ['deleted_at'];
}
