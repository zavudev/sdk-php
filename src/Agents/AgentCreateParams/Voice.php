<?php

declare(strict_types=1);

namespace Zavudev\Agents\AgentCreateParams;

use Zavudev\Agents\AgentCreateParams\Voice\VoicemailAction;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Voice Agent configuration on a sender's AI agent. Controls how the agent behaves on inbound and outbound phone calls through Zavu's managed voice pipeline (speech recognition, the agent's LLM, and speech synthesis, with real-time interruption handling). Requires the Voice Agents feature to be enabled for your team.
 *
 * @phpstan-type VoiceShape = array{
 *   enabled: bool,
 *   greeting?: string|null,
 *   greetings?: array<string,string>|null,
 *   interruptible?: bool|null,
 *   language?: string|null,
 *   maxCallDurationMinutes?: int|null,
 *   maxIdleSeconds?: int|null,
 *   model?: string|null,
 *   recordCalls?: bool|null,
 *   sttModel?: string|null,
 *   sttProvider?: string|null,
 *   transferPhoneNumber?: string|null,
 *   ttsProvider?: string|null,
 *   ttsVoiceID?: string|null,
 *   voicemailAction?: null|VoicemailAction|value-of<VoicemailAction>,
 *   voicemailMessage?: string|null,
 *   voiceSpeed?: float|null,
 * }
 */
final class Voice implements BaseModel
{
    /** @use SdkModel<VoiceShape> */
    use SdkModel;

    /**
     * Whether the agent handles voice calls. When false, the sender's number is not answered by the voice agent and outbound calls are rejected.
     */
    #[Required]
    public bool $enabled;

    /**
     * Opening line the agent speaks when the call connects. If omitted, the agent waits for the caller to speak first.
     */
    #[Optional]
    public ?string $greeting;

    /**
     * Greeting per language, keyed by language code. Used when the caller's language differs from the one `greeting` is written in.
     *
     * @var array<string,string>|null $greetings
     */
    #[Optional(map: 'string')]
    public ?array $greetings;

    /**
     * Whether the caller can interrupt the agent while it is speaking (barge-in). When true, the agent stops talking as soon as the caller starts.
     */
    #[Optional]
    public ?bool $interruptible;

    /**
     * BCP-47 language code used for both speech recognition and speech synthesis (e.g. `en`, `es`, `pt-BR`). Auto-detected from the recipient when omitted.
     */
    #[Optional]
    public ?string $language;

    /**
     * Hard limit on call length in minutes. The call ends automatically when reached.
     */
    #[Optional]
    public ?int $maxCallDurationMinutes;

    /**
     * How long the agent waits during silence before ending the call.
     */
    #[Optional]
    public ?int $maxIdleSeconds;

    /**
     * Model that runs the conversation, co-located in the voice network for lowest latency. Independent of the model used for text messaging. Derived from the agent's text model when omitted.
     */
    #[Optional]
    public ?string $model;

    /**
     * Whether the call audio is recorded.
     */
    #[Optional]
    public ?bool $recordCalls;

    /**
     * Speech-recognition model. Uses the default when omitted.
     */
    #[Optional]
    public ?string $sttModel;

    /**
     * Speech-recognition provider. Uses the default when omitted.
     */
    #[Optional]
    public ?string $sttProvider;

    /**
     * E.164 phone number the agent can transfer the call to. When set, the agent is given a transfer tool it can use to hand the call to a human.
     */
    #[Optional]
    public ?string $transferPhoneNumber;

    /**
     * Speech-synthesis provider. Uses the default when omitted.
     */
    #[Optional]
    public ?string $ttsProvider;

    /**
     * Identifier of the synthesized voice that speaks. Choose from the voices available in the dashboard. Uses a neutral default when omitted.
     */
    #[Optional('ttsVoiceId')]
    public ?string $ttsVoiceID;

    /**
     * What the agent does when an answering machine or voicemail is detected on an outbound call.
     *
     * @var value-of<VoicemailAction>|null $voicemailAction
     */
    #[Optional(enum: VoicemailAction::class)]
    public ?string $voicemailAction;

    /**
     * Message spoken when `voicemailAction` is `leave_message`. Falls back to `greeting` when omitted.
     */
    #[Optional]
    public ?string $voicemailMessage;

    /**
     * Speech rate. 1.0 is natural. Only honoured by voices that support rate control; ignored by the others.
     */
    #[Optional]
    public ?float $voiceSpeed;

    /**
     * `new Voice()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Voice::with(enabled: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Voice)->withEnabled(...)
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
     * @param array<string,string>|null $greetings
     * @param VoicemailAction|value-of<VoicemailAction>|null $voicemailAction
     */
    public static function with(
        bool $enabled,
        ?string $greeting = null,
        ?array $greetings = null,
        ?bool $interruptible = null,
        ?string $language = null,
        ?int $maxCallDurationMinutes = null,
        ?int $maxIdleSeconds = null,
        ?string $model = null,
        ?bool $recordCalls = null,
        ?string $sttModel = null,
        ?string $sttProvider = null,
        ?string $transferPhoneNumber = null,
        ?string $ttsProvider = null,
        ?string $ttsVoiceID = null,
        VoicemailAction|string|null $voicemailAction = null,
        ?string $voicemailMessage = null,
        ?float $voiceSpeed = null,
    ): self {
        $self = new self;

        $self['enabled'] = $enabled;

        null !== $greeting && $self['greeting'] = $greeting;
        null !== $greetings && $self['greetings'] = $greetings;
        null !== $interruptible && $self['interruptible'] = $interruptible;
        null !== $language && $self['language'] = $language;
        null !== $maxCallDurationMinutes && $self['maxCallDurationMinutes'] = $maxCallDurationMinutes;
        null !== $maxIdleSeconds && $self['maxIdleSeconds'] = $maxIdleSeconds;
        null !== $model && $self['model'] = $model;
        null !== $recordCalls && $self['recordCalls'] = $recordCalls;
        null !== $sttModel && $self['sttModel'] = $sttModel;
        null !== $sttProvider && $self['sttProvider'] = $sttProvider;
        null !== $transferPhoneNumber && $self['transferPhoneNumber'] = $transferPhoneNumber;
        null !== $ttsProvider && $self['ttsProvider'] = $ttsProvider;
        null !== $ttsVoiceID && $self['ttsVoiceID'] = $ttsVoiceID;
        null !== $voicemailAction && $self['voicemailAction'] = $voicemailAction;
        null !== $voicemailMessage && $self['voicemailMessage'] = $voicemailMessage;
        null !== $voiceSpeed && $self['voiceSpeed'] = $voiceSpeed;

        return $self;
    }

    /**
     * Whether the agent handles voice calls. When false, the sender's number is not answered by the voice agent and outbound calls are rejected.
     */
    public function withEnabled(bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * Opening line the agent speaks when the call connects. If omitted, the agent waits for the caller to speak first.
     */
    public function withGreeting(string $greeting): self
    {
        $self = clone $this;
        $self['greeting'] = $greeting;

        return $self;
    }

    /**
     * Greeting per language, keyed by language code. Used when the caller's language differs from the one `greeting` is written in.
     *
     * @param array<string,string> $greetings
     */
    public function withGreetings(array $greetings): self
    {
        $self = clone $this;
        $self['greetings'] = $greetings;

        return $self;
    }

    /**
     * Whether the caller can interrupt the agent while it is speaking (barge-in). When true, the agent stops talking as soon as the caller starts.
     */
    public function withInterruptible(bool $interruptible): self
    {
        $self = clone $this;
        $self['interruptible'] = $interruptible;

        return $self;
    }

    /**
     * BCP-47 language code used for both speech recognition and speech synthesis (e.g. `en`, `es`, `pt-BR`). Auto-detected from the recipient when omitted.
     */
    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * Hard limit on call length in minutes. The call ends automatically when reached.
     */
    public function withMaxCallDurationMinutes(
        int $maxCallDurationMinutes
    ): self {
        $self = clone $this;
        $self['maxCallDurationMinutes'] = $maxCallDurationMinutes;

        return $self;
    }

    /**
     * How long the agent waits during silence before ending the call.
     */
    public function withMaxIdleSeconds(int $maxIdleSeconds): self
    {
        $self = clone $this;
        $self['maxIdleSeconds'] = $maxIdleSeconds;

        return $self;
    }

    /**
     * Model that runs the conversation, co-located in the voice network for lowest latency. Independent of the model used for text messaging. Derived from the agent's text model when omitted.
     */
    public function withModel(string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * Whether the call audio is recorded.
     */
    public function withRecordCalls(bool $recordCalls): self
    {
        $self = clone $this;
        $self['recordCalls'] = $recordCalls;

        return $self;
    }

    /**
     * Speech-recognition model. Uses the default when omitted.
     */
    public function withSttModel(string $sttModel): self
    {
        $self = clone $this;
        $self['sttModel'] = $sttModel;

        return $self;
    }

    /**
     * Speech-recognition provider. Uses the default when omitted.
     */
    public function withSttProvider(string $sttProvider): self
    {
        $self = clone $this;
        $self['sttProvider'] = $sttProvider;

        return $self;
    }

    /**
     * E.164 phone number the agent can transfer the call to. When set, the agent is given a transfer tool it can use to hand the call to a human.
     */
    public function withTransferPhoneNumber(string $transferPhoneNumber): self
    {
        $self = clone $this;
        $self['transferPhoneNumber'] = $transferPhoneNumber;

        return $self;
    }

    /**
     * Speech-synthesis provider. Uses the default when omitted.
     */
    public function withTtsProvider(string $ttsProvider): self
    {
        $self = clone $this;
        $self['ttsProvider'] = $ttsProvider;

        return $self;
    }

    /**
     * Identifier of the synthesized voice that speaks. Choose from the voices available in the dashboard. Uses a neutral default when omitted.
     */
    public function withTtsVoiceID(string $ttsVoiceID): self
    {
        $self = clone $this;
        $self['ttsVoiceID'] = $ttsVoiceID;

        return $self;
    }

    /**
     * What the agent does when an answering machine or voicemail is detected on an outbound call.
     *
     * @param VoicemailAction|value-of<VoicemailAction> $voicemailAction
     */
    public function withVoicemailAction(
        VoicemailAction|string $voicemailAction
    ): self {
        $self = clone $this;
        $self['voicemailAction'] = $voicemailAction;

        return $self;
    }

    /**
     * Message spoken when `voicemailAction` is `leave_message`. Falls back to `greeting` when omitted.
     */
    public function withVoicemailMessage(string $voicemailMessage): self
    {
        $self = clone $this;
        $self['voicemailMessage'] = $voicemailMessage;

        return $self;
    }

    /**
     * Speech rate. 1.0 is natural. Only honoured by voices that support rate control; ignored by the others.
     */
    public function withVoiceSpeed(float $voiceSpeed): self
    {
        $self = clone $this;
        $self['voiceSpeed'] = $voiceSpeed;

        return $self;
    }
}
