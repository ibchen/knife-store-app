<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'country', 'city', 'street', 'house', 'apartment', 'postal_code', 'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Устанавливает текущий адрес как основной.
     */
    public function setAsPrimary()
    {
        if ($this->is_primary) {
            return;
        }

        // Сброс всех других основных адресов клиента
        $this->customer->addresses()->where('is_primary', true)->update(['is_primary' => false]);

        // Устанавливаем текущий адрес как основной
        $this->update(['is_primary' => true]);
    }

    /**
     * Автоматически устанавливает первый адрес как основной при создании,
     * и обновляет основной адрес, если основной был удален.
     */
    protected static function booted()
    {
        // Устанавливаем первый адрес как основной, если у клиента нет основного адреса
        static::creating(function ($address) {
            if (!$address->customer->addresses()->where('is_primary', true)->exists()) {
                $address->is_primary = true;
            }
        });

        // Устанавливаем другой адрес как основной, если основной адрес был удален
        static::deleted(function ($address) {
            if ($address->is_primary) {
                $nextPrimary = $address->customer->addresses()->first();
                if ($nextPrimary) {
                    $nextPrimary->update(['is_primary' => true]);
                }
            }
        });

        // Автоматически сбрасываем `is_primary` у других адресов клиента при назначении основного
        static::saving(function ($address) {
            if ($address->is_primary) {
                $address->customer->addresses()
                    ->where('id', '!=', $address->id)
                    ->update(['is_primary' => false]);
            }
        });
    }
}
