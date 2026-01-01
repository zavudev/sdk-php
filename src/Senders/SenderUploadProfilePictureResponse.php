<?php

declare(strict_types=1);

namespace Zavudev\Senders;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type WhatsappBusinessProfileShape from \Zavudev\Senders\WhatsappBusinessProfile
 *
 * @phpstan-type SenderUploadProfilePictureResponseShape = array{
 *   profile: WhatsappBusinessProfile|WhatsappBusinessProfileShape, success: bool
 * }
 */
final class SenderUploadProfilePictureResponse implements BaseModel
{
    /** @use SdkModel<SenderUploadProfilePictureResponseShape> */
    use SdkModel;

    /**
     * WhatsApp Business profile information.
     */
    #[Required]
    public WhatsappBusinessProfile $profile;

    #[Required]
    public bool $success;

    /**
     * `new SenderUploadProfilePictureResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SenderUploadProfilePictureResponse::with(profile: ..., success: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SenderUploadProfilePictureResponse)->withProfile(...)->withSuccess(...)
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
    public static function with(
        WhatsappBusinessProfile|array $profile,
        bool $success
    ): self {
        $self = new self;

        $self['profile'] = $profile;
        $self['success'] = $success;

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

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }
}
