<?php

declare(strict_types=1);

namespace Zavudev\SubAccounts\APIKeys;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Revoke sub-account API key. Requires a parent project API key; sub-account API keys receive HTTP 403.
 *
 * @see Zavudev\Services\SubAccounts\APIKeysService::revoke()
 *
 * @phpstan-type APIKeyRevokeParamsShape = array{id: string}
 */
final class APIKeyRevokeParams implements BaseModel
{
    /** @use SdkModel<APIKeyRevokeParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $id;

    /**
     * `new APIKeyRevokeParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * APIKeyRevokeParams::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new APIKeyRevokeParams)->withID(...)
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
     */
    public static function with(string $id): self
    {
        $self = new self;

        $self['id'] = $id;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }
}
