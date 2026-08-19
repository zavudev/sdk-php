<?php

declare(strict_types=1);

namespace Zavudev\Functions;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * List a function's deployment history, newest first. Source code is omitted; fetch a single deployment via GET /v1/functions/deployments/{deploymentId} for full details.
 *
 * @see Zavudev\Services\FunctionsService::listDeployments()
 *
 * @phpstan-type FunctionListDeploymentsParamsShape = array{limit?: int|null}
 */
final class FunctionListDeploymentsParams implements BaseModel
{
    /** @use SdkModel<FunctionListDeploymentsParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?int $limit;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $limit = null): self
    {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }
}
