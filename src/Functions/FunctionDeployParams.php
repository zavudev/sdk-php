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
 *   dependencies?: array<string,string>|null, sourceCode?: string|null
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
     * New source code to publish (replaces the draft).
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
     */
    public static function with(
        ?array $dependencies = null,
        ?string $sourceCode = null
    ): self {
        $self = new self;

        null !== $dependencies && $self['dependencies'] = $dependencies;
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
     * New source code to publish (replaces the draft).
     */
    public function withSourceCode(string $sourceCode): self
    {
        $self = clone $this;
        $self['sourceCode'] = $sourceCode;

        return $self;
    }
}
