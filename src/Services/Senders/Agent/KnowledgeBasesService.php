<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders\Agent;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\KnowledgeBases\AgentKnowledgeBase;
use Zavudev\Senders\Agent\KnowledgeBases\KnowledgeBaseGetResponse;
use Zavudev\Senders\Agent\KnowledgeBases\KnowledgeBaseNewResponse;
use Zavudev\Senders\Agent\KnowledgeBases\KnowledgeBaseUpdateResponse;
use Zavudev\ServiceContracts\Senders\Agent\KnowledgeBasesContract;
use Zavudev\Services\Senders\Agent\KnowledgeBases\DocumentsService;

final class KnowledgeBasesService implements KnowledgeBasesContract
{
    /**
     * @api
     */
    public KnowledgeBasesRawService $raw;

    /**
     * @api
     */
    public DocumentsService $documents;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new KnowledgeBasesRawService($client);
        $this->documents = new DocumentsService($client);
    }

    /**
     * @api
     *
     * Create a new knowledge base for an agent.
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        string $name,
        ?string $description = null,
        ?RequestOptions $requestOptions = null,
    ): KnowledgeBaseNewResponse {
        $params = Util::removeNulls(
            ['name' => $name, 'description' => $description]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create($senderID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get a specific knowledge base.
     *
     * @throws APIException
     */
    public function retrieve(
        string $kbID,
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): KnowledgeBaseGetResponse {
        $params = Util::removeNulls(['senderID' => $senderID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($kbID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update a knowledge base.
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
    ): KnowledgeBaseUpdateResponse {
        $params = Util::removeNulls(
            ['senderID' => $senderID, 'description' => $description, 'name' => $name]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($kbID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List knowledge bases for an agent.
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
    ): Cursor {
        $params = Util::removeNulls(['cursor' => $cursor, 'limit' => $limit]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($senderID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete a knowledge base and all its documents.
     *
     * @throws APIException
     */
    public function delete(
        string $kbID,
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): mixed {
        $params = Util::removeNulls(['senderID' => $senderID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($kbID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
