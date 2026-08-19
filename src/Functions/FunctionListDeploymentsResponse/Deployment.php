<?php

declare(strict_types=1);

namespace Zavudev\Functions\FunctionListDeploymentsResponse;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Functions\FunctionListDeploymentsResponse\Deployment\Status;

/**
 * @phpstan-type DeploymentShape = array{
 *   id?: string|null,
 *   bundleSizeBytes?: int|null,
 *   createdAt?: \DateTimeInterface|null,
 *   deployedAt?: \DateTimeInterface|null,
 *   errorMessage?: string|null,
 *   isActive?: bool|null,
 *   status?: null|Status|value-of<Status>,
 *   version?: int|null,
 * }
 */
final class Deployment implements BaseModel
{
    /** @use SdkModel<DeploymentShape> */
    use SdkModel;

    #[Optional]
    public ?string $id;

    #[Optional(nullable: true)]
    public ?int $bundleSizeBytes;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $deployedAt;

    #[Optional(nullable: true)]
    public ?string $errorMessage;

    #[Optional]
    public ?bool $isActive;

    /**
     * Stage of a function deployment.
     *
     * @var value-of<Status>|null $status
     */
    #[Optional(enum: Status::class)]
    public ?string $status;

    #[Optional]
    public ?int $version;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Status|value-of<Status>|null $status
     */
    public static function with(
        ?string $id = null,
        ?int $bundleSizeBytes = null,
        ?\DateTimeInterface $createdAt = null,
        ?\DateTimeInterface $deployedAt = null,
        ?string $errorMessage = null,
        ?bool $isActive = null,
        Status|string|null $status = null,
        ?int $version = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $bundleSizeBytes && $self['bundleSizeBytes'] = $bundleSizeBytes;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $deployedAt && $self['deployedAt'] = $deployedAt;
        null !== $errorMessage && $self['errorMessage'] = $errorMessage;
        null !== $isActive && $self['isActive'] = $isActive;
        null !== $status && $self['status'] = $status;
        null !== $version && $self['version'] = $version;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withBundleSizeBytes(?int $bundleSizeBytes): self
    {
        $self = clone $this;
        $self['bundleSizeBytes'] = $bundleSizeBytes;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withDeployedAt(?\DateTimeInterface $deployedAt): self
    {
        $self = clone $this;
        $self['deployedAt'] = $deployedAt;

        return $self;
    }

    public function withErrorMessage(?string $errorMessage): self
    {
        $self = clone $this;
        $self['errorMessage'] = $errorMessage;

        return $self;
    }

    public function withIsActive(bool $isActive): self
    {
        $self = clone $this;
        $self['isActive'] = $isActive;

        return $self;
    }

    /**
     * Stage of a function deployment.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withVersion(int $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }
}
