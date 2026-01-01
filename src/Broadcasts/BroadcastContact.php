<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts;

use Zavudev\Broadcasts\BroadcastContact\RecipientType;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type BroadcastContactShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   recipient: string,
 *   recipientType: RecipientType|value-of<RecipientType>,
 *   status: BroadcastContactStatus|value-of<BroadcastContactStatus>,
 *   cost?: float|null,
 *   errorCode?: string|null,
 *   errorMessage?: string|null,
 *   messageID?: string|null,
 *   processedAt?: \DateTimeInterface|null,
 *   templateVariables?: array<string,string>|null,
 * }
 */
final class BroadcastContact implements BaseModel
{
    /** @use SdkModel<BroadcastContactShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public string $recipient;

    /** @var value-of<RecipientType> $recipientType */
    #[Required(enum: RecipientType::class)]
    public string $recipientType;

    /**
     * Status of a contact within a broadcast.
     *
     * @var value-of<BroadcastContactStatus> $status
     */
    #[Required(enum: BroadcastContactStatus::class)]
    public string $status;

    #[Optional(nullable: true)]
    public ?float $cost;

    #[Optional]
    public ?string $errorCode;

    #[Optional]
    public ?string $errorMessage;

    /**
     * Associated message ID after processing.
     */
    #[Optional('messageId')]
    public ?string $messageID;

    #[Optional]
    public ?\DateTimeInterface $processedAt;

    /** @var array<string,string>|null $templateVariables */
    #[Optional(map: 'string')]
    public ?array $templateVariables;

    /**
     * `new BroadcastContact()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BroadcastContact::with(
     *   id: ..., createdAt: ..., recipient: ..., recipientType: ..., status: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BroadcastContact)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withRecipient(...)
     *   ->withRecipientType(...)
     *   ->withStatus(...)
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
     * @param RecipientType|value-of<RecipientType> $recipientType
     * @param BroadcastContactStatus|value-of<BroadcastContactStatus> $status
     * @param array<string,string>|null $templateVariables
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        string $recipient,
        RecipientType|string $recipientType,
        BroadcastContactStatus|string $status,
        ?float $cost = null,
        ?string $errorCode = null,
        ?string $errorMessage = null,
        ?string $messageID = null,
        ?\DateTimeInterface $processedAt = null,
        ?array $templateVariables = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['recipient'] = $recipient;
        $self['recipientType'] = $recipientType;
        $self['status'] = $status;

        null !== $cost && $self['cost'] = $cost;
        null !== $errorCode && $self['errorCode'] = $errorCode;
        null !== $errorMessage && $self['errorMessage'] = $errorMessage;
        null !== $messageID && $self['messageID'] = $messageID;
        null !== $processedAt && $self['processedAt'] = $processedAt;
        null !== $templateVariables && $self['templateVariables'] = $templateVariables;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withRecipient(string $recipient): self
    {
        $self = clone $this;
        $self['recipient'] = $recipient;

        return $self;
    }

    /**
     * @param RecipientType|value-of<RecipientType> $recipientType
     */
    public function withRecipientType(RecipientType|string $recipientType): self
    {
        $self = clone $this;
        $self['recipientType'] = $recipientType;

        return $self;
    }

    /**
     * Status of a contact within a broadcast.
     *
     * @param BroadcastContactStatus|value-of<BroadcastContactStatus> $status
     */
    public function withStatus(BroadcastContactStatus|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withCost(?float $cost): self
    {
        $self = clone $this;
        $self['cost'] = $cost;

        return $self;
    }

    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    public function withErrorMessage(string $errorMessage): self
    {
        $self = clone $this;
        $self['errorMessage'] = $errorMessage;

        return $self;
    }

    /**
     * Associated message ID after processing.
     */
    public function withMessageID(string $messageID): self
    {
        $self = clone $this;
        $self['messageID'] = $messageID;

        return $self;
    }

    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * @param array<string,string> $templateVariables
     */
    public function withTemplateVariables(array $templateVariables): self
    {
        $self = clone $this;
        $self['templateVariables'] = $templateVariables;

        return $self;
    }
}
