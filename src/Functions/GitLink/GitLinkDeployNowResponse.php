<?php

declare(strict_types=1);

namespace Zavudev\Functions\GitLink;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type GitLinkDeployNowResponseShape = array{scheduled: bool}
 */
final class GitLinkDeployNowResponse implements BaseModel
{
    /** @use SdkModel<GitLinkDeployNowResponseShape> */
    use SdkModel;

    #[Required]
    public bool $scheduled;

    /**
     * `new GitLinkDeployNowResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * GitLinkDeployNowResponse::with(scheduled: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new GitLinkDeployNowResponse)->withScheduled(...)
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
    public static function with(bool $scheduled): self
    {
        $self = new self;

        $self['scheduled'] = $scheduled;

        return $self;
    }

    public function withScheduled(bool $scheduled): self
    {
        $self = clone $this;
        $self['scheduled'] = $scheduled;

        return $self;
    }
}
