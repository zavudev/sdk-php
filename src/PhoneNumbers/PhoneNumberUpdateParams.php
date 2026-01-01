<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Update a phone number's name or sender assignment.
 *
 * @see Zavudev\Services\PhoneNumbersService::update()
 *
 * @phpstan-type PhoneNumberUpdateParamsShape = array{
 *   name?: string|null, senderID?: string|null
 * }
 */
final class PhoneNumberUpdateParams implements BaseModel
{
    /** @use SdkModel<PhoneNumberUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Custom name for the phone number. Set to null to clear.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * Sender ID to assign the phone number to. Set to null to unassign.
     */
    #[Optional('senderId', nullable: true)]
    public ?string $senderID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?string $name = null,
        ?string $senderID = null
    ): self {
        $self = new self;

        null !== $name && $self['name'] = $name;
        null !== $senderID && $self['senderID'] = $senderID;

        return $self;
    }

    /**
     * Custom name for the phone number. Set to null to clear.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Sender ID to assign the phone number to. Set to null to unassign.
     */
    public function withSenderID(?string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }
}
