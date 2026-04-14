<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Campaigns\PhoneNumbers;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type TenDlcPhoneNumberAssignmentShape from \Zavudev\Number10dlc\Campaigns\PhoneNumbers\TenDlcPhoneNumberAssignment
 *
 * @phpstan-type PhoneNumberListResponseShape = array{
 *   items: list<TenDlcPhoneNumberAssignment|TenDlcPhoneNumberAssignmentShape>,
 *   nextCursor?: string|null,
 * }
 */
final class PhoneNumberListResponse implements BaseModel
{
    /** @use SdkModel<PhoneNumberListResponseShape> */
    use SdkModel;

    /** @var list<TenDlcPhoneNumberAssignment> $items */
    #[Required(list: TenDlcPhoneNumberAssignment::class)]
    public array $items;

    #[Optional(nullable: true)]
    public ?string $nextCursor;

    /**
     * `new PhoneNumberListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PhoneNumberListResponse::with(items: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PhoneNumberListResponse)->withItems(...)
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
     * @param list<TenDlcPhoneNumberAssignment|TenDlcPhoneNumberAssignmentShape> $items
     */
    public static function with(array $items, ?string $nextCursor = null): self
    {
        $self = new self;

        $self['items'] = $items;

        null !== $nextCursor && $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * @param list<TenDlcPhoneNumberAssignment|TenDlcPhoneNumberAssignmentShape> $items
     */
    public function withItems(array $items): self
    {
        $self = clone $this;
        $self['items'] = $items;

        return $self;
    }

    public function withNextCursor(?string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }
}
