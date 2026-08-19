<?php

declare(strict_types=1);

namespace Zavudev\URLs;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type VerifiedURLShape from \Zavudev\URLs\VerifiedURL
 *
 * @phpstan-type URLEscalateResponseShape = array{
 *   message: string, url: VerifiedURL|VerifiedURLShape
 * }
 */
final class URLEscalateResponse implements BaseModel
{
    /** @use SdkModel<URLEscalateResponseShape> */
    use SdkModel;

    #[Required]
    public string $message;

    #[Required]
    public VerifiedURL $url;

    /**
     * `new URLEscalateResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * URLEscalateResponse::with(message: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new URLEscalateResponse)->withMessage(...)->withURL(...)
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
    public static function with(string $message, VerifiedURL|array $url): self
    {
        $self = new self;

        $self['message'] = $message;
        $self['url'] = $url;

        return $self;
    }

    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

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
