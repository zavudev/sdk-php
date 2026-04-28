<?php

declare(strict_types=1);

namespace Zavudev\Contacts;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Merge a source contact into this contact. All channels from the source contact will be moved to the target contact, and the source contact will be marked as merged.
 *
 * @see Zavudev\Services\ContactsService::merge()
 *
 * @phpstan-type ContactMergeParamsShape = array{sourceContactID: string}
 */
final class ContactMergeParams implements BaseModel
{
    /** @use SdkModel<ContactMergeParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the contact to merge into the target contact. The source contact will be marked as merged.
     */
    #[Required('sourceContactId')]
    public string $sourceContactID;

    /**
     * `new ContactMergeParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ContactMergeParams::with(sourceContactID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ContactMergeParams)->withSourceContactID(...)
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
    public static function with(string $sourceContactID): self
    {
        $self = new self;

        $self['sourceContactID'] = $sourceContactID;

        return $self;
    }

    /**
     * ID of the contact to merge into the target contact. The source contact will be marked as merged.
     */
    public function withSourceContactID(string $sourceContactID): self
    {
        $self = clone $this;
        $self['sourceContactID'] = $sourceContactID;

        return $self;
    }
}
