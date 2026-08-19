<?php

declare(strict_types=1);

namespace Zavudev\AgentTemplates;

use Zavudev\AgentTemplates\AgentTemplateGetResponse\Template;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type TemplateShape from \Zavudev\AgentTemplates\AgentTemplateGetResponse\Template
 *
 * @phpstan-type AgentTemplateGetResponseShape = array{
 *   template: Template|TemplateShape
 * }
 */
final class AgentTemplateGetResponse implements BaseModel
{
    /** @use SdkModel<AgentTemplateGetResponseShape> */
    use SdkModel;

    /**
     * A fully rendered factory agent: the function files to scaffold plus the secrets it needs. Returned by GET /v1/agent-templates/{templateId} and consumed by `npx zavudev agents pull`.
     */
    #[Required]
    public Template $template;

    /**
     * `new AgentTemplateGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AgentTemplateGetResponse::with(template: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AgentTemplateGetResponse)->withTemplate(...)
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
     * @param Template|TemplateShape $template
     */
    public static function with(Template|array $template): self
    {
        $self = new self;

        $self['template'] = $template;

        return $self;
    }

    /**
     * A fully rendered factory agent: the function files to scaffold plus the secrets it needs. Returned by GET /v1/agent-templates/{templateId} and consumed by `npx zavudev agents pull`.
     *
     * @param Template|TemplateShape $template
     */
    public function withTemplate(Template|array $template): self
    {
        $self = clone $this;
        $self['template'] = $template;

        return $self;
    }
}
