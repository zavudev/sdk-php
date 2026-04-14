<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Campaigns\PhoneNumbers;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type TenDlcPhoneNumberAssignmentShape from \Zavudev\Number10dlc\Campaigns\PhoneNumbers\TenDlcPhoneNumberAssignment
 *
 * @phpstan-type PhoneNumberAssignResponseShape = array{
 *   assignment: TenDlcPhoneNumberAssignment|TenDlcPhoneNumberAssignmentShape
 * }
 */
final class PhoneNumberAssignResponse implements BaseModel
{
    /** @use SdkModel<PhoneNumberAssignResponseShape> */
    use SdkModel;

    #[Required]
    public TenDlcPhoneNumberAssignment $assignment;

    /**
     * `new PhoneNumberAssignResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PhoneNumberAssignResponse::with(assignment: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PhoneNumberAssignResponse)->withAssignment(...)
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
     * @param TenDlcPhoneNumberAssignment|TenDlcPhoneNumberAssignmentShape $assignment
     */
    public static function with(
        TenDlcPhoneNumberAssignment|array $assignment
    ): self {
        $self = new self;

        $self['assignment'] = $assignment;

        return $self;
    }

    /**
     * @param TenDlcPhoneNumberAssignment|TenDlcPhoneNumberAssignmentShape $assignment
     */
    public function withAssignment(
        TenDlcPhoneNumberAssignment|array $assignment
    ): self {
        $self = clone $this;
        $self['assignment'] = $assignment;

        return $self;
    }
}
