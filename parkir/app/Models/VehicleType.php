<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    protected $table = 'parkir_vehicle__types';

    protected $fillable = [
        'jenis',
        'perjam_pertama',
        'perjam_berikutnya',
        'max_perhari',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_jenis');
    }

    public function getJenisLabelAttribute()
    {
        return match($this->jenis) {
            'motorcycle' => 'Motorcycle',
            'car'        => 'Car',
            'other'      => 'Truck/Bus/Other',
            default      => ucfirst($this->jenis),
        };
    }
}
