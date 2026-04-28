<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Brands;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type TenDlcBrandShape from \Zavudev\Number10dlc\Brands\TenDlcBrand
 *
 * @phpstan-type BrandSubmitResponseShape = array{
 *   brand: TenDlcBrand|TenDlcBrandShape
 * }
 */
final class BrandSubmitResponse implements BaseModel
{
    /** @use SdkModel<BrandSubmitResponseShape> */
    use SdkModel;

    #[Required]
    public TenDlcBrand $brand;

    /**
     * `new BrandSubmitResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrandSubmitResponse::with(brand: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrandSubmitResponse)->withBrand(...)
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
     * @param TenDlcBrand|TenDlcBrandShape $brand
     */
    public static function with(TenDlcBrand|array $brand): self
    {
        $self = new self;

        $self['brand'] = $brand;

        return $self;
    }

    /**
     * @param TenDlcBrand|TenDlcBrandShape $brand
     */
    public function withBrand(TenDlcBrand|array $brand): self
    {
        $self = clone $this;
        $self['brand'] = $brand;

        return $self;
    }
}
