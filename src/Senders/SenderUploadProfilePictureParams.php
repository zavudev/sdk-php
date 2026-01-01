<?php

declare(strict_types=1);

namespace Zavudev\Senders;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\SenderUploadProfilePictureParams\MimeType;

/**
 * Upload a new profile picture for the WhatsApp Business profile. The image will be uploaded to Meta and set as the profile picture.
 *
 * @see Zavudev\Services\SendersService::uploadProfilePicture()
 *
 * @phpstan-type SenderUploadProfilePictureParamsShape = array{
 *   imageURL: string, mimeType: MimeType|value-of<MimeType>
 * }
 */
final class SenderUploadProfilePictureParams implements BaseModel
{
    /** @use SdkModel<SenderUploadProfilePictureParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * URL of the image to upload.
     */
    #[Required('imageUrl')]
    public string $imageURL;

    /**
     * MIME type of the image.
     *
     * @var value-of<MimeType> $mimeType
     */
    #[Required(enum: MimeType::class)]
    public string $mimeType;

    /**
     * `new SenderUploadProfilePictureParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SenderUploadProfilePictureParams::with(imageURL: ..., mimeType: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SenderUploadProfilePictureParams)->withImageURL(...)->withMimeType(...)
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
     * @param MimeType|value-of<MimeType> $mimeType
     */
    public static function with(
        string $imageURL,
        MimeType|string $mimeType
    ): self {
        $self = new self;

        $self['imageURL'] = $imageURL;
        $self['mimeType'] = $mimeType;

        return $self;
    }

    /**
     * URL of the image to upload.
     */
    public function withImageURL(string $imageURL): self
    {
        $self = clone $this;
        $self['imageURL'] = $imageURL;

        return $self;
    }

    /**
     * MIME type of the image.
     *
     * @param MimeType|value-of<MimeType> $mimeType
     */
    public function withMimeType(MimeType|string $mimeType): self
    {
        $self = clone $this;
        $self['mimeType'] = $mimeType;

        return $self;
    }
}
