<?php

declare(strict_types=1);

namespace Zavudev;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Zavudev\Core\BaseClient;
use Zavudev\Core\Util;
use Zavudev\Services\AddressesService;
use Zavudev\Services\BroadcastsService;
use Zavudev\Services\ContactsService;
use Zavudev\Services\IntrospectService;
use Zavudev\Services\MessagesService;
use Zavudev\Services\PhoneNumbersService;
use Zavudev\Services\RegulatoryDocumentsService;
use Zavudev\Services\SendersService;
use Zavudev\Services\TemplatesService;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 * @phpstan-import-type NormalizedRequest from \Zavudev\Core\BaseClient
 */
class Client extends BaseClient
{
    public string $apiKey;

    /**
     * @api
     */
    public MessagesService $messages;

    /**
     * @api
     */
    public TemplatesService $templates;

    /**
     * @api
     */
    public SendersService $senders;

    /**
     * @api
     */
    public ContactsService $contacts;

    /**
     * @api
     */
    public BroadcastsService $broadcasts;

    /**
     * @api
     */
    public IntrospectService $introspect;

    /**
     * @api
     */
    public PhoneNumbersService $phoneNumbers;

    /**
     * @api
     */
    public AddressesService $addresses;

    /**
     * @api
     */
    public RegulatoryDocumentsService $regulatoryDocuments;

    public function __construct(?string $apiKey = null, ?string $baseUrl = null)
    {
        $this->apiKey = (string) ($apiKey ?? getenv('ZAVUDEV_API_KEY'));

        $baseUrl ??= getenv('ZAVUDEV_BASE_URL') ?: 'https://api.zavu.dev';

        $options = RequestOptions::with(
            uriFactory: Psr17FactoryDiscovery::findUriFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            transporter: Psr18ClientDiscovery::find(),
        );

        parent::__construct(
            headers: [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'User-Agent' => sprintf('zavudev/PHP %s', VERSION),
                'X-Stainless-Lang' => 'php',
                'X-Stainless-Package-Version' => '0.0.1',
                'X-Stainless-Arch' => Util::machtype(),
                'X-Stainless-OS' => Util::ostype(),
                'X-Stainless-Runtime' => php_sapi_name(),
                'X-Stainless-Runtime-Version' => phpversion(),
            ],
            baseUrl: $baseUrl,
            options: $options
        );

        $this->messages = new MessagesService($this);
        $this->templates = new TemplatesService($this);
        $this->senders = new SendersService($this);
        $this->contacts = new ContactsService($this);
        $this->broadcasts = new BroadcastsService($this);
        $this->introspect = new IntrospectService($this);
        $this->phoneNumbers = new PhoneNumbersService($this);
        $this->addresses = new AddressesService($this);
        $this->regulatoryDocuments = new RegulatoryDocumentsService($this);
    }

    /** @return array<string,string> */
    protected function authHeaders(): array
    {
        return $this->apiKey ? ['Authorization' => "Bearer {$this->apiKey}"] : [];
    }

    /**
     * @internal
     *
     * @param string|list<string> $path
     * @param array<string,mixed> $query
     * @param array<string,string|int|list<string|int>|null> $headers
     * @param RequestOpts|null $opts
     *
     * @return array{NormalizedRequest, RequestOptions}
     */
    protected function buildRequest(
        string $method,
        string|array $path,
        array $query,
        array $headers,
        mixed $body,
        RequestOptions|array|null $opts,
    ): array {
        return parent::buildRequest(
            method: $method,
            path: $path,
            query: $query,
            headers: [...$this->authHeaders(), ...$headers],
            body: $body,
            opts: $opts,
        );
    }
}
