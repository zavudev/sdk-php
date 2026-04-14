<?php

declare(strict_types=1);

namespace Zavudev\URLs;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type VerifiedURLShape from \Zavudev\URLs\VerifiedURL
 *
 * @phpstan-type URLSubmitForVerificationResponseShape = array{
 *   url: VerifiedURL|VerifiedURLShape
 * }
 */
final class URLSubmitForVerificationResponse implements BaseModel
{
    /** @use SdkModel<URLSubmitForVerificationResponseShape> */
    use SdkModel;

    #[Required]
    public VerifiedURL $url;

    /**
     * `new URLSubmitForVerificationResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * URLSubmitForVerificationResponse::with(url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new URLSubmitForVerificationResponse)->withURL(...)
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
     * @param VerifiedURL|VerifiedURLShape $url
     */
    public static function with(VerifiedURL|array $url): self
    {
        $self = new self;

        $self['url'] = $url;

        return $self;
    }

    /**
     * @param VerifiedURL|VerifiedURLShape $url
     */
    public function withURL(VerifiedURL|array $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
