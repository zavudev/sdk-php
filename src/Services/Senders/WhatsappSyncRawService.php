<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\Senders\WhatsappSync\WhatsappSyncGetResponse;
use Zavudev\Senders\WhatsappSync\WhatsappSyncStartContactsSyncResponse;
use Zavudev\Senders\WhatsappSync\WhatsappSyncStartHistorySyncResponse;
use Zavudev\ServiceContracts\Senders\WhatsappSyncRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class WhatsappSyncRawService implements WhatsappSyncRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get the current sync status for a sender's WhatsApp coexistence account. Only available for senders connected in coexistence mode (WhatsApp Business App + Cloud API).
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WhatsappSyncGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/senders/%1$s/whatsapp-sync', $senderID],
            options: $requestOptions,
            convert: WhatsappSyncGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Initiate contact names sync from the WhatsApp Business App. This imports contact names stored in the app to Zavu. Only available for coexistence accounts with active status.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WhatsappSyncStartContactsSyncResponse>
     *
     * @throws APIException
     */
    public function startContactsSync(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/senders/%1$s/whatsapp-sync/contacts', $senderID],
            options: $requestOptions,
            convert: WhatsappSyncStartContactsSyncResponse::class,
        );
    }

    /**
     * @api
     *
     * Initiate message history sync from the WhatsApp Business App. This sends a request to the account owner to approve sharing their conversation history. Only available for coexistence accounts with active status.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WhatsappSyncStartHistorySyncResponse>
     *
     * @throws APIException
     */
    public function startHistorySync(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/senders/%1$s/whatsapp-sync/history', $senderID],
            options: $requestOptions,
            convert: WhatsappSyncStartHistorySyncResponse::class,
        );
    }
}
