<?php

declare(strict_types=1);

namespace Zavudev\SubAccounts;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type SubAccountShape from \Zavudev\SubAccounts\SubAccount
 *
 * @phpstan-type SubAccountUpdateResponseShape = array{
 *   subAccount: SubAccount|SubAccountShape
 * }
 */
final class SubAccountUpdateResponse implements BaseModel
{
    /** @use SdkModel<SubAccountUpdateResponseShape> */
    use SdkModel;

    #[Required]
    public SubAccount $subAccount;

    /**
     * `new SubAccountUpdateResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SubAccountUpdateResponse::with(subAccount: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SubAccountUpdateResponse)->withSubAccount(...)
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
