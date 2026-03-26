<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Catalog extends Model
{
    protected $table = 'catalogs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'service_category_id',
        'title',
        'description',
        'image',
        'price',
        'price_label',
        'location',
        'whatsapp_message',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function category() {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function specs() {
        return $this->hasMany(CatalogSpec::class, 'catalog_id');
    }

    public function getImageUrlAttribute() {
        if (!$this->image) {
            return asset('images/default-catalog.png');
        }

        return asset( $this->image);
    }

    public function getFormattedPriceAttribute() {
        if (is_null($this->price)) {
            return $this->price_label ?? 'Hubungi Kami';
        }

        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getWhatsappTextAttribute() {
        if ($this->whatsapp_message) {
            return $this->whatsapp_message;
        }

        return "Halo, saya tertarik dengan layanan *{$this->title}*";
    }

    public function getHashIdAttribute(): string {
        return Crypt::encryptString($this->id);
    }

}
