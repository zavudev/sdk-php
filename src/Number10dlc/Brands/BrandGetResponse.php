<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Brands;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type TenDlcBrandShape from \Zavudev\Number10dlc\Brands\TenDlcBrand
 *
 * @phpstan-type BrandGetResponseShape = array{brand: TenDlcBrand|TenDlcBrandShape}
 */
final class BrandGetResponse implements BaseModel
{
    /** @use SdkModel<BrandGetResponseShape> */
    use SdkModel;

    #[Required]
    public TenDlcBrand $brand;

    /**
     * `new BrandGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrandGetResponse::with(brand: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrandGetResponse)->withBrand(...)
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
