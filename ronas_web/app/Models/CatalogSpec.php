<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogSpec extends Model
{
    protected $table = 'catalog_specs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'catalog_id',
        'spec_id',
        'spec_value',
        'sort_order',
    ];

    public function catalog() {
        return $this->belongsTo(Catalog::class, 'catalog_id');
    }

    public function spec() {
        return $this->belongsTo(Spec::class, 'spec_id');
    }

}
