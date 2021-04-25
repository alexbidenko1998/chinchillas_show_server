<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Color
 *
 * @property int $id
 * @property int $chinchilla_id
 * @property string|null $standard
 * @property string|null $white
 * @property string|null $mosaic
 * @property string|null $beige
 * @property string|null $violet
 * @property string|null $sapphire
 * @property string|null $angora
 * @property string|null $ebony
 * @property string|null $velvet
 * @property string|null $pearl
 * @property string|null $california
 * @property string|null $rex
 * @property string|null $lova
 * @property string|null $german
 * @property string|null $blue
 * @property string|null $fur
 * @method static Builder|Color newModelQuery()
 * @method static Builder|Color newQuery()
 * @method static Builder|Color query()
 * @method static Builder|Color whereAngora($value)
 * @method static Builder|Color whereBeige($value)
 * @method static Builder|Color whereBlue($value)
 * @method static Builder|Color whereCalifornia($value)
 * @method static Builder|Color whereChinchillaId($value)
 * @method static Builder|Color whereEbony($value)
 * @method static Builder|Color whereFur($value)
 * @method static Builder|Color whereGerman($value)
 * @method static Builder|Color whereId($value)
 * @method static Builder|Color whereLova($value)
 * @method static Builder|Color whereMosaic($value)
 * @method static Builder|Color wherePearl($value)
 * @method static Builder|Color whereRex($value)
 * @method static Builder|Color whereSapphire($value)
 * @method static Builder|Color whereStandard($value)
 * @method static Builder|Color whereVelvet($value)
 * @method static Builder|Color whereViolet($value)
 * @method static Builder|Color whereWhite($value)
 * @mixin Eloquent
 */
class Color extends Model
{
    protected $fillable = [
        'chinchilla_id', 'standard', 'white', 'mosaic', 'beige', 'violet', 'sapphire',
        'angora', 'ebony', 'velvet', 'pearl', 'california', 'rex', 'lova', 'german', 'blue', 'fur',
    ];

    public $timestamps = false;
}
