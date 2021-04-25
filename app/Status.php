<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Status
 *
 * @method static Builder|Chinchilla newModelQuery()
 * @method static Builder|Chinchilla newQuery()
 * @method static Builder|Chinchilla query()
 * @mixin Eloquent
 * @property int $id
 * @property string $name
 * @property int $timestamp
 * @property int $chinchilla_id
 * @method static Builder|Status whereChinchillaId($value)
 * @method static Builder|Status whereId($value)
 * @method static Builder|Status whereName($value)
 * @method static Builder|Status whereTimestamp($value)
 * @property-read Price|null $priceEur
 * @property-read Price|null $priceRub
 * @property-read Price|null $priceUSD
 * @property-read mixed $prices
 * @property-read Price|null $priceUsd
 */
class Status extends Model
{
    protected $fillable = ['name', 'timestamp', 'chinchilla_id'];

    public $timestamps = false;

    public function getPricesAttribute()
    {
        return Price::where('timestamp', $this->timestamp)->get();
    }
}
