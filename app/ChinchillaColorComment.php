<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ChinchillaColorComment
 *
 * @property int $id
 * @property int $timestamp
 * @property string $content
 * @property int $chinchilla_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ChinchillaColorComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ChinchillaColorComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ChinchillaColorComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ChinchillaColorComment whereChinchillaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ChinchillaColorComment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ChinchillaColorComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ChinchillaColorComment whereTimestamp($value)
 * @mixin \Eloquent
 */
class ChinchillaColorComment extends Model
{
    protected $fillable = ['timestamp', 'content', 'chinchilla_id'];

    public $timestamps = false;
}
