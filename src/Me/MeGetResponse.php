<?php

declare(strict_types=1);

namespace Zavudev\Me;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Me\MeGetResponse\APIKey;
use Zavudev\Me\MeGetResponse\Project;
use Zavudev\Me\MeGetResponse\Team;

/**
 * @phpstan-import-type APIKeyShape from \Zavudev\Me\MeGetResponse\APIKey
 * @phpstan-import-type ProjectShape from \Zavudev\Me\MeGetResponse\Project
 * @phpstan-import-type TeamShape from \Zavudev\Me\MeGetResponse\Team
 *
 * @phpstan-type MeGetResponseShape = array{
 *   apiKey: APIKey|APIKeyShape,
 *   isTestMode: bool,
 *   project: Project|ProjectShape,
 *   team: Team|TeamShape,
 * }
 */
final class MeGetResponse implements BaseModel
{
    /** @use SdkModel<MeGetResponseShape> */
    use SdkModel;

    #[Required]
    public APIKey $apiKey;

    #[Required]
    public bool $isTestMode;

    #[Required]
    public Project $project;

    #[Required]
    public Team $team;

    /**
     * `new MeGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MeGetResponse::with(apiKey: ..., isTestMode: ..., project: ..., team: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MeGetResponse)
     *   ->withAPIKey(...)
     *   ->withIsTestMode(...)
     *   ->withProject(...)
     *   ->withTeam(...)
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
     * @param APIKey|APIKeyShape $apiKey
     * @param Project|ProjectShape $project
     * @param Team|TeamShape $team
     */
    public static function with(
        APIKey|array $apiKey,
        bool $isTestMode,
        Project|array $project,
        Team|array $team,
    ): self {
        $self = new self;

        $self['apiKey'] = $apiKey;
        $self['isTestMode'] = $isTestMode;
        $self['project'] = $project;
        $self['team'] = $team;

        return $self;
    }

    /**
     * @param APIKey|APIKeyShape $apiKey
     */
    public function withAPIKey(APIKey|array $apiKey): self
    {
        $self = clone $this;
        $self['apiKey'] = $apiKey;

        return $self;
    }

    public function withIsTestMode(bool $isTestMode): self
    {
        $self = clone $this;
        $self['isTestMode'] = $isTestMode;

        return $self;
    }

    /**
     * @param Project|ProjectShape $project
     */
    public function withProject(Project|array $project): self
    {
        $self = clone $this;
        $self['project'] = $project;

        return $self;
    }

    /**
     * @param Team|TeamShape $team
     */
    public function withTeam(Team|array $team): self
    {
        $self = clone $this;
        $self['team'] = $team;

        return $self;
    }
}
