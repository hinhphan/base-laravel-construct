<?php

namespace Core\Services\SanctumRefreshToken;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'abilities' => 'json',
        'last_used_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'token',
        'refresh_token',
        'abilities',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'token',
        'refresh_token',
    ];

    /**
     * Find the refresh token instance matching the given refresh token.
     *
     * @param  string  $token
     * @return static|null
     */
    public static function findRefreshToken($token)
    {
        if (strpos($token, '|') === false) {
            return static::where('refresh_token', hash('sha256', $token))->first();
        }

        [$id, $token] = explode('|', $token, 2);

        if ($instance = static::find($id)) {
            return hash_equals($instance->refresh_token, hash('sha256', $token)) ? $instance : null;
        }
    }

    public function isValidRefreshToken() {
        $expiretionRefreshToken = config('sanctum.expiretion_refresh_token');

        if (!$expiretionRefreshToken) {
            return true;
        }

        return $this->created_at->gt(now()->subMinutes($expiretionRefreshToken));
    }
}
