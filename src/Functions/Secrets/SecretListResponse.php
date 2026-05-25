<?php

declare(strict_types=1);

namespace Zavudev\Functions\Secrets;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Functions\Secrets\SecretListResponse\Secret;

/**
 * @phpstan-import-type SecretShape from \Zavudev\Functions\Secrets\SecretListResponse\Secret
 *
 * @phpstan-type SecretListResponseShape = array{secrets: list<Secret|SecretShape>}
 */
final class SecretListResponse implements BaseModel
{
    /** @use SdkModel<SecretListResponseShape> */
    use SdkModel;

    /** @var list<Secret> $secrets */
    #[Required(list: Secret::class)]
    public array $secrets;

    /**
     * `new SecretListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SecretListResponse::with(secrets: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SecretListResponse)->withSecrets(...)
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
     * @param list<Secret|SecretShape> $secrets
     */
    public static function with(array $secrets): self
    {
        $self = new self;

        $self['secrets'] = $secrets;

        return $self;
    }

    /**
     * @param list<Secret|SecretShape> $secrets
     */
    public function withSecrets(array $secrets): self
    {
        $self = clone $this;
        $self['secrets'] = $secrets;

        return $self;
    }
}
