<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\Senders\WhatsappSync\WhatsappSyncGetResponse;
use Zavudev\Senders\WhatsappSync\WhatsappSyncStartContactsSyncResponse;
use Zavudev\Senders\WhatsappSync\WhatsappSyncStartHistorySyncResponse;
use Zavudev\ServiceContracts\Senders\WhatsappSyncContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class WhatsappSyncService implements WhatsappSyncContract
{
    /**
     * @api
     */
    public WhatsappSyncRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new WhatsappSyncRawService($client);
    }

    /**
     * @api
     *
     * Get the current sync status for a sender's WhatsApp coexistence account. Only available for senders connected in coexistence mode (WhatsApp Business App + Cloud API).
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): WhatsappSyncGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($senderID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Initiate contact names sync from the WhatsApp Business App. This imports contact names stored in the app to Zavu. Only available for coexistence accounts with active status.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function startContactsSync(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): WhatsappSyncStartContactsSyncResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->startContactsSync($senderID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Initiate message history sync from the WhatsApp Business App. This sends a request to the account owner to approve sharing their conversation history. Only available for coexistence accounts with active status.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function startHistorySync(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): WhatsappSyncStartHistorySyncResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->startHistorySync($senderID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
