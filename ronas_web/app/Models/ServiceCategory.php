<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class ServiceCategory extends Model
{
    protected $table = 'service_categories';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'image',
        'icon',
        'is_active',
    ];

    public function specs() {
        return $this->hasMany(Spec::class, 'service_category_id');
    }

    public function getImageUrlAttribute() {
        if (!$this->image) {
            return asset('images/default-category.png');
        }

        return asset('storage/' . $this->image);
    }

    public function getHashIdAttribute(): string {
        static $cache = [];

        if (!isset($cache[$this->id])) {
            $cache[$this->id] = Crypt::encryptString($this->id);
        }

        return $cache[$this->id];
    }

}
