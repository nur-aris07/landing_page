<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Spec extends Model
{
    protected $table = 'specs';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'service_category_id',
        'spec_key',
        'spec_label',
        'is_required',
        'is_active',
        'sort_order',
    ];

    public function category() {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function getHashIdAttribute(): string {
        return Crypt::encryptString($this->id);
    }

}
