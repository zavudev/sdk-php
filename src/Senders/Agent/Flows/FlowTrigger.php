<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Flows;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\Agent\Flows\FlowTrigger\Type;

/**
 * @phpstan-type FlowTriggerShape = array{
 *   type: Type|value-of<Type>, intent?: string|null, keywords?: list<string>|null
 * }
 */
final class FlowTrigger implements BaseModel
{
    /** @use SdkModel<FlowTriggerShape> */
    use SdkModel;

    /**
     * What starts a flow.
     *
     * - `keyword`: the message contains one of the words listed in `keywords`. Plain substring matching, so a word inside another word still counts.
     * - `intent`: the message MEANS what `intent` describes, whatever words it uses.
     * - `always`: any message starts it.
     * - `manual`: reserved. Nothing starts a `manual` flow today — it is accepted and stored, and no message or endpoint runs it.
     *
     * @var value-of<Type> $type
     */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * One plain sentence describing what the contact wants, for `intent` triggers. Any language.
     *
     * The message is judged for meaning, not for words, so "kiero saber el presio" starts a flow whose intent is "quiere saber precios o cotizar", and "no quiero info de precios" starts nothing.
     *
     * A `keyword` or `always` flow with a higher `priority` is matched first and wins. At most 12 intent flows are considered per message, highest priority first. When the classification is unavailable or uncertain, the message is handled as if no intent matched, so a flow never starts on a guess.
     */
    #[Optional]
    public ?string $intent;

    /**
     * Words that start the flow, for `keyword` triggers. Matched as substrings, case-insensitively, against the whole message: a flow on `info` also starts on "no quiero info". Use `intent` when that matters.
     *
     * @var list<string>|null $keywords
     */
    #[Optional(list: 'string')]
    public ?array $keywords;

    /**
     * `new FlowTrigger()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FlowTrigger::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FlowTrigger)->withType(...)
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
     * @param Type|value-of<Type> $type
     * @param list<string>|null $keywords
     */
    public static function with(
        Type|string $type,
        ?string $intent = null,
        ?array $keywords = null
    ): self {
        $self = new self;

        $self['type'] = $type;

        null !== $intent && $self['intent'] = $intent;
        null !== $keywords && $self['keywords'] = $keywords;

        return $self;
    }

    /**
     * What starts a flow.
     *
     * - `keyword`: the message contains one of the words listed in `keywords`. Plain substring matching, so a word inside another word still counts.
     * - `intent`: the message MEANS what `intent` describes, whatever words it uses.
     * - `always`: any message starts it.
     * - `manual`: reserved. Nothing starts a `manual` flow today — it is accepted and stored, and no message or endpoint runs it.
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * One plain sentence describing what the contact wants, for `intent` triggers. Any language.
     *
     * The message is judged for meaning, not for words, so "kiero saber el presio" starts a flow whose intent is "quiere saber precios o cotizar", and "no quiero info de precios" starts nothing.
     *
     * A `keyword` or `always` flow with a higher `priority` is matched first and wins. At most 12 intent flows are considered per message, highest priority first. When the classification is unavailable or uncertain, the message is handled as if no intent matched, so a flow never starts on a guess.
     */
    public function withIntent(string $intent): self
    {
        $self = clone $this;
        $self['intent'] = $intent;

        return $self;
    }

    /**
     * Words that start the flow, for `keyword` triggers. Matched as substrings, case-insensitively, against the whole message: a flow on `info` also starts on "no quiero info". Use `intent` when that matters.
     *
     * @param list<string> $keywords
     */
    public function withKeywords(array $keywords): self
    {
        $self = clone $this;
        $self['keywords'] = $keywords;

        return $self;
    }
}
