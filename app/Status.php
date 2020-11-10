<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * App\Status
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property int $timestamp
 * @property int $chinchilla_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereChinchillaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereTimestamp($value)
 */
class Status extends Model
{
    protected $fillable = ['name', 'timestamp', 'chinchilla_id'];

    public $timestamps = false;
}
