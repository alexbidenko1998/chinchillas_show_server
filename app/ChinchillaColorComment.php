<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\ChinchillaColorComment
 *
 * @property int $id
 * @property int $timestamp
 * @property string $content
 * @property int $chinchilla_id
 * @method static Builder|ChinchillaColorComment newModelQuery()
 * @method static Builder|ChinchillaColorComment newQuery()
 * @method static Builder|ChinchillaColorComment query()
 * @method static Builder|ChinchillaColorComment whereChinchillaId($value)
 * @method static Builder|ChinchillaColorComment whereContent($value)
 * @method static Builder|ChinchillaColorComment whereId($value)
 * @method static Builder|ChinchillaColorComment whereTimestamp($value)
 * @mixin Eloquent
 */
class ChinchillaColorComment extends Model
{
    protected $fillable = ['timestamp', 'content', 'chinchilla_id'];

    public $timestamps = false;
}
