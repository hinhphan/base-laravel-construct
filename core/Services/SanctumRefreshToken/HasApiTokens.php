<?php

namespace Core\Services\SanctumRefreshToken;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens as SanctumHasApiTokens;

trait HasApiTokens
{
    use SanctumHasApiTokens;

    /**
     * Create a new personal access token for the user.
     *
     * @param  string  $name
     * @param  array  $abilities
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function createToken(string $name, array $abilities = ['*'])
    {
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
            'refresh_token' => hash('sha256', $plainTextRefreshToken = Str::random(100)),
        ]);

        return new NewAccessToken($token, $token->getKey().'|'.$plainTextToken, $token->getKey().'|'.$plainTextRefreshToken);
    }
}
