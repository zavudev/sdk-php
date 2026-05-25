<?php

declare(strict_types=1);

namespace Zavudev\Functions\FunctionNewResponse;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Functions\FunctionNewResponse\Function_\Runtime;
use Zavudev\Functions\FunctionNewResponse\Function_\Status;

/**
 * A Zavu Function — user-supplied TypeScript that runs in Zavu Cloud and reacts to messaging events or HTTP requests.
 *
 * @phpstan-type FunctionShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   dependencies: array<string,string>,
 *   httpEnabled: bool,
 *   memoryMB: int,
 *   name: string,
 *   runtime: Runtime|value-of<Runtime>,
 *   slug: string,
 *   status: Status|value-of<Status>,
 *   timeoutSec: int,
 *   updatedAt: \DateTimeInterface,
 *   activeDeploymentID?: string|null,
 *   description?: string|null,
 *   publicURL?: string|null,
 * }
 */
final class Function_ implements BaseModel
{
    /** @use SdkModel<FunctionShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * npm dependencies installed in the function bundle. Keys are package names, values are semver ranges.
     *
     * @var array<string,string> $dependencies
     */
    #[Required(map: 'string')]
    public array $dependencies;

    /**
     * Whether the function can be invoked over HTTPS via its public URL.
     */
    #[Required]
    public bool $httpEnabled;

    /**
     * Memory allocation in MB.
     */
    #[Required('memoryMb')]
    public int $memoryMB;

    #[Required]
    public string $name;

    /**
     * Runtime the function is deployed on.
     *
     * @var value-of<Runtime> $runtime
     */
    #[Required(enum: Runtime::class)]
    public string $runtime;

    /**
     * URL-safe identifier, unique per project.
     */
    #[Required]
    public string $slug;

    /**
     * Lifecycle status of a Zavu Function.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * Per-invocation timeout in seconds.
     */
    #[Required]
    public int $timeoutSec;

    #[Required]
    public \DateTimeInterface $updatedAt;

    /**
     * ID of the deployment currently serving traffic.
     */
    #[Optional('activeDeploymentId', nullable: true)]
    public ?string $activeDeploymentID;

    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * HTTPS endpoint when httpEnabled is true.
     */
    #[Optional('publicUrl', nullable: true)]
    public ?string $publicURL;

    /**
     * `new Function_()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Function_::with(
     *   id: ...,
     *   createdAt: ...,
     *   dependencies: ...,
     *   httpEnabled: ...,
     *   memoryMB: ...,
     *   name: ...,
     *   runtime: ...,
     *   slug: ...,
     *   status: ...,
     *   timeoutSec: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Function_)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withDependencies(...)
     *   ->withHTTPEnabled(...)
     *   ->withMemoryMB(...)
     *   ->withName(...)
     *   ->withRuntime(...)
     *   ->withSlug(...)
     *   ->withStatus(...)
     *   ->withTimeoutSec(...)
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
     * @param array<string,string> $dependencies
     * @param Runtime|value-of<Runtime> $runtime
     * @param Status|value-of<Status> $status
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        array $dependencies,
        bool $httpEnabled,
        int $memoryMB,
        string $name,
        Runtime|string $runtime,
        string $slug,
        Status|string $status,
        int $timeoutSec,
        \DateTimeInterface $updatedAt,
        ?string $activeDeploymentID = null,
        ?string $description = null,
        ?string $publicURL = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['dependencies'] = $dependencies;
        $self['httpEnabled'] = $httpEnabled;
        $self['memoryMB'] = $memoryMB;
        $self['name'] = $name;
        $self['runtime'] = $runtime;
        $self['slug'] = $slug;
        $self['status'] = $status;
        $self['timeoutSec'] = $timeoutSec;
        $self['updatedAt'] = $updatedAt;

        null !== $activeDeploymentID && $self['activeDeploymentID'] = $activeDeploymentID;
        null !== $description && $self['description'] = $description;
        null !== $publicURL && $self['publicURL'] = $publicURL;

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

    /**
     * npm dependencies installed in the function bundle. Keys are package names, values are semver ranges.
     *
     * @param array<string,string> $dependencies
     */
    public function withDependencies(array $dependencies): self
    {
        $self = clone $this;
        $self['dependencies'] = $dependencies;

        return $self;
    }

    /**
     * Whether the function can be invoked over HTTPS via its public URL.
     */
    public function withHTTPEnabled(bool $httpEnabled): self
    {
        $self = clone $this;
        $self['httpEnabled'] = $httpEnabled;

        return $self;
    }

    /**
     * Memory allocation in MB.
     */
    public function withMemoryMB(int $memoryMB): self
    {
        $self = clone $this;
        $self['memoryMB'] = $memoryMB;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Runtime the function is deployed on.
     *
     * @param Runtime|value-of<Runtime> $runtime
     */
    public function withRuntime(Runtime|string $runtime): self
    {
        $self = clone $this;
        $self['runtime'] = $runtime;

        return $self;
    }

    /**
     * URL-safe identifier, unique per project.
     */
    public function withSlug(string $slug): self
    {
        $self = clone $this;
        $self['slug'] = $slug;

        return $self;
    }

    /**
     * Lifecycle status of a Zavu Function.
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
     * Per-invocation timeout in seconds.
     */
    public function withTimeoutSec(int $timeoutSec): self
    {
        $self = clone $this;
        $self['timeoutSec'] = $timeoutSec;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * ID of the deployment currently serving traffic.
     */
    public function withActiveDeploymentID(?string $activeDeploymentID): self
    {
        $self = clone $this;
        $self['activeDeploymentID'] = $activeDeploymentID;

        return $self;
    }

    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * HTTPS endpoint when httpEnabled is true.
     */
    public function withPublicURL(?string $publicURL): self
    {
        $self = clone $this;
        $self['publicURL'] = $publicURL;

        return $self;
    }
}
