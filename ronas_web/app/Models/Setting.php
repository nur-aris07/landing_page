<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group_name',
        'label',
        'description',
        'is_core',
    ];

}
