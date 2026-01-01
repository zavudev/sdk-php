<?php

declare(strict_types=1);

namespace Zavudev\Senders;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type WhatsappBusinessProfileShape from \Zavudev\Senders\WhatsappBusinessProfile
 *
 * @phpstan-type WhatsappBusinessProfileResponseShape = array{
 *   profile: WhatsappBusinessProfile|WhatsappBusinessProfileShape
 * }
 */
final class WhatsappBusinessProfileResponse implements BaseModel
{
    /** @use SdkModel<WhatsappBusinessProfileResponseShape> */
    use SdkModel;

    /**
     * WhatsApp Business profile information.
     */
    #[Required]
    public WhatsappBusinessProfile $profile;

    /**
     * `new WhatsappBusinessProfileResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WhatsappBusinessProfileResponse::with(profile: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WhatsappBusinessProfileResponse)->withProfile(...)
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
     * @param WhatsappBusinessProfile|WhatsappBusinessProfileShape $profile
     */
    public static function with(WhatsappBusinessProfile|array $profile): self
    {
        $self = new self;

        $self['profile'] = $profile;

        return $self;
    }

    /**
     * WhatsApp Business profile information.
     *
     * @param WhatsappBusinessProfile|WhatsappBusinessProfileShape $profile
     */
    public function withProfile(WhatsappBusinessProfile|array $profile): self
    {
        $self = clone $this;
        $self['profile'] = $profile;

        return $self;
    }
}
