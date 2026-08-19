<?php

declare(strict_types=1);

namespace Zavudev\Functions;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Functions\FunctionRollbackDeploymentResponse\Deployment;

/**
 * @phpstan-import-type DeploymentShape from \Zavudev\Functions\FunctionRollbackDeploymentResponse\Deployment
 *
 * @phpstan-type FunctionRollbackDeploymentResponseShape = array{
 *   deployment: Deployment|DeploymentShape,
 *   previousDraft?: mixed,
 *   rolledBackToVersion?: int|null,
 * }
 */
final class FunctionRollbackDeploymentResponse implements BaseModel
{
    /** @use SdkModel<FunctionRollbackDeploymentResponseShape> */
    use SdkModel;

    #[Required]
    public Deployment $deployment;

    /**
     * The draft that was replaced, so a UI can offer to restore it.
     */
    #[Optional(nullable: true)]
    public mixed $previousDraft;

    #[Optional]
    public ?int $rolledBackToVersion;

    /**
     * `new FunctionRollbackDeploymentResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FunctionRollbackDeploymentResponse::with(deployment: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FunctionRollbackDeploymentResponse)->withDeployment(...)
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
     * @param Deployment|DeploymentShape $deployment
     */
    public static function with(
        Deployment|array $deployment,
        mixed $previousDraft = null,
        ?int $rolledBackToVersion = null,
    ): self {
        $self = new self;

        $self['deployment'] = $deployment;

        null !== $previousDraft && $self['previousDraft'] = $previousDraft;
        null !== $rolledBackToVersion && $self['rolledBackToVersion'] = $rolledBackToVersion;

        return $self;
    }

    /**
     * @param Deployment|DeploymentShape $deployment
     */
    public function withDeployment(Deployment|array $deployment): self
    {
        $self = clone $this;
        $self['deployment'] = $deployment;

        return $self;
    }

    /**
     * The draft that was replaced, so a UI can offer to restore it.
     */
    public function withPreviousDraft(mixed $previousDraft): self
    {
        $self = clone $this;
        $self['previousDraft'] = $previousDraft;

        return $self;
    }

    public function withRolledBackToVersion(int $rolledBackToVersion): self
    {
        $self = clone $this;
        $self['rolledBackToVersion'] = $rolledBackToVersion;

        return $self;
    }
}
