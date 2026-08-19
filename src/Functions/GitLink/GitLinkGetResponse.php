<?php

declare(strict_types=1);

namespace Zavudev\Functions\GitLink;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Functions\GitLink\GitLinkGetResponse\Link;

/**
 * @phpstan-import-type LinkShape from \Zavudev\Functions\GitLink\GitLinkGetResponse\Link
 *
 * @phpstan-type GitLinkGetResponseShape = array{
 *   link: Link|LinkShape, webhookURL: string, webhookSecret?: string|null
 * }
 */
final class GitLinkGetResponse implements BaseModel
{
    /** @use SdkModel<GitLinkGetResponseShape> */
    use SdkModel;

    /**
     * A GitHub repository bound to a function. A push to `branch` deploys the function. A function holds at most one link.
     */
    #[Required]
    public Link $link;

    /**
     * Endpoint that receives GitHub's push deliveries. Only needed on a `manual` link, where you add it to the repository yourself.
     */
    #[Required('webhookUrl')]
    public string $webhookURL;

    /**
     * Shared secret for the repository's webhook. **Returned only when creating a `manual` link, and only there** — every later read strips it, and re-linking mints a new one. Absent entirely on an `app` link, which needs no secret of its own.
     */
    #[Optional]
    public ?string $webhookSecret;

    /**
     * `new GitLinkGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * GitLinkGetResponse::with(link: ..., webhookURL: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new GitLinkGetResponse)->withLink(...)->withWebhookURL(...)
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
     * @param Link|LinkShape $link
     */
    public static function with(
        Link|array $link,
        string $webhookURL,
        ?string $webhookSecret = null
    ): self {
        $self = new self;

        $self['link'] = $link;
        $self['webhookURL'] = $webhookURL;

        null !== $webhookSecret && $self['webhookSecret'] = $webhookSecret;

        return $self;
    }

    /**
     * A GitHub repository bound to a function. A push to `branch` deploys the function. A function holds at most one link.
     *
     * @param Link|LinkShape $link
     */
    public function withLink(Link|array $link): self
    {
        $self = clone $this;
        $self['link'] = $link;

        return $self;
    }

    /**
     * Endpoint that receives GitHub's push deliveries. Only needed on a `manual` link, where you add it to the repository yourself.
     */
    public function withWebhookURL(string $webhookURL): self
    {
        $self = clone $this;
        $self['webhookURL'] = $webhookURL;

        return $self;
    }

    /**
     * Shared secret for the repository's webhook. **Returned only when creating a `manual` link, and only there** — every later read strips it, and re-linking mints a new one. Absent entirely on an `app` link, which needs no secret of its own.
     */
    public function withWebhookSecret(string $webhookSecret): self
    {
        $self = clone $this;
        $self['webhookSecret'] = $webhookSecret;

        return $self;
    }
}
