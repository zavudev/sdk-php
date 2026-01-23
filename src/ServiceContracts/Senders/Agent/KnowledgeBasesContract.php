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

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface KnowledgeBasesContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        string $name,
        ?string $description = null,
        RequestOptions|array|null $requestOptions = null,
    ): KnowledgeBaseNewResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $kbID,
        string $senderID,
        RequestOptions|array|null $requestOptions = null,
    ): KnowledgeBaseGetResponse;

    /**
     * @api
     *
     * @param string $kbID Path param
     * @param string $senderID Path param
     * @param string|null $description Body param
     * @param string $name Body param
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $kbID,
        string $senderID,
        ?string $description = null,
        ?string $name = null,
        RequestOptions|array|null $requestOptions = null,
    ): KnowledgeBaseUpdateResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<AgentKnowledgeBase>
     *
     * @throws APIException
     */
    public function list(
        string $senderID,
        ?string $cursor = null,
        int $limit = 50,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $kbID,
        string $senderID,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;
}
