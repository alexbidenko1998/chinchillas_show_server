<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Chinchilla
 *
 * @property int $id
 * @property int $owner_id
 * @property string $status
 * @property int $is_ready
 * @property int $birthday
 * @property string $sex
 * @property int|null $breeder_id
 * @property string|null $weight
 * @property string|null $brothers
 * @property string|null $awards
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereAwards($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereBreederId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereBrothers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereIsReady($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereWeight($value)
 * @mixin \Eloquent
 */
class Chinchilla extends Model
{
    protected $fillable = [
        'name', 'owner_id', 'status', 'is_ready', 'birthday', 'sex', 'breeder_id', 'weight', 'brothers', 'awards', 'description', 'avatar',
    ];

    protected $hidden = [
      'avatar_id',
    ];

    public $timestamps = false;

    public function color()
    {
        return $this->hasOne('App\Color');
    }

    public function avatar()
    {
        return $this->hasOne('App\ChinchillaPhoto', 'id', 'avatar_id');
    }

    public function photos()
    {
        return $this->hasMany('App\ChinchillaPhoto');
    }
}
