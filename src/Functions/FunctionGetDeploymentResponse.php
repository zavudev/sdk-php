<?php

declare(strict_types=1);

namespace Zavudev\Functions;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Functions\FunctionGetDeploymentResponse\Deployment;

/**
 * @phpstan-import-type DeploymentShape from \Zavudev\Functions\FunctionGetDeploymentResponse\Deployment
 *
 * @phpstan-type FunctionGetDeploymentResponseShape = array{
 *   deployment: Deployment|DeploymentShape
 * }
 */
final class FunctionGetDeploymentResponse implements BaseModel
{
    /** @use SdkModel<FunctionGetDeploymentResponseShape> */
    use SdkModel;

    #[Required]
    public Deployment $deployment;

    /**
     * `new FunctionGetDeploymentResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FunctionGetDeploymentResponse::with(deployment: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FunctionGetDeploymentResponse)->withDeployment(...)
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
    public static function with(Deployment|array $deployment): self
    {
        $self = new self;

        $self['deployment'] = $deployment;

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
}
