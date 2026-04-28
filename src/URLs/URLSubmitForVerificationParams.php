<?php

declare(strict_types=1);

namespace Zavudev\URLs;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Submit a URL for verification. URLs are automatically checked against Google Web Risk API. Safe URLs are auto-approved, malicious URLs are blocked. URL shorteners (bit.ly, t.co, etc.) are always blocked.
 *
 * **Important:** All SMS and Email messages containing URLs require those URLs to be verified before the message can be sent. This endpoint allows pre-verification of URLs.
 *
 * @see Zavudev\Services\URLsService::submitForVerification()
 *
 * @phpstan-type URLSubmitForVerificationParamsShape = array{url: string}
 */
final class URLSubmitForVerificationParams implements BaseModel
{
    /** @use SdkModel<URLSubmitForVerificationParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The URL to submit for verification.
     */
    #[Required]
    public string $url;

    /**
     * `new URLSubmitForVerificationParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * URLSubmitForVerificationParams::with(url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new URLSubmitForVerificationParams)->withURL(...)
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
    public static function with(string $url): self
    {
        $self = new self;

        $self['url'] = $url;

        return $self;
    }

    /**
     * The URL to submit for verification.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
