<?php

declare(strict_types=1);

namespace Zavudev\Templates\Template;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * WhatsApp-specific template information.
 *
 * @phpstan-type WhatsappShape = array{
 *   namespace?: string|null, status?: string|null, templateName?: string|null
 * }
 */
final class Whatsapp implements BaseModel
{
    /** @use SdkModel<WhatsappShape> */
    use SdkModel;

    /**
     * WhatsApp Business Account namespace.
     */
    #[Optional]
    public ?string $namespace;

    /**
     * WhatsApp approval status.
     */
    #[Optional]
    public ?string $status;

    /**
     * WhatsApp template name.
     */
    #[Optional]
    public ?string $templateName;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?string $namespace = null,
        ?string $status = null,
        ?string $templateName = null
    ): self {
        $self = new self;

        null !== $namespace && $self['namespace'] = $namespace;
        null !== $status && $self['status'] = $status;
        null !== $templateName && $self['templateName'] = $templateName;

        return $self;
    }

    /**
     * WhatsApp Business Account namespace.
     */
    public function withNamespace(string $namespace): self
    {
        $self = clone $this;
        $self['namespace'] = $namespace;

        return $self;
    }

    /**
     * WhatsApp approval status.
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * WhatsApp template name.
     */
    public function withTemplateName(string $templateName): self
    {
        $self = clone $this;
        $self['templateName'] = $templateName;

        return $self;
    }
}
