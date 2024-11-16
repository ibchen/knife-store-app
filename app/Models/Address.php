<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

/**
 * Модель для работы с адресами клиентов.
 */
class Address extends Model
{
    use HasFactory, AsSource;

    /**
     * Заполняемые поля модели.
     *
     * @var array<string>
     */
    protected $fillable = [
        'customer_id',
        'country',
        'city',
        'street',
        'house',
        'apartment',
        'postal_code',
        'is_primary',
    ];

    /**
     * Преобразование типов атрибутов.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Определяет связь с клиентом.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Устанавливает текущий адрес как основной.
     *
     * Если текущий адрес уже является основным, действие игнорируется.
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
     * Автоматические действия при определенных событиях модели.
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
