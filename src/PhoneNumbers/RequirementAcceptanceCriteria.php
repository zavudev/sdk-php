<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Acceptance criteria for a requirement.
 *
 * @phpstan-type RequirementAcceptanceCriteriaShape = array{
 *   allowedValues?: list<string>|null,
 *   maxLength?: int|null,
 *   minLength?: int|null,
 *   regexPattern?: string|null,
 * }
 */
final class RequirementAcceptanceCriteria implements BaseModel
{
    /** @use SdkModel<RequirementAcceptanceCriteriaShape> */
    use SdkModel;

    /** @var list<string>|null $allowedValues */
    #[Optional(list: 'string', nullable: true)]
    public ?array $allowedValues;

    #[Optional(nullable: true)]
    public ?int $maxLength;

    #[Optional(nullable: true)]
    public ?int $minLength;

    #[Optional(nullable: true)]
    public ?string $regexPattern;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $allowedValues
     */
    public static function with(
        ?array $allowedValues = null,
        ?int $maxLength = null,
        ?int $minLength = null,
        ?string $regexPattern = null,
    ): self {
        $self = new self;

        null !== $allowedValues && $self['allowedValues'] = $allowedValues;
        null !== $maxLength && $self['maxLength'] = $maxLength;
        null !== $minLength && $self['minLength'] = $minLength;
        null !== $regexPattern && $self['regexPattern'] = $regexPattern;

        return $self;
    }

    /**
     * @param list<string>|null $allowedValues
     */
    public function withAllowedValues(?array $allowedValues): self
    {
        $self = clone $this;
        $self['allowedValues'] = $allowedValues;

        return $self;
    }

    public function withMaxLength(?int $maxLength): self
    {
        $self = clone $this;
        $self['maxLength'] = $maxLength;

        return $self;
    }

    public function withMinLength(?int $minLength): self
    {
        $self = clone $this;
        $self['minLength'] = $minLength;

        return $self;
    }

    public function withRegexPattern(?string $regexPattern): self
    {
        $self = clone $this;
        $self['regexPattern'] = $regexPattern;

        return $self;
    }
}
