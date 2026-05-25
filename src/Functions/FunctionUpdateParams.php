<?php

declare(strict_types=1);

namespace Zavudev\Functions;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Update the draft source code and/or dependency map without triggering a build. Visible in the dashboard immediately, but the live (deployed) function does not change until `POST /v1/functions/{functionId}/deploy` runs.
 *
 * @see Zavudev\Services\FunctionsService::update()
 *
 * @phpstan-type FunctionUpdateParamsShape = array{
 *   dependencies?: array<string,string>|null, sourceCode?: string|null
 * }
 */
final class FunctionUpdateParams implements BaseModel
{
    /** @use SdkModel<FunctionUpdateParamsShape> */
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
