<?php

namespace App\Models;

use App\Traits\InvoiceLabel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Invoice
 *
 * @property int $id
 * @property int $customer_id
 * @property int $year
 * @property int $number
 * @property string $date_of_issue
 * @property string $date_of_traffic
 * @property string $payment_deadline
 * @property string $total
 * @property int $payment_status
 * @property string|null $payment_date
 * @property string|null $customer_name
 * @property string|null $customer_pib
 * @property string|null $customer_mb
 * @property string|null $customer_address
 * @property string|null $customer_city
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCustomerAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCustomerCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCustomerMb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCustomerPib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDateOfIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDateOfTraffic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice wherePaymentDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereYear($value)
 * @mixin \Eloquent
 * @property string|null $number_mark
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereNumberMark($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoiceItem[] $items
 * @property-read int|null $items_count
 * @property string|null $exchange_rate
 * @property int $domestic
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDomestic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereExchangeRate($value)
 */
class Invoice extends Model
{
    use HasFactory, InvoiceLabel;

    protected $fillable = [
        'customer_id',
        'year',
        'number',
        'number_mark',
        'date_of_issue',
        'date_of_traffic',
        'payment_deadline',
        'total',
        'payment_status',
        'payment_date',
        'customer_name',
        'customer_pib',
        'customer_mb',
        'customer_address',
        'customer_city',
        'exchange_rate',
        'domestic',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
