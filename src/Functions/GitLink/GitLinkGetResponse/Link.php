<?php

declare(strict_types=1);

namespace Zavudev\Functions\GitLink\GitLinkGetResponse;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Functions\GitLink\GitLinkGetResponse\Link\Connection;
use Zavudev\Functions\GitLink\GitLinkGetResponse\Link\LastStatus;
use Zavudev\Functions\GitLink\GitLinkGetResponse\Link\Provider;

/**
 * A GitHub repository bound to a function. A push to `branch` deploys the function. A function holds at most one link.
 *
 * @phpstan-type LinkShape = array{
 *   id: string,
 *   autoDeploy: bool,
 *   branch: string,
 *   connection: Connection|value-of<Connection>,
 *   createdAt: \DateTimeInterface,
 *   functionID: string,
 *   owner: string,
 *   provider: Provider|value-of<Provider>,
 *   repo: string,
 *   updatedAt: \DateTimeInterface,
 *   lastCommitMessage?: string|null,
 *   lastCommitSha?: string|null,
 *   lastDeployAt?: \DateTimeInterface|null,
 *   lastError?: string|null,
 *   lastStatus?: null|LastStatus|value-of<LastStatus>,
 *   rootDir?: string|null,
 * }
 */
final class Link implements BaseModel
{
    /** @use SdkModel<LinkShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * When false the link is kept and pushes are ignored.
     */
    #[Required]
    public bool $autoDeploy;

    /**
     * Only pushes to this branch deploy.
     */
    #[Required]
    public string $branch;

    /**
     * How this link authenticates, decided by the server rather than by the caller.
     * - `app`: the Zavu GitHub App is installed on the account. Pushes arrive on the app's webhook and private repositories work. Nothing to configure in the repository.
     * - `manual`: no installation. The link carries its own secret and you add the webhook to the repository yourself.
     *
     * @var value-of<Connection> $connection
     */
    #[Required(enum: Connection::class)]
    public string $connection;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required('functionId')]
    public string $functionID;

    #[Required]
    public string $owner;

    /** @var value-of<Provider> $provider */
    #[Required(enum: Provider::class)]
    public string $provider;

    #[Required]
    public string $repo;

    #[Required]
    public \DateTimeInterface $updatedAt;

    #[Optional(nullable: true)]
    public ?string $lastCommitMessage;

    #[Optional(nullable: true)]
    public ?string $lastCommitSha;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $lastDeployAt;

    /**
     * Why the last deploy failed. Null otherwise.
     */
    #[Optional(nullable: true)]
    public ?string $lastError;

    /** @var value-of<LastStatus>|null $lastStatus */
    #[Optional(enum: LastStatus::class, nullable: true)]
    public ?string $lastStatus;

    /**
     * Subdirectory holding the project, for monorepos. Null when the project is at the repository root.
     */
    #[Optional(nullable: true)]
    public ?string $rootDir;

    /**
     * `new Link()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Link::with(
     *   id: ...,
     *   autoDeploy: ...,
     *   branch: ...,
     *   connection: ...,
     *   createdAt: ...,
     *   functionID: ...,
     *   owner: ...,
     *   provider: ...,
     *   repo: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Link)
     *   ->withID(...)
     *   ->withAutoDeploy(...)
     *   ->withBranch(...)
     *   ->withConnection(...)
     *   ->withCreatedAt(...)
     *   ->withFunctionID(...)
     *   ->withOwner(...)
     *   ->withProvider(...)
     *   ->withRepo(...)
     *   ->withUpdatedAt(...)
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
     * @param Connection|value-of<Connection> $connection
     * @param Provider|value-of<Provider> $provider
     * @param LastStatus|value-of<LastStatus>|null $lastStatus
     */
    public static function with(
        string $id,
        bool $autoDeploy,
        string $branch,
        Connection|string $connection,
        \DateTimeInterface $createdAt,
        string $functionID,
        string $owner,
        Provider|string $provider,
        string $repo,
        \DateTimeInterface $updatedAt,
        ?string $lastCommitMessage = null,
        ?string $lastCommitSha = null,
        ?\DateTimeInterface $lastDeployAt = null,
        ?string $lastError = null,
        LastStatus|string|null $lastStatus = null,
        ?string $rootDir = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['autoDeploy'] = $autoDeploy;
        $self['branch'] = $branch;
        $self['connection'] = $connection;
        $self['createdAt'] = $createdAt;
        $self['functionID'] = $functionID;
        $self['owner'] = $owner;
        $self['provider'] = $provider;
        $self['repo'] = $repo;
        $self['updatedAt'] = $updatedAt;

        null !== $lastCommitMessage && $self['lastCommitMessage'] = $lastCommitMessage;
        null !== $lastCommitSha && $self['lastCommitSha'] = $lastCommitSha;
        null !== $lastDeployAt && $self['lastDeployAt'] = $lastDeployAt;
        null !== $lastError && $self['lastError'] = $lastError;
        null !== $lastStatus && $self['lastStatus'] = $lastStatus;
        null !== $rootDir && $self['rootDir'] = $rootDir;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * When false the link is kept and pushes are ignored.
     */
    public function withAutoDeploy(bool $autoDeploy): self
    {
        $self = clone $this;
        $self['autoDeploy'] = $autoDeploy;

        return $self;
    }

    /**
     * Only pushes to this branch deploy.
     */
    public function withBranch(string $branch): self
    {
        $self = clone $this;
        $self['branch'] = $branch;

        return $self;
    }

    /**
     * How this link authenticates, decided by the server rather than by the caller.
     * - `app`: the Zavu GitHub App is installed on the account. Pushes arrive on the app's webhook and private repositories work. Nothing to configure in the repository.
     * - `manual`: no installation. The link carries its own secret and you add the webhook to the repository yourself.
     *
     * @param Connection|value-of<Connection> $connection
     */
    public function withConnection(Connection|string $connection): self
    {
        $self = clone $this;
        $self['connection'] = $connection;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withFunctionID(string $functionID): self
    {
        $self = clone $this;
        $self['functionID'] = $functionID;

        return $self;
    }

    public function withOwner(string $owner): self
    {
        $self = clone $this;
        $self['owner'] = $owner;

        return $self;
    }

    /**
     * @param Provider|value-of<Provider> $provider
     */
    public function withProvider(Provider|string $provider): self
    {
        $self = clone $this;
        $self['provider'] = $provider;

        return $self;
    }

    public function withRepo(string $repo): self
    {
        $self = clone $this;
        $self['repo'] = $repo;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withLastCommitMessage(?string $lastCommitMessage): self
    {
        $self = clone $this;
        $self['lastCommitMessage'] = $lastCommitMessage;

        return $self;
    }

    public function withLastCommitSha(?string $lastCommitSha): self
    {
        $self = clone $this;
        $self['lastCommitSha'] = $lastCommitSha;

        return $self;
    }

    public function withLastDeployAt(?\DateTimeInterface $lastDeployAt): self
    {
        $self = clone $this;
        $self['lastDeployAt'] = $lastDeployAt;

        return $self;
    }

    /**
     * Why the last deploy failed. Null otherwise.
     */
    public function withLastError(?string $lastError): self
    {
        $self = clone $this;
        $self['lastError'] = $lastError;

        return $self;
    }

    /**
     * @param LastStatus|value-of<LastStatus>|null $lastStatus
     */
    public function withLastStatus(LastStatus|string|null $lastStatus): self
    {
        $self = clone $this;
        $self['lastStatus'] = $lastStatus;

        return $self;
    }

    /**
     * Subdirectory holding the project, for monorepos. Null when the project is at the repository root.
     */
    public function withRootDir(?string $rootDir): self
    {
        $self = clone $this;
        $self['rootDir'] = $rootDir;

        return $self;
    }
}
