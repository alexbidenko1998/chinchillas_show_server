<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Chinchilla
 *
 * @property int $id
 * @property int $chinchilla_id
 * @property string $name
 * @method static Builder|Chinchilla newModelQuery()
 * @method static Builder|Chinchilla newQuery()
 * @method static Builder|Chinchilla query()
 * @method static Builder|Chinchilla whereChinchillaId($value)
 * @method static Builder|Chinchilla whereName($value)
 * @method static Builder|Chinchilla whereId($value)
 * @mixin Eloquent
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
