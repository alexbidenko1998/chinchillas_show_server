<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
 * @method static Builder|Chinchilla newModelQuery()
 * @method static Builder|Chinchilla newQuery()
 * @method static Builder|Chinchilla query()
 * @method static Builder|Chinchilla whereOwnerId($value)
 * @method static Builder|Chinchilla whereAwards($value)
 * @method static Builder|Chinchilla whereBirthday($value)
 * @method static Builder|Chinchilla whereBreederId($value)
 * @method static Builder|Chinchilla whereBrothers($value)
 * @method static Builder|Chinchilla whereDescription($value)
 * @method static Builder|Chinchilla whereId($value)
 * @method static Builder|Chinchilla whereIsReady($value)
 * @method static Builder|Chinchilla whereSex($value)
 * @method static Builder|Chinchilla whereStatus($value)
 * @method static Builder|Chinchilla whereWeight($value)
 * @mixin Eloquent
 * @property string $name
 * @property int|null $avatar_id
 * @property int|null $mother_id
 * @property int|null $father_id
 * @property-read ChinchillaPhoto|null $avatar
 * @property-read Color|null $color
 * @property-read mixed $children
 * @property-read mixed $father
 * @property-read mixed $mother
 * @property-read mixed $relatives
 * @property-read Collection|ChinchillaPhoto[] $photos
 * @property-read int|null $photos_count
 * @property-read Collection|Status[] $statuses
 * @property-read int|null $statuses_count
 * @method static Builder|Chinchilla whereAvatarId($value)
 * @method static Builder|Chinchilla whereFatherId($value)
 * @method static Builder|Chinchilla whereMotherId($value)
 * @method static Builder|Chinchilla whereName($value)
 * @property string $conclusion
 * @property-read Collection|ChinchillaColorComment[] $colorComments
 * @property-read int|null $color_comments_count
 * @method static Builder|Chinchilla whereConclusion($value)
 * @property string|null $breeder_type
 * @property-read User|null $breeder
 * @property-read User|null $owner
 * @method static Builder|Chinchilla whereBreederType($value)
 */
class Chinchilla extends Model
{
    protected $fillable = [
        'name', 'owner_id', 'status', 'is_ready', 'birthday', 'sex',
        'breeder_id', 'breeder_type', 'weight', 'brothers',
        'awards', 'description', 'avatar', 'conclusion',
    ];

    protected $hidden = [
      'avatar_id',
    ];

    public $timestamps = false;

    private $parentCount = 0;

    public function color()
    {
        return $this->hasOne(Color::class);
    }

    public function avatar()
    {
        return $this->hasOne(ChinchillaPhoto::class, 'id', 'avatar_id');
    }

    public function photos()
    {
        return $this->hasMany(ChinchillaPhoto::class);
    }

    public function status()
    {
        return $this->hasOne(Status::class)->latest('timestamp');
    }

    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

    public function breeder()
    {
        return $this->hasOne(User::class, 'id', 'breeder_id');
    }

    public function colorComments()
    {
        return $this->hasMany(ChinchillaColorComment::class)->orderBy('timestamp', 'desc');
    }

    public function getChildrenAttribute()
    {
        return self::with('avatar')
            ->where('father_id', $this->id)->orWhere('mother_id', $this->id)->get();
    }

    public function getMotherAttribute()
    {
        $chinchilla = self::with('avatar')->with('color')->find($this->mother_id);
        if (isset($chinchilla)) {
            $chinchilla->withParents($this->parentCount);
        }
        return $chinchilla;
    }

    public function getFatherAttribute()
    {
        $chinchilla = self::with('avatar')->with('color')->find($this->father_id);
        if (isset($chinchilla)) {
            $chinchilla->withParents($this->parentCount);
        }
        return $chinchilla;
    }

    public function getRelativesAttribute()
    {
        return self::with('avatar')
            ->where(function ($query) {
                $query->orWhereIn('father_id', [$this->father_id, $this->mother_id])
                    ->orWhereIn('mother_id', [$this->father_id, $this->mother_id]);
            })
            ->where('id', '!=', $this->id)
            ->get();
    }

    public function withParents($parentCount = 0)
    {
        $this->parentCount = $parentCount + 1;
        if ($this->parentCount < 4) {
            $this->append(['mother', 'father']);
        }
        return $this;
    }

    public function statuses()
    {
        return $this->hasMany(Status::class, 'chinchilla_id', 'id')->orderBy('timestamp', 'desc');
    }

    public function prices()
    {
        return $this->hasMany(Price::class, 'chinchilla_id', 'id')->orderBy('timestamp', 'desc');
    }

    public function priceRub()
    {
        return $this->hasOne(Price::class, 'chinchilla_id', 'id')->where('currency', 'RUB')->latest('timestamp');
    }

    public function priceEur()
    {
        return $this->hasOne(Price::class, 'chinchilla_id', 'id')->where('currency', 'EUR')->latest('timestamp');
    }
}
