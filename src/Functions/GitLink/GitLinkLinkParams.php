<?php

declare(strict_types=1);

namespace Zavudev\Functions\GitLink;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Bind a repository to this function so every push to `branch` deploys it. A function holds at most one link; linking again returns 400.
 *
 * **The server decides how the link authenticates.** If the project has the Zavu GitHub App installed, the link uses that installation: private repositories work and there is nothing to configure in the repository. Otherwise it falls back to a manual link and the response carries a `webhookSecret` you add to the repository yourself. `connection` says which one you got.
 *
 * The repository is not checked against GitHub here, because it cannot be: an owner/repo that does not exist, or that the installation cannot see, is accepted and fails on the first deploy with a fetch error.
 *
 * @see Zavudev\Services\Functions\GitLinkService::link()
 *
 * @phpstan-type GitLinkLinkParamsShape = array{
 *   owner: string,
 *   repo: string,
 *   autoDeploy?: bool|null,
 *   branch?: string|null,
 *   rootDir?: string|null,
 * }
 */
final class GitLinkLinkParams implements BaseModel
{
    /** @use SdkModel<GitLinkLinkParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $owner;

    #[Required]
    public string $repo;

    #[Optional]
    public ?bool $autoDeploy;

    #[Optional]
    public ?string $branch;

    /**
     * Subdirectory holding the project, for monorepos.
     */
    #[Optional]
    public ?string $rootDir;

    /**
     * `new GitLinkLinkParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * GitLinkLinkParams::with(owner: ..., repo: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new GitLinkLinkParams)->withOwner(...)->withRepo(...)
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
    public static function with(
        string $owner,
        string $repo,
        ?bool $autoDeploy = null,
        ?string $branch = null,
        ?string $rootDir = null,
    ): self {
        $self = new self;

        $self['owner'] = $owner;
        $self['repo'] = $repo;

        null !== $autoDeploy && $self['autoDeploy'] = $autoDeploy;
        null !== $branch && $self['branch'] = $branch;
        null !== $rootDir && $self['rootDir'] = $rootDir;

        return $self;
    }

    public function withOwner(string $owner): self
    {
        $self = clone $this;
        $self['owner'] = $owner;

        return $self;
    }

    public function withRepo(string $repo): self
    {
        $self = clone $this;
        $self['repo'] = $repo;

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

    /**
     * Subdirectory holding the project, for monorepos.
     */
    public function withRootDir(string $rootDir): self
    {
        $self = clone $this;
        $self['rootDir'] = $rootDir;

        return $self;
    }
}
