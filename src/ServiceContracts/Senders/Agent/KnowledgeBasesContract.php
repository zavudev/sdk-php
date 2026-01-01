<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders\Agent;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\KnowledgeBases\AgentKnowledgeBase;
use Zavudev\Senders\Agent\KnowledgeBases\KnowledgeBaseGetResponse;
use Zavudev\Senders\Agent\KnowledgeBases\KnowledgeBaseNewResponse;
use Zavudev\Senders\Agent\KnowledgeBases\KnowledgeBaseUpdateResponse;

interface KnowledgeBasesContract
{
    /**
     * @api
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        string $name,
        ?string $description = null,
        ?RequestOptions $requestOptions = null,
    ): KnowledgeBaseNewResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function retrieve(
        string $kbID,
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): KnowledgeBaseGetResponse;

    /**
     * @api
     *
     * @param string $kbID Path param:
     * @param string $senderID Path param:
     * @param string|null $description Body param:
     * @param string $name Body param:
     *
     * @throws APIException
     */
    public function update(
        string $kbID,
        string $senderID,
        ?string $description = null,
        ?string $name = null,
        ?RequestOptions $requestOptions = null,
    ): KnowledgeBaseUpdateResponse;

    /**
     * @api
     *
     * @return Cursor<AgentKnowledgeBase>
     *
     * @throws APIException
     */
    public function list(
        string $senderID,
        ?string $cursor = null,
        int $limit = 50,
        ?RequestOptions $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @throws APIException
     */
    public function delete(
        string $kbID,
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): mixed;
}
