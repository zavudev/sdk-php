<?php

declare(strict_types=1);

namespace Zavudev\Functions;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Functions\FunctionDeployResponse\Deployment;

/**
 * @phpstan-import-type DeploymentShape from \Zavudev\Functions\FunctionDeployResponse\Deployment
 *
 * @phpstan-type FunctionDeployResponseShape = array{
 *   deployment: Deployment|DeploymentShape
 * }
 */
final class FunctionDeployResponse implements BaseModel
{
    /** @use SdkModel<FunctionDeployResponseShape> */
    use SdkModel;

    #[Required]
    public Deployment $deployment;

    /**
     * `new FunctionDeployResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FunctionDeployResponse::with(deployment: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FunctionDeployResponse)->withDeployment(...)
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
