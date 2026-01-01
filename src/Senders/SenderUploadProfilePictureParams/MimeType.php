<?php

declare(strict_types=1);

namespace Zavudev\Senders\SenderUploadProfilePictureParams;

/**
 * MIME type of the image.
 */
enum MimeType: string
{
    case IMAGE_JPEG = 'image/jpeg';

    case IMAGE_PNG = 'image/png';
}
