<?php

declare(strict_types=1);

namespace Zavudev\Senders;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\Sender\Whatsapp;

/**
 * @phpstan-import-type SenderWebhookShape from \Zavudev\Senders\SenderWebhook
 * @phpstan-import-type WhatsappShape from \Zavudev\Senders\Sender\Whatsapp
 *
 * @phpstan-type SenderShape = array{
 *   id: string,
 *   name: string,
 *   phoneNumber: string,
 *   createdAt?: \DateTimeInterface|null,
 *   emailReceivingEnabled?: bool|null,
 *   isDefault?: bool|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   webhook?: null|SenderWebhook|SenderWebhookShape,
 *   whatsapp?: null|Whatsapp|WhatsappShape,
 * }
 */
final class Sender implements BaseModel
{
    /** @use SdkModel<SenderShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $name;

    /**
     * Phone number in E.164 format.
     */
    #[Required]
    public string $phoneNumber;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * Whether inbound email receiving is enabled for this sender.
     */
    #[Optional]
    public ?bool $emailReceivingEnabled;

    /**
     * Whether this sender is the project's default.
     */
    #[Optional]
    public ?bool $isDefault;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * Webhook configuration for the sender.
     */
    #[Optional]
    public ?SenderWebhook $webhook;

    /**
     * WhatsApp Business Account information. Only present if a WABA is connected.
     */
    #[Optional]
    public ?Whatsapp $whatsapp;

    /**
     * `new Sender()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Sender::with(id: ..., name: ..., phoneNumber: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Sender)->withID(...)->withName(...)->withPhoneNumber(...)
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
     * @param SenderWebhook|SenderWebhookShape|null $webhook
     * @param Whatsapp|WhatsappShape|null $whatsapp
     */
    public static function with(
        string $id,
        string $name,
        string $phoneNumber,
        ?\DateTimeInterface $createdAt = null,
        ?bool $emailReceivingEnabled = null,
        ?bool $isDefault = null,
        ?\DateTimeInterface $updatedAt = null,
        SenderWebhook|array|null $webhook = null,
        Whatsapp|array|null $whatsapp = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['name'] = $name;
        $self['phoneNumber'] = $phoneNumber;

        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $emailReceivingEnabled && $self['emailReceivingEnabled'] = $emailReceivingEnabled;
        null !== $isDefault && $self['isDefault'] = $isDefault;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $webhook && $self['webhook'] = $webhook;
        null !== $whatsapp && $self['whatsapp'] = $whatsapp;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Phone number in E.164 format.
     */
    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Whether inbound email receiving is enabled for this sender.
     */
    public function withEmailReceivingEnabled(bool $emailReceivingEnabled): self
    {
        $self = clone $this;
        $self['emailReceivingEnabled'] = $emailReceivingEnabled;

        return $self;
    }

    /**
     * Whether this sender is the project's default.
     */
    public function withIsDefault(bool $isDefault): self
    {
        $self = clone $this;
        $self['isDefault'] = $isDefault;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Webhook configuration for the sender.
     *
     * @param SenderWebhook|SenderWebhookShape $webhook
     */
    public function withWebhook(SenderWebhook|array $webhook): self
    {
        $self = clone $this;
        $self['webhook'] = $webhook;

        return $self;
    }

    /**
     * WhatsApp Business Account information. Only present if a WABA is connected.
     *
     * @param Whatsapp|WhatsappShape $whatsapp
     */
    public function withWhatsapp(Whatsapp|array $whatsapp): self
    {
        $self = clone $this;
        $self['whatsapp'] = $whatsapp;

        return $self;
    }
}
