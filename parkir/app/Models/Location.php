<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'parkir_locations';

    protected $fillable = [
        'location_name',
        'max_motorcycle',
        'max_car',
        'max_other',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_lokasi');
    }

    public function getAvailableMotorcycle()
    {
        $used = $this->transactions()
            ->whereNull('keluar')
            ->whereHas('vehicleType', fn($q) => $q->where('jenis', 'motorcycle'))
            ->count();
        return $this->max_motorcycle - $used;
    }

    public function getAvailableCar()
    {
        $used = $this->transactions()
            ->whereNull('keluar')
            ->whereHas('vehicleType', fn($q) => $q->where('jenis', 'car'))
            ->count();
        return $this->max_car - $used;
    }

    public function getAvailableOther()
    {
        $used = $this->transactions()
            ->whereNull('keluar')
            ->whereHas('vehicleType', fn($q) => $q->where('jenis', 'other'))
            ->count();
        return $this->max_other - $used;
    }
}
