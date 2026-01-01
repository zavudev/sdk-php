<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts\Contacts;

use Zavudev\Broadcasts\BroadcastContactStatus;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * List contacts in a broadcast with optional status filter.
 *
 * @see Zavudev\Services\Broadcasts\ContactsService::list()
 *
 * @phpstan-type ContactListParamsShape = array{
 *   cursor?: string|null,
 *   limit?: int|null,
 *   status?: null|BroadcastContactStatus|value-of<BroadcastContactStatus>,
 * }
 */
final class ContactListParams implements BaseModel
{
    /** @use SdkModel<ContactListParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?string $cursor;

    #[Optional]
    public ?int $limit;

    /**
     * Status of a contact within a broadcast.
     *
     * @var value-of<BroadcastContactStatus>|null $status
     */
    #[Optional(enum: BroadcastContactStatus::class)]
    public ?string $status;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BroadcastContactStatus|value-of<BroadcastContactStatus>|null $status
     */
    public static function with(
        ?string $cursor = null,
        ?int $limit = null,
        BroadcastContactStatus|string|null $status = null,
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $limit && $self['limit'] = $limit;
        null !== $status && $self['status'] = $status;

        return $self;
    }

    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

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
}
