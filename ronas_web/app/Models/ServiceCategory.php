<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function getImageUrlAttribute() {
        if (!$this->image) {
            return asset('images/default-category.png');
        }

        return asset('storage/' . $this->image);
    }

}
