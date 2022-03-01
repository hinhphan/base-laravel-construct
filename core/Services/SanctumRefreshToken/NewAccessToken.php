<?php

namespace Core\Services\SanctumRefreshToken;

use Laravel\Sanctum\NewAccessToken as SanctumNewAccessToken;

class NewAccessToken extends SanctumNewAccessToken
{
    /**
     * The plain text version of the refresh token.
     *
     * @var string
     */
    public $plainTextRefreshToken;

    /**
     * Expired at of access token
     */
    public $expiredAt;

    /**
     * Create a new access token result.
     *
     * @param  \Laravel\Sanctum\PersonalAccessToken  $accessToken
     * @param  string  $plainTextToken
     * @return void
     */
    public function __construct(PersonalAccessToken $accessToken, string $plainTextToken, string $plainTextRefreshToken)
    {
        $this->accessToken = $accessToken;
        $this->plainTextToken = $plainTextToken;
        $this->plainTextRefreshToken = $plainTextRefreshToken;
        $this->expiredAt = $this->accessToken->created_at->addMinutes(config('sanctum.expiration'))->format('Y-m-d H:i:s');
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'accessToken' => $this->accessToken,
            'plainTextToken' => $this->plainTextToken,
            'plainTextRefreshToken' => $this->plainTextRefreshToken
        ];
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
