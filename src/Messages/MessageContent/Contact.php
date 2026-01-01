<?php

declare(strict_types=1);

namespace Zavudev\Messages\MessageContent;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type ContactShape = array{
 *   name?: string|null, phones?: list<string>|null
 * }
 */
final class Contact implements BaseModel
{
    /** @use SdkModel<ContactShape> */
    use SdkModel;

    #[Optional]
    public ?string $name;

    /** @var list<string>|null $phones */
    #[Optional(list: 'string')]
    public ?array $phones;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $phones
     */
    public static function with(?string $name = null, ?array $phones = null): self
    {
        $self = new self;

        null !== $name && $self['name'] = $name;
        null !== $phones && $self['phones'] = $phones;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param list<string> $phones
     */
    public function withPhones(array $phones): self
    {
        $self = clone $this;
        $self['phones'] = $phones;

        return $self;
    }
}
