<?php

declare(strict_types=1);

namespace Zavudev\SubAccounts\APIKeys;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\SubAccounts\APIKeys\APIKeyNewResponse\APIKey;

/**
 * @phpstan-import-type APIKeyShape from \Zavudev\SubAccounts\APIKeys\APIKeyNewResponse\APIKey
 *
 * @phpstan-type APIKeyNewResponseShape = array{apiKey: APIKey|APIKeyShape}
 */
final class APIKeyNewResponse implements BaseModel
{
    /** @use SdkModel<APIKeyNewResponseShape> */
    use SdkModel;

    #[Required]
    public APIKey $apiKey;

    /**
     * `new APIKeyNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * APIKeyNewResponse::with(apiKey: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new APIKeyNewResponse)->withAPIKey(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param APIKey|APIKeyShape $apiKey
     */
    public static function with(APIKey|array $apiKey): self
    {
        $self = new self;

        $self['apiKey'] = $apiKey;

        return $self;
    }

    /**
     * @param APIKey|APIKeyShape $apiKey
     */
    public function withAPIKey(APIKey|array $apiKey): self
    {
        $self = clone $this;
        $self['apiKey'] = $apiKey;

        return $self;
    }
}
