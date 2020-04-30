<?php

namespace App;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color whereAngora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color whereBeige($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color whereBlue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color whereCalifornia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color whereChinchillaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color whereEbony($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color whereFur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color whereGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color whereLova($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color whereMosaic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color wherePearl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color whereRex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color whereSapphire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color whereStandard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color whereVelvet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color whereViolet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Color whereWhite($value)
 * @mixin \Eloquent
 */
class Color extends Model
{
    protected $fillable = [
        'chinchilla_id', 'standard', 'white', 'mosaic', 'beige', 'violet', 'sapphire',
        'angora', 'ebony', 'velvet', 'pearl', 'california', 'rex', 'lova', 'german', 'blue', 'fur',
    ];

    public $timestamps = false;
}
