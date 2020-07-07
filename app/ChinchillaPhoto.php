<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Chinchilla
 *
 * @property int $id
 * @property int $chinchilla_id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereChinchillaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereId($value)
 * @mixin \Eloquent
 */
class ChinchillaPhoto extends Model
{
    protected $fillable = [
        'chinchilla_id', 'name',
    ];

    protected $hidden = [
        'chinchilla_id',
    ];

    public $timestamps = false;
}
