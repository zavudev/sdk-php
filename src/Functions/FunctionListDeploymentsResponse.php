<?php

declare(strict_types=1);

namespace Zavudev\Functions;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Functions\FunctionListDeploymentsResponse\Deployment;

/**
 * @phpstan-import-type DeploymentShape from \Zavudev\Functions\FunctionListDeploymentsResponse\Deployment
 *
 * @phpstan-type FunctionListDeploymentsResponseShape = array{
 *   deployments: list<Deployment|DeploymentShape>
 * }
 */
final class FunctionListDeploymentsResponse implements BaseModel
{
    /** @use SdkModel<FunctionListDeploymentsResponseShape> */
    use SdkModel;

    /** @var list<Deployment> $deployments */
    #[Required(list: Deployment::class)]
    public array $deployments;

    /**
     * `new FunctionListDeploymentsResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FunctionListDeploymentsResponse::with(deployments: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FunctionListDeploymentsResponse)->withDeployments(...)
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
     * @param list<Deployment|DeploymentShape> $deployments
     */
    public static function with(array $deployments): self
    {
        $self = new self;

        $self['deployments'] = $deployments;

        return $self;
    }

    /**
     * @param list<Deployment|DeploymentShape> $deployments
     */
    public function withDeployments(array $deployments): self
    {
        $self = clone $this;
        $self['deployments'] = $deployments;

        return $self;
    }
}
