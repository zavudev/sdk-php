<?php

declare(strict_types=1);

namespace Zavudev\Functions;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Publish the function. If `sourceCode` or `dependencies` are provided in the body, they replace the current draft before deployment. Returns immediately with a deployment ID — poll `GET /v1/functions/deployments/{deploymentId}` until status is `active` or `failed`.
 *
 * @see Zavudev\Services\FunctionsService::deploy()
 *
 * @phpstan-type FunctionDeployParamsShape = array{
 *   dependencies?: array<string,string>|null,
 *   entrypoint?: string|null,
 *   files?: array<string,string>|null,
 *   sourceCode?: string|null,
 * }
 */
final class FunctionDeployParams implements BaseModel
{
    /** @use SdkModel<FunctionDeployParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * New dependency map (replaces existing dependencies).
     *
     * @var array<string,string>|null $dependencies
     */
    #[Optional(map: 'string')]
    public ?array $dependencies;

    /**
     * Which file in `files` is the entry point. Defaults to `index.ts`.
     */
    #[Optional]
    public ?string $entrypoint;

    /**
     * The project's source files, keyed by path relative to the project root (e.g. `index.ts`, `lib/orders.ts`). Imports between them are resolved when the function is built, so a function can be split across as many files as it needs.
     *
     * Paths must be relative and use forward slashes; `..`, `node_modules/` and `package.json` are rejected. npm packages are not uploaded here — declare them under `dependencies` and Zavu installs them. Limits: 200 files and 900,000 bytes for the whole tree.
     *
     * @var array<string,string>|null $files
     */
    #[Optional(map: 'string')]
    public ?array $files;

    /**
     * Shortcut for a single-file function: exactly equivalent to sending `files` with one entry named after `entrypoint` (`index.ts` by default). Fully supported — use whichever fits. If both are sent, `files` wins.
     */
    #[Optional]
    public ?string $sourceCode;

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
     * @param array<string,string>|null $files
     */
    public static function with(
        ?array $dependencies = null,
        ?string $entrypoint = null,
        ?array $files = null,
        ?string $sourceCode = null,
    ): self {
        $self = new self;

        null !== $dependencies && $self['dependencies'] = $dependencies;
        null !== $entrypoint && $self['entrypoint'] = $entrypoint;
        null !== $files && $self['files'] = $files;
        null !== $sourceCode && $self['sourceCode'] = $sourceCode;

        return $self;
    }

    /**
     * New dependency map (replaces existing dependencies).
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
     * Which file in `files` is the entry point. Defaults to `index.ts`.
     */
    public function withEntrypoint(string $entrypoint): self
    {
        $self = clone $this;
        $self['entrypoint'] = $entrypoint;

        return $self;
    }

    /**
     * The project's source files, keyed by path relative to the project root (e.g. `index.ts`, `lib/orders.ts`). Imports between them are resolved when the function is built, so a function can be split across as many files as it needs.
     *
     * Paths must be relative and use forward slashes; `..`, `node_modules/` and `package.json` are rejected. npm packages are not uploaded here — declare them under `dependencies` and Zavu installs them. Limits: 200 files and 900,000 bytes for the whole tree.
     *
     * @param array<string,string> $files
     */
    public function withFiles(array $files): self
    {
        $self = clone $this;
        $self['files'] = $files;

        return $self;
    }

    /**
     * Shortcut for a single-file function: exactly equivalent to sending `files` with one entry named after `entrypoint` (`index.ts` by default). Fully supported — use whichever fits. If both are sent, `files` wins.
     */
    public function withSourceCode(string $sourceCode): self
    {
        $self = clone $this;
        $self['sourceCode'] = $sourceCode;

        return $self;
    }
}
