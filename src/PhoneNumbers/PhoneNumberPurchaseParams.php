<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\PhoneNumbers\PhoneNumberPurchaseParams\RegulatoryRequirement;

/**
 * Purchase an available phone number. Requires a paid plan: the Free plan cannot purchase phone numbers and receives `402` with code `paid_plan_required`.
 *
 * **The included number.** A paid plan includes one number at no charge, once per account: it must be a US or Canadian number (a +1 number) costing $20 a month or less. `isFreeEligible` in `GET /v1/phone-numbers/available` marks the numbers that qualify. Claiming it spends the benefit for good, across every team the account owner owns, so releasing that number does not make another one free.
 *
 * **Numbers with regulatory requirements.** Which numbers need regulatory information is decided per number, not by a fixed country list. The purchase looks the requirements up for the exact number before charging anything:
 *
 * 1. `GET /v1/phone-numbers/requirements?phoneNumber=...`. If `items` is empty, buy normally.
 * 2. Create what it asks for: addresses with `POST /v1/addresses`, documents with `POST /v1/documents`.
 * 3. Purchase with `type` and `regulatoryRequirements`. The number is bought and billed at once with `regulatoryStatus: pending_review`.
 * 4. Poll `GET /v1/phone-numbers/{phoneNumberId}` until `regulatoryStatus` is `approved`. Assign it to a sender before or after approval; it starts carrying messages once approved.
 *
 * **Reuse.** Information you submitted is kept for your project, per country and `type`, and a later purchase there may omit `regulatoryRequirements`. Reuse only happens when what is kept still covers every requirement of the new number and every address and document in it belongs to the project. Otherwise, or when nothing is kept, the purchase returns `400 regulatory_compliance_required` with the missing requirements in `details`.
 *
 * Invalid values (a missing, unknown or repeated requirement id, an address or document from another project, or one rejected in review) return `400 invalid_request`. If an address or document cannot be registered for review, the purchase returns `400 invalid_request` naming the requirement. If the requirements cannot be looked up, the purchase returns `502 requirements_unavailable`, except for US and Canadian numbers, which are sold as numbers without requirements. None of these errors charge anything.
 *
 * @see Zavudev\Services\PhoneNumbersService::purchase()
 *
 * @phpstan-import-type RegulatoryRequirementShape from \Zavudev\PhoneNumbers\PhoneNumberPurchaseParams\RegulatoryRequirement
 *
 * @phpstan-type PhoneNumberPurchaseParamsShape = array{
 *   phoneNumber: string,
 *   name?: string|null,
 *   regulatoryRequirements?: list<RegulatoryRequirement|RegulatoryRequirementShape>|null,
 *   type?: null|PhoneNumberType|value-of<PhoneNumberType>,
 * }
 */
final class PhoneNumberPurchaseParams implements BaseModel
{
    /** @use SdkModel<PhoneNumberPurchaseParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Phone number in E.164 format.
     */
    #[Required]
    public string $phoneNumber;

    /**
     * Optional custom name for the phone number.
     */
    #[Optional]
    public ?string $name;

    /**
     * Regulatory information, for numbers whose requirements list is not empty. Get the list with `GET /v1/phone-numbers/requirements?phoneNumber=...` and send one entry per requirement id, except `action` requirements, which take no value. Every required id must be present, once, and no unknown id may be sent; otherwise the purchase is refused with `400 invalid_request` before anything is charged.
     *
     * The information is kept for your project under the number's country and `type`. A later purchase there may omit this field if what is kept still covers that number's requirements. Omit it for numbers without requirements.
     *
     * @var list<RegulatoryRequirement>|null $regulatoryRequirements
     */
    #[Optional(list: RegulatoryRequirement::class)]
    public ?array $regulatoryRequirements;

    /**
     * Type of phone number. `mobile` is stocked in countries where no geographic (`local`) or non-geographic (`national`) inventory exists, and in several markets it is the only type that can receive SMS.
     *
     * @var value-of<PhoneNumberType>|null $type
     */
    #[Optional(enum: PhoneNumberType::class)]
    public ?string $type;

    /**
     * `new PhoneNumberPurchaseParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PhoneNumberPurchaseParams::with(phoneNumber: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PhoneNumberPurchaseParams)->withPhoneNumber(...)
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
     * @param list<RegulatoryRequirement|RegulatoryRequirementShape>|null $regulatoryRequirements
     * @param PhoneNumberType|value-of<PhoneNumberType>|null $type
     */
    public static function with(
        string $phoneNumber,
        ?string $name = null,
        ?array $regulatoryRequirements = null,
        PhoneNumberType|string|null $type = null,
    ): self {
        $self = new self;

        $self['phoneNumber'] = $phoneNumber;

        null !== $name && $self['name'] = $name;
        null !== $regulatoryRequirements && $self['regulatoryRequirements'] = $regulatoryRequirements;
        null !== $type && $self['type'] = $type;

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

    /**
     * Optional custom name for the phone number.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Regulatory information, for numbers whose requirements list is not empty. Get the list with `GET /v1/phone-numbers/requirements?phoneNumber=...` and send one entry per requirement id, except `action` requirements, which take no value. Every required id must be present, once, and no unknown id may be sent; otherwise the purchase is refused with `400 invalid_request` before anything is charged.
     *
     * The information is kept for your project under the number's country and `type`. A later purchase there may omit this field if what is kept still covers that number's requirements. Omit it for numbers without requirements.
     *
     * @param list<RegulatoryRequirement|RegulatoryRequirementShape> $regulatoryRequirements
     */
    public function withRegulatoryRequirements(
        array $regulatoryRequirements
    ): self {
        $self = clone $this;
        $self['regulatoryRequirements'] = $regulatoryRequirements;

        return $self;
    }

    /**
     * Type of phone number. `mobile` is stocked in countries where no geographic (`local`) or non-geographic (`national`) inventory exists, and in several markets it is the only type that can receive SMS.
     *
     * @param PhoneNumberType|value-of<PhoneNumberType> $type
     */
    public function withType(PhoneNumberType|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
