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
 */
class Status extends Model
{
    protected $fillable = ['name', 'timestamp', 'chinchilla_id'];

    public $timestamps = false;
}
