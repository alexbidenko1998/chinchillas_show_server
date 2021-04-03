<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * App\Price
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $currency
 * @property double $value
 * @property int $status_id
 * @property int $timestamp
 * @property int $user_id
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereValue($value)
 */
class Price extends Model
{
    protected $fillable = ['currency', 'value', 'status_id', 'timestamp', 'user_id'];

    public $timestamps = false;

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
