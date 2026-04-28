<?php

declare(strict_types=1);

namespace Zavudev;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Zavudev\Core\BaseClient;
use Zavudev\Core\Util;
use Zavudev\Services\AddressesService;
use Zavudev\Services\BalanceService;
use Zavudev\Services\BroadcastsService;
use Zavudev\Services\ContactsService;
use Zavudev\Services\ExportsService;
use Zavudev\Services\IntrospectService;
use Zavudev\Services\InvitationsService;
use Zavudev\Services\MessagesService;
use Zavudev\Services\Number10dlcService;
use Zavudev\Services\PhoneNumbersService;
use Zavudev\Services\PlanService;
use Zavudev\Services\RegulatoryDocumentsService;
use Zavudev\Services\SendersService;
use Zavudev\Services\SubAccountsService;
use Zavudev\Services\TemplatesService;
use Zavudev\Services\URLsService;
use Zavudev\Services\UsageService;

/**
 * @phpstan-import-type NormalizedRequest from \Zavudev\Core\BaseClient
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
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

    /**
     * @api
     */
    public InvitationsService $invitations;

    /**
     * @api
     */
    public ExportsService $exports;

    /**
     * @api
     */
    public URLsService $urls;

    /**
     * @api
     */
    public BalanceService $balance;

    /**
     * @api
     */
    public PlanService $plan;

    /**
     * @api
     */
    public UsageService $usage;

    /**
     * @api
     */
    public SubAccountsService $subAccounts;

    /**
     * @api
     */
    public Number10dlcService $number10dlc;

    /**
     * @param RequestOpts|null $requestOptions
     */
    public function __construct(
        ?string $apiKey = null,
        ?string $baseUrl = null,
        RequestOptions|array|null $requestOptions = null,
    ) {
        $this->apiKey = (string) ($apiKey ?? Util::getenv('ZAVUDEV_API_KEY'));

        $baseUrl ??= Util::getenv('ZAVUDEV_BASE_URL') ?: 'https://api.zavu.dev';

        $options = RequestOptions::parse(
            RequestOptions::with(
                uriFactory: Psr17FactoryDiscovery::findUriFactory(),
                streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
                requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
                transporter: Psr18ClientDiscovery::find(),
            ),
            $requestOptions,
        );

        /** @var array<string, string|null> $headers */
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'User-Agent' => sprintf('zavudev/PHP %s', VERSION),
            'X-Stainless-Lang' => 'php',
            'X-Stainless-Package-Version' => '0.7.0',
            'X-Stainless-Arch' => Util::machtype(),
            'X-Stainless-OS' => Util::ostype(),
            'X-Stainless-Runtime' => php_sapi_name(),
            'X-Stainless-Runtime-Version' => phpversion(),
        ];

        $customHeadersEnv = Util::getenv('ZAVUDEV_CUSTOM_HEADERS');
        if (null !== $customHeadersEnv) {
            foreach (explode("\n", $customHeadersEnv) as $line) {
                $colon = strpos($line, ':');
                if (false !== $colon) {
                    $headers[trim(substr($line, 0, $colon))] = trim(substr($line, $colon + 1));
                }
            }
        }

        parent::__construct(
            headers: $headers,
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
        $this->invitations = new InvitationsService($this);
        $this->exports = new ExportsService($this);
        $this->urls = new URLsService($this);
        $this->balance = new BalanceService($this);
        $this->plan = new PlanService($this);
        $this->usage = new UsageService($this);
        $this->subAccounts = new SubAccountsService($this);
        $this->number10dlc = new Number10dlcService($this);
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
