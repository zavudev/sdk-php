<?php

declare(strict_types=1);

namespace Zavudev\AgentTemplates\AgentTemplateGetResponse;

use Zavudev\AgentTemplates\AgentTemplateGetResponse\Template\Category;
use Zavudev\AgentTemplates\AgentTemplateGetResponse\Template\File;
use Zavudev\AgentTemplates\AgentTemplateGetResponse\Template\RequiredSecret;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * A fully rendered factory agent: the function files to scaffold plus the secrets it needs. Returned by GET /v1/agent-templates/{templateId} and consumed by `npx zavudev agents pull`.
 *
 * @phpstan-import-type FileShape from \Zavudev\AgentTemplates\AgentTemplateGetResponse\Template\File
 * @phpstan-import-type RequiredSecretShape from \Zavudev\AgentTemplates\AgentTemplateGetResponse\Template\RequiredSecret
 *
 * @phpstan-type TemplateShape = array{
 *   id: string,
 *   category: Category|value-of<Category>,
 *   defaultSlug: string,
 *   dependencies: array<string,string>,
 *   files: list<File|FileShape>,
 *   name: string,
 *   requiredSecrets: list<RequiredSecret|RequiredSecretShape>,
 *   summary: string,
 *   voice: bool,
 * }
 */
final class Template implements BaseModel
{
    /** @use SdkModel<TemplateShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /** @var value-of<Category> $category */
    #[Required(enum: Category::class)]
    public string $category;

    #[Required]
    public string $defaultSlug;

    /**
     * npm dependencies for the scaffolded function.
     *
     * @var array<string,string> $dependencies
     */
    #[Required(map: 'string')]
    public array $dependencies;

    /** @var list<File> $files */
    #[Required(list: File::class)]
    public array $files;

    #[Required]
    public string $name;

    /** @var list<RequiredSecret> $requiredSecrets */
    #[Required(list: RequiredSecret::class)]
    public array $requiredSecrets;

    #[Required]
    public string $summary;

    #[Required]
    public bool $voice;

    /**
     * `new Template()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Template::with(
     *   id: ...,
     *   category: ...,
     *   defaultSlug: ...,
     *   dependencies: ...,
     *   files: ...,
     *   name: ...,
     *   requiredSecrets: ...,
     *   summary: ...,
     *   voice: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Template)
     *   ->withID(...)
     *   ->withCategory(...)
     *   ->withDefaultSlug(...)
     *   ->withDependencies(...)
     *   ->withFiles(...)
     *   ->withName(...)
     *   ->withRequiredSecrets(...)
     *   ->withSummary(...)
     *   ->withVoice(...)
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
     * @param Category|value-of<Category> $category
     * @param array<string,string> $dependencies
     * @param list<File|FileShape> $files
     * @param list<RequiredSecret|RequiredSecretShape> $requiredSecrets
     */
    public static function with(
        string $id,
        Category|string $category,
        string $defaultSlug,
        array $dependencies,
        array $files,
        string $name,
        array $requiredSecrets,
        string $summary,
        bool $voice,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['category'] = $category;
        $self['defaultSlug'] = $defaultSlug;
        $self['dependencies'] = $dependencies;
        $self['files'] = $files;
        $self['name'] = $name;
        $self['requiredSecrets'] = $requiredSecrets;
        $self['summary'] = $summary;
        $self['voice'] = $voice;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param Category|value-of<Category> $category
     */
    public function withCategory(Category|string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    public function withDefaultSlug(string $defaultSlug): self
    {
        $self = clone $this;
        $self['defaultSlug'] = $defaultSlug;

        return $self;
    }

    /**
     * npm dependencies for the scaffolded function.
     *
     * @param array<string,string> $dependencies
     */
    public function withDependencies(array $dependencies): self
    {
        $self = clone $this;
        $self['dependencies'] = $dependencies;

        return $self;
    }

    /**
     * @param list<File|FileShape> $files
     */
    public function withFiles(array $files): self
    {
        $self = clone $this;
        $self['files'] = $files;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param list<RequiredSecret|RequiredSecretShape> $requiredSecrets
     */
    public function withRequiredSecrets(array $requiredSecrets): self
    {
        $self = clone $this;
        $self['requiredSecrets'] = $requiredSecrets;

        return $self;
    }

    public function withSummary(string $summary): self
    {
        $self = clone $this;
        $self['summary'] = $summary;

        return $self;
    }

    public function withVoice(bool $voice): self
    {
        $self = clone $this;
        $self['voice'] = $voice;

        return $self;
    }
}
