<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $note
 * @property integer $event_id
 * @property integer $time_slot
 *
 * Class Action
 * @package App\Models
 */
class Action extends Model
{
    protected $fillable = [
        'note', 'event_id', 'timeslot',
    ];
}
