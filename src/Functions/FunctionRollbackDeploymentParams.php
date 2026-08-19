<?php

declare(strict_types=1);

namespace Zavudev\Functions;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Re-deploy a previous version by copying its source, dependencies, and runtime pin onto the function's draft, then deploying. Returns immediately with a deployment ID — poll GET /v1/functions/deployments/{deploymentId} until status is active or failed. Secrets are not rolled back.
 *
 * @see Zavudev\Services\FunctionsService::rollbackDeployment()
 *
 * @phpstan-type FunctionRollbackDeploymentParamsShape = array{
 *   deploymentID: string
 * }
 */
final class FunctionRollbackDeploymentParams implements BaseModel
{
    /** @use SdkModel<FunctionRollbackDeploymentParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the deployment to roll back to.
     */
    #[Required('deploymentId')]
    public string $deploymentID;

    /**
     * `new FunctionRollbackDeploymentParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FunctionRollbackDeploymentParams::with(deploymentID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FunctionRollbackDeploymentParams)->withDeploymentID(...)
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
     */
    public static function with(string $deploymentID): self
    {
        $self = new self;

        $self['deploymentID'] = $deploymentID;

        return $self;
    }

    /**
     * ID of the deployment to roll back to.
     */
    public function withDeploymentID(string $deploymentID): self
    {
        $self = clone $this;
        $self['deploymentID'] = $deploymentID;

        return $self;
    }
}
