<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

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

    public function getHashIdAttribute(): string {
        return Crypt::encryptString($this->id);
    }
    
    public function isImageType(): bool {
        return $this->type === 'image';
    }

    public function isCore(): bool {
        return (bool) $this->is_core;
    }
}