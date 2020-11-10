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
 * @property string $name
 * @property int|null $avatar_id
 * @property int|null $mother_id
 * @property int|null $father_id
 * @property-read \App\ChinchillaPhoto|null $avatar
 * @property-read \App\Color|null $color
 * @property-read mixed $children
 * @property-read mixed $father
 * @property-read mixed $mother
 * @property-read mixed $relatives
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ChinchillaPhoto[] $photos
 * @property-read int|null $photos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Status[] $statuses
 * @property-read int|null $statuses_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereAvatarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereFatherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereMotherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereName($value)
 * @property string $conclusion
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ChinchillaColorComment[] $colorComments
 * @property-read int|null $color_comments_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chinchilla whereConclusion($value)
 */
class Chinchilla extends Model
{
    protected $fillable = [
        'name', 'owner_id', 'status', 'is_ready', 'birthday', 'sex', 'breeder_id', 'weight', 'brothers',
        'awards', 'description', 'avatar', 'conclusion',
    ];

    protected $hidden = [
      'avatar_id',
    ];

    public $timestamps = false;

    private $parentCount = 0;

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

    public function status()
    {
        return $this->hasOne('App\Status')->latest('timestamp');
    }

    public function owner()
    {
        return $this->hasOne('App\User', 'id', 'owner_id');
    }

    public function colorComments()
    {
        return $this->hasMany('App\ChinchillaColorComment')->orderBy('timestamp', 'desc');
    }

    public function getChildrenAttribute() {
        return Chinchilla::with('avatar')
            ->where('father_id', $this->id)->orWhere('mother_id', $this->id)->get();
    }

    public function getMotherAttribute() {
        $chinchilla = Chinchilla::with('avatar')->find($this->mother_id);
        if (isset($chinchilla)) $chinchilla->withParents($this->parentCount);
        return $chinchilla;
    }

    public function getFatherAttribute() {
        $chinchilla = Chinchilla::with('avatar')->find($this->father_id);
        if (isset($chinchilla)) $chinchilla->withParents($this->parentCount);
        return $chinchilla;
    }

    public function getRelativesAttribute() {
        return Chinchilla::with('avatar')
            ->where(function ($query) {
                $query->orWhereIn('father_id', [$this->father_id, $this->mother_id])
                    ->orWhereIn('mother_id', [$this->father_id, $this->mother_id]);
            })
            ->where('id', '!=', $this->id)
            ->get();
    }

    public function withParents($parentCount = 0) {
        $this->parentCount = $parentCount + 1;
        if ($this->parentCount < 4) $this->append(['mother', 'father']);
        return $this;
    }

    public function statuses() {
        return $this->hasMany('App\Status', 'chinchilla_id', 'id')->orderBy('timestamp', 'desc');
    }
}
