<?php

declare(strict_types=1);

namespace Zavudev\SubAccounts;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type SubAccountShape from \Zavudev\SubAccounts\SubAccount
 *
 * @phpstan-type SubAccountGetResponseShape = array{
 *   subAccount: SubAccount|SubAccountShape
 * }
 */
final class SubAccountGetResponse implements BaseModel
{
    /** @use SdkModel<SubAccountGetResponseShape> */
    use SdkModel;

    #[Required]
    public SubAccount $subAccount;

    /**
     * `new SubAccountGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SubAccountGetResponse::with(subAccount: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SubAccountGetResponse)->withSubAccount(...)
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
