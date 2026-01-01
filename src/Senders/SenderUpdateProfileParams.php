<?php

declare(strict_types=1);

namespace Zavudev\Senders;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Update the WhatsApp Business profile for a sender. The sender must have a WhatsApp Business Account connected.
 *
 * @see Zavudev\Services\SendersService::updateProfile()
 *
 * @phpstan-type SenderUpdateProfileParamsShape = array{
 *   about?: string|null,
 *   address?: string|null,
 *   description?: string|null,
 *   email?: string|null,
 *   vertical?: null|WhatsappBusinessProfileVertical|value-of<WhatsappBusinessProfileVertical>,
 *   websites?: list<string>|null,
 * }
 */
final class SenderUpdateProfileParams implements BaseModel
{
    /** @use SdkModel<SenderUpdateProfileParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Short description of the business (max 139 characters).
     */
    #[Optional]
    public ?string $about;

    /**
     * Physical address of the business (max 256 characters).
     */
    #[Optional]
    public ?string $address;

    /**
     * Extended description of the business (max 512 characters).
     */
    #[Optional]
    public ?string $description;

    /**
     * Business email address.
     */
    #[Optional]
    public ?string $email;

    /**
     * Business category for WhatsApp Business profile.
     *
     * @var value-of<WhatsappBusinessProfileVertical>|null $vertical
     */
    #[Optional(enum: WhatsappBusinessProfileVertical::class)]
    public ?string $vertical;

    /**
     * Business website URLs (maximum 2).
     *
     * @var list<string>|null $websites
     */
    #[Optional(list: 'string')]
    public ?array $websites;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param WhatsappBusinessProfileVertical|value-of<WhatsappBusinessProfileVertical>|null $vertical
     * @param list<string>|null $websites
     */
    public static function with(
        ?string $about = null,
        ?string $address = null,
        ?string $description = null,
        ?string $email = null,
        WhatsappBusinessProfileVertical|string|null $vertical = null,
        ?array $websites = null,
    ): self {
        $self = new self;

        null !== $about && $self['about'] = $about;
        null !== $address && $self['address'] = $address;
        null !== $description && $self['description'] = $description;
        null !== $email && $self['email'] = $email;
        null !== $vertical && $self['vertical'] = $vertical;
        null !== $websites && $self['websites'] = $websites;

        return $self;
    }

    /**
     * Short description of the business (max 139 characters).
     */
    public function withAbout(string $about): self
    {
        $self = clone $this;
        $self['about'] = $about;

        return $self;
    }

    /**
     * Physical address of the business (max 256 characters).
     */
    public function withAddress(string $address): self
    {
        $self = clone $this;
        $self['address'] = $address;

        return $self;
    }

    /**
     * Extended description of the business (max 512 characters).
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Business email address.
     */
    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * Business category for WhatsApp Business profile.
     *
     * @param WhatsappBusinessProfileVertical|value-of<WhatsappBusinessProfileVertical> $vertical
     */
    public function withVertical(
        WhatsappBusinessProfileVertical|string $vertical
    ): self {
        $self = clone $this;
        $self['vertical'] = $vertical;

        return $self;
    }

    /**
     * Business website URLs (maximum 2).
     *
     * @param list<string> $websites
     */
    public function withWebsites(array $websites): self
    {
        $self = clone $this;
        $self['websites'] = $websites;

        return $self;
    }
}
