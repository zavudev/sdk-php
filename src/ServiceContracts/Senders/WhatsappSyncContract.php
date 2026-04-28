<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\Senders\WhatsappSync\WhatsappSyncGetResponse;
use Zavudev\Senders\WhatsappSync\WhatsappSyncStartContactsSyncResponse;
use Zavudev\Senders\WhatsappSync\WhatsappSyncStartHistorySyncResponse;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface WhatsappSyncContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): WhatsappSyncGetResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function startContactsSync(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): WhatsappSyncStartContactsSyncResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function startHistorySync(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): WhatsappSyncStartHistorySyncResponse;
}
