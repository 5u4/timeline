<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 * @property integer $color
 *
 * Class Category
 * @package App\Models
 */
class Category extends Model
{
    protected $fillable = [
        'name', 'user_id', 'color',
    ];
}
