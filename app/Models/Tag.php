<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 *
 * Class Tag
 * @package App\Models
 */
class Tag extends Model
{
    protected $fillable = [
        'name', 'user_id',
    ];
}
