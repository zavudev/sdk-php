<?php

declare(strict_types=1);

namespace Zavudev\Functions;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Functions\FunctionCreateParams\MemoryMB;
use Zavudev\Functions\FunctionCreateParams\Runtime;

/**
 * Create a new Zavu Function. The function starts in `draft` status. A dedicated API key is auto-provisioned and injected as the `ZAVU_API_KEY` secret so the function can call back into the Zavu API without manual setup.
 *
 * Provide `sourceCode` to seed the draft. Call `POST /v1/functions/{functionId}/deploy` afterwards to publish.
 *
 * @see Zavudev\Services\FunctionsService::create()
 *
 * @phpstan-type FunctionCreateParamsShape = array{
 *   name: string,
 *   slug: string,
 *   dependencies?: array<string,string>|null,
 *   description?: string|null,
 *   httpEnabled?: bool|null,
 *   memoryMB?: null|MemoryMB|value-of<MemoryMB>,
 *   runtime?: null|Runtime|value-of<Runtime>,
 *   sourceCode?: string|null,
 *   timeoutSec?: int|null,
 * }
 */
final class FunctionCreateParams implements BaseModel
{
    /** @use SdkModel<FunctionCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $name;

    /**
     * URL-safe identifier (lowercase, digits, hyphens). Must be unique per project.
     */
    #[Required]
    public string $slug;

    /**
     * npm dependencies. Keys are package names, values are semver ranges.
     *
     * @var array<string,string>|null $dependencies
     */
    #[Optional(map: 'string')]
    public ?array $dependencies;

    #[Optional]
    public ?string $description;

    /**
     * Whether to expose a public HTTPS URL for this function.
     */
    #[Optional]
    public ?bool $httpEnabled;

    /** @var value-of<MemoryMB>|null $memoryMB */
    #[Optional('memoryMb', enum: MemoryMB::class)]
    public ?int $memoryMB;

    /**
     * Runtime the function is deployed on.
     *
     * @var value-of<Runtime>|null $runtime
     */
    #[Optional(enum: Runtime::class)]
    public ?string $runtime;

    /**
     * TypeScript source code for the function entry point (max ~900KB).
     */
    #[Optional]
    public ?string $sourceCode;

    #[Optional]
    public ?int $timeoutSec;

    /**
     * `new FunctionCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FunctionCreateParams::with(name: ..., slug: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FunctionCreateParams)->withName(...)->withSlug(...)
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
     * @param array<string,string>|null $dependencies
     * @param MemoryMB|value-of<MemoryMB>|null $memoryMB
     * @param Runtime|value-of<Runtime>|null $runtime
     */
    public static function with(
        string $name,
        string $slug,
        ?array $dependencies = null,
        ?string $description = null,
        ?bool $httpEnabled = null,
        MemoryMB|int|null $memoryMB = null,
        Runtime|string|null $runtime = null,
        ?string $sourceCode = null,
        ?int $timeoutSec = null,
    ): self {
        $self = new self;

        $self['name'] = $name;
        $self['slug'] = $slug;

        null !== $dependencies && $self['dependencies'] = $dependencies;
        null !== $description && $self['description'] = $description;
        null !== $httpEnabled && $self['httpEnabled'] = $httpEnabled;
        null !== $memoryMB && $self['memoryMB'] = $memoryMB;
        null !== $runtime && $self['runtime'] = $runtime;
        null !== $sourceCode && $self['sourceCode'] = $sourceCode;
        null !== $timeoutSec && $self['timeoutSec'] = $timeoutSec;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * URL-safe identifier (lowercase, digits, hyphens). Must be unique per project.
     */
    public function withSlug(string $slug): self
    {
        $self = clone $this;
        $self['slug'] = $slug;

        return $self;
    }

    /**
     * npm dependencies. Keys are package names, values are semver ranges.
     *
     * @param array<string,string> $dependencies
     */
    public function withDependencies(array $dependencies): self
    {
        $self = clone $this;
        $self['dependencies'] = $dependencies;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Whether to expose a public HTTPS URL for this function.
     */
    public function withHTTPEnabled(bool $httpEnabled): self
    {
        $self = clone $this;
        $self['httpEnabled'] = $httpEnabled;

        return $self;
    }

    /**
     * @param MemoryMB|value-of<MemoryMB> $memoryMB
     */
    public function withMemoryMB(MemoryMB|int $memoryMB): self
    {
        $self = clone $this;
        $self['memoryMB'] = $memoryMB;

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
     * TypeScript source code for the function entry point (max ~900KB).
     */
    public function withSourceCode(string $sourceCode): self
    {
        $self = clone $this;
        $self['sourceCode'] = $sourceCode;

        return $self;
    }

    public function withTimeoutSec(int $timeoutSec): self
    {
        $self = clone $this;
        $self['timeoutSec'] = $timeoutSec;

        return $self;
    }
}
