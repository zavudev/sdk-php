<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Brands;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Number10dlc\Brands\BrandListUseCasesResponse\UseCase;

/**
 * @phpstan-import-type UseCaseShape from \Zavudev\Number10dlc\Brands\BrandListUseCasesResponse\UseCase
 *
 * @phpstan-type BrandListUseCasesResponseShape = array{
 *   useCases: list<UseCase|UseCaseShape>
 * }
 */
final class BrandListUseCasesResponse implements BaseModel
{
    /** @use SdkModel<BrandListUseCasesResponseShape> */
    use SdkModel;

    /** @var list<UseCase> $useCases */
    #[Required(list: UseCase::class)]
    public array $useCases;

    /**
     * `new BrandListUseCasesResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrandListUseCasesResponse::with(useCases: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrandListUseCasesResponse)->withUseCases(...)
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
     * @param list<UseCase|UseCaseShape> $useCases
     */
    public static function with(array $useCases): self
    {
        $self = new self;

        $self['useCases'] = $useCases;

        return $self;
    }

    /**
     * @param list<UseCase|UseCaseShape> $useCases
     */
    public function withUseCases(array $useCases): self
    {
        $self = clone $this;
        $self['useCases'] = $useCases;

        return $self;
    }
}
