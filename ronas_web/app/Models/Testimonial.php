<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $table = 'testimonials';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'customer_name',
        'customer_title',
        'customer_city',
        'message',
        'rating',
        'image',
        'is_active',
    ];

    public function getImageUrlAttribute() {
        if (!$this->image) {
            return asset('images/default-user.png');
        }

        return asset('storage/' . $this->image);
    }

    public function getStarsAttribute() {
        if (!$this->rating) return null;

        return str_repeat('⭐', $this->rating);
    }

}
