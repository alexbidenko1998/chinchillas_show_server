<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\Client;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Token;

/**
 * App\User
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $token
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $avatar
 * @property int $timestamp
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLogin($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User whereTimestamp($value)
 * @method static Builder|User whereToken($value)
 * @mixin Eloquent
 * @property int $registrationDate
 * @property-read Collection|Client[] $clients
 * @property-read int|null $clients_count
 * @property-read Collection|Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static Builder|User whereRegistrationDate($value)
 * @property int $registration_date
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $patronymic
 * @property string|null $city
 * @property string|null $country
 * @method static Builder|User whereCity($value)
 * @method static Builder|User whereCountry($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User wherePatronymic($value)
 * @property string $type
 * @property int $admitted
 * @method static Builder|User whereAdmitted($value)
 * @method static Builder|User whereType($value)
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'login', 'email', 'password', 'phone', 'first_name', 'last_name', 'patronymic',
        'country', 'city', 'registration_date', 'type', 'admitted'
    ];

    protected $hidden = [
        'password', 'token',
    ];

    public $timestamps = false;
}
