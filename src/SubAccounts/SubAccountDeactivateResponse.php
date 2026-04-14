<?php

declare(strict_types=1);

namespace Zavudev\SubAccounts;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type SubAccountDeactivateResponseShape = array{
 *   keysRevoked: int, message: string
 * }
 */
final class SubAccountDeactivateResponse implements BaseModel
{
    /** @use SdkModel<SubAccountDeactivateResponseShape> */
    use SdkModel;

    /**
     * Number of API keys revoked.
     */
    #[Required]
    public int $keysRevoked;

    #[Required]
    public string $message;

    /**
     * `new SubAccountDeactivateResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SubAccountDeactivateResponse::with(keysRevoked: ..., message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SubAccountDeactivateResponse)->withKeysRevoked(...)->withMessage(...)
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
    public static function with(int $keysRevoked, string $message): self
    {
        $self = new self;

        $self['keysRevoked'] = $keysRevoked;
        $self['message'] = $message;

        return $self;
    }

    /**
     * Number of API keys revoked.
     */
    public function withKeysRevoked(int $keysRevoked): self
    {
        $self = clone $this;
        $self['keysRevoked'] = $keysRevoked;

        return $self;
    }

    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
