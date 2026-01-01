<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * List all phone numbers owned by this project.
 *
 * @see Zavudev\Services\PhoneNumbersService::list()
 *
 * @phpstan-type PhoneNumberListParamsShape = array{
 *   cursor?: string|null,
 *   limit?: int|null,
 *   status?: null|PhoneNumberStatus|value-of<PhoneNumberStatus>,
 * }
 */
final class PhoneNumberListParams implements BaseModel
{
    /** @use SdkModel<PhoneNumberListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor.
     */
    #[Optional]
    public ?string $cursor;

    #[Optional]
    public ?int $limit;

    /**
     * Filter by phone number status.
     *
     * @var value-of<PhoneNumberStatus>|null $status
     */
    #[Optional(enum: PhoneNumberStatus::class)]
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
     * @param PhoneNumberStatus|value-of<PhoneNumberStatus>|null $status
     */
    public static function with(
        ?string $cursor = null,
        ?int $limit = null,
        PhoneNumberStatus|string|null $status = null,
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $limit && $self['limit'] = $limit;
        null !== $status && $self['status'] = $status;

        return $self;
    }

    /**
     * Pagination cursor.
     */
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
     * Filter by phone number status.
     *
     * @param PhoneNumberStatus|value-of<PhoneNumberStatus> $status
     */
    public function withStatus(PhoneNumberStatus|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
