<?php

declare(strict_types=1);

namespace Zavudev\Functions;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Update an existing function. `sourceCode` / `dependencies` edit the draft without triggering a build — they go live on the next `POST /v1/functions/{functionId}/deploy`. `httpEnabled` is applied to the deployed function immediately, so turning the public endpoint on or off does not require a redeploy.
 *
 * @see Zavudev\Services\FunctionsService::update()
 *
 * @phpstan-type FunctionUpdateParamsShape = array{
 *   dependencies?: array<string,string>|null,
 *   httpEnabled?: bool|null,
 *   sourceCode?: string|null,
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
     * Expose the function on its public HTTPS URL, or take it down. Applies to the already-deployed function without redeploying; the URL is returned as `publicUrl`.
     */
    #[Optional]
    public ?bool $httpEnabled;

    /**
     * New source code for the draft (replaces it).
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
        ?bool $httpEnabled = null,
        ?string $sourceCode = null,
    ): self {
        $self = new self;

        null !== $dependencies && $self['dependencies'] = $dependencies;
        null !== $httpEnabled && $self['httpEnabled'] = $httpEnabled;
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
     * Expose the function on its public HTTPS URL, or take it down. Applies to the already-deployed function without redeploying; the URL is returned as `publicUrl`.
     */
    public function withHTTPEnabled(bool $httpEnabled): self
    {
        $self = clone $this;
        $self['httpEnabled'] = $httpEnabled;

        return $self;
    }

    /**
     * New source code for the draft (replaces it).
     */
    public function withSourceCode(string $sourceCode): self
    {
        $self = clone $this;
        $self['sourceCode'] = $sourceCode;

        return $self;
    }
}
