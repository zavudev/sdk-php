<?php

declare(strict_types=1);

namespace Zavudev\RegulatoryDocuments;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type RegulatoryDocumentUploadURLResponseShape = array{
 *   uploadURL: string
 * }
 */
final class RegulatoryDocumentUploadURLResponse implements BaseModel
{
    /** @use SdkModel<RegulatoryDocumentUploadURLResponseShape> */
    use SdkModel;

    /**
     * Pre-signed URL for uploading the file.
     */
    #[Required('uploadUrl')]
    public string $uploadURL;

    /**
     * `new RegulatoryDocumentUploadURLResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RegulatoryDocumentUploadURLResponse::with(uploadURL: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RegulatoryDocumentUploadURLResponse)->withUploadURL(...)
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
     */
    public static function with(string $uploadURL): self
    {
        $self = new self;

        $self['uploadURL'] = $uploadURL;

        return $self;
    }

    /**
     * Pre-signed URL for uploading the file.
     */
    public function withUploadURL(string $uploadURL): self
    {
        $self = clone $this;
        $self['uploadURL'] = $uploadURL;

        return $self;
    }
}
