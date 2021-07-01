<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Price
 *
 * @method static Builder|Chinchilla newModelQuery()
 * @method static Builder|Chinchilla newQuery()
 * @method static Builder|Chinchilla query()
 * @mixin Eloquent
 * @property int $id
 * @property string $currency
 * @property double $value
 * @property int $status_id
 * @property int $timestamp
 * @property int $user_id
 * @property-read User|null $user
 * @method static Builder|Price whereCurrency($value)
 * @method static Builder|Price whereId($value)
 * @method static Builder|Price whereStatusId($value)
 * @method static Builder|Price whereTimestamp($value)
 * @method static Builder|Price whereUserId($value)
 * @method static Builder|Price whereValue($value)
 */
class Price extends Model
{
    protected $fillable = ['currency', 'value', 'status_id', 'timestamp', 'user_id', 'chinchilla_id'];

    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
