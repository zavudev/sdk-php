<?php

declare(strict_types=1);

namespace Zavudev\Functions\GitLink;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Change the branch, the root directory, or whether pushes deploy. Pass at least one field. `rootDir: null` clears the subdirectory.
 *
 * @see Zavudev\Services\Functions\GitLinkService::update()
 *
 * @phpstan-type GitLinkUpdateParamsShape = array{
 *   autoDeploy?: bool|null, branch?: string|null, rootDir?: string|null
 * }
 */
final class GitLinkUpdateParams implements BaseModel
{
    /** @use SdkModel<GitLinkUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?bool $autoDeploy;

    #[Optional]
    public ?string $branch;

    #[Optional(nullable: true)]
    public ?string $rootDir;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?bool $autoDeploy = null,
        ?string $branch = null,
        ?string $rootDir = null
    ): self {
        $self = new self;

        null !== $autoDeploy && $self['autoDeploy'] = $autoDeploy;
        null !== $branch && $self['branch'] = $branch;
        null !== $rootDir && $self['rootDir'] = $rootDir;

        return $self;
    }

    public function withAutoDeploy(bool $autoDeploy): self
    {
        $self = clone $this;
        $self['autoDeploy'] = $autoDeploy;

        return $self;
    }

    public function withBranch(string $branch): self
    {
        $self = clone $this;
        $self['branch'] = $branch;

        return $self;
    }

    public function withRootDir(?string $rootDir): self
    {
        $self = clone $this;
        $self['rootDir'] = $rootDir;

        return $self;
    }
}
