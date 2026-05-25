<?php

declare(strict_types=1);

namespace Zavudev\Functions\FunctionGetDeploymentResponse;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Functions\FunctionGetDeploymentResponse\Deployment\Status;

/**
 * @phpstan-type DeploymentShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   functionID: string,
 *   status: Status|value-of<Status>,
 *   version: int,
 *   bundleBytes?: int|null,
 *   deployedAt?: \DateTimeInterface|null,
 *   errorMessage?: string|null,
 *   sourceCodeBytes?: int|null,
 * }
 */
final class Deployment implements BaseModel
{
    /** @use SdkModel<DeploymentShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required('functionId')]
    public string $functionID;

    /**
     * Stage of a function deployment.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * Monotonically increasing deployment version, starting at 1.
     */
    #[Required]
    public int $version;

    #[Optional(nullable: true)]
    public ?int $bundleBytes;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $deployedAt;

    /**
     * Failure reason when status is 'failed'.
     */
    #[Optional(nullable: true)]
    public ?string $errorMessage;

    #[Optional(nullable: true)]
    public ?int $sourceCodeBytes;

    /**
     * `new Deployment()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Deployment::with(
     *   id: ..., createdAt: ..., functionID: ..., status: ..., version: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Deployment)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withFunctionID(...)
     *   ->withStatus(...)
     *   ->withVersion(...)
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
     * @param Status|value-of<Status> $status
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        string $functionID,
        Status|string $status,
        int $version,
        ?int $bundleBytes = null,
        ?\DateTimeInterface $deployedAt = null,
        ?string $errorMessage = null,
        ?int $sourceCodeBytes = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['functionID'] = $functionID;
        $self['status'] = $status;
        $self['version'] = $version;

        null !== $bundleBytes && $self['bundleBytes'] = $bundleBytes;
        null !== $deployedAt && $self['deployedAt'] = $deployedAt;
        null !== $errorMessage && $self['errorMessage'] = $errorMessage;
        null !== $sourceCodeBytes && $self['sourceCodeBytes'] = $sourceCodeBytes;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

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

    /**
     * Monotonically increasing deployment version, starting at 1.
     */
    public function withVersion(int $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }

    public function withBundleBytes(?int $bundleBytes): self
    {
        $self = clone $this;
        $self['bundleBytes'] = $bundleBytes;

        return $self;
    }

    public function withDeployedAt(?\DateTimeInterface $deployedAt): self
    {
        $self = clone $this;
        $self['deployedAt'] = $deployedAt;

        return $self;
    }

    /**
     * Failure reason when status is 'failed'.
     */
    public function withErrorMessage(?string $errorMessage): self
    {
        $self = clone $this;
        $self['errorMessage'] = $errorMessage;

        return $self;
    }

    public function withSourceCodeBytes(?int $sourceCodeBytes): self
    {
        $self = clone $this;
        $self['sourceCodeBytes'] = $sourceCodeBytes;

        return $self;
    }
}
