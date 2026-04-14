<?php

declare(strict_types=1);

namespace Zavudev\SubAccounts;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type SubAccountShape from \Zavudev\SubAccounts\SubAccount
 *
 * @phpstan-type SubAccountNewResponseShape = array{
 *   subAccount: SubAccount|SubAccountShape
 * }
 */
final class SubAccountNewResponse implements BaseModel
{
    /** @use SdkModel<SubAccountNewResponseShape> */
    use SdkModel;

    #[Required]
    public SubAccount $subAccount;

    /**
     * `new SubAccountNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SubAccountNewResponse::with(subAccount: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SubAccountNewResponse)->withSubAccount(...)
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
     * @param SubAccount|SubAccountShape $subAccount
     */
    public static function with(SubAccount|array $subAccount): self
    {
        $self = new self;

        $self['subAccount'] = $subAccount;

        return $self;
    }

    /**
     * @param SubAccount|SubAccountShape $subAccount
     */
    public function withSubAccount(SubAccount|array $subAccount): self
    {
        $self = clone $this;
        $self['subAccount'] = $subAccount;

        return $self;
    }
}
