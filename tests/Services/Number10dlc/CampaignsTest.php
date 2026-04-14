<?php

namespace Tests\Services\Number10dlc;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Client;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\Number10dlc\Campaigns\CampaignGetResponse;
use Zavudev\Number10dlc\Campaigns\CampaignNewResponse;
use Zavudev\Number10dlc\Campaigns\CampaignSubmitResponse;
use Zavudev\Number10dlc\Campaigns\CampaignSyncStatusResponse;
use Zavudev\Number10dlc\Campaigns\CampaignUpdateResponse;
use Zavudev\Number10dlc\Campaigns\TenDlcCampaign;

/**
 * @internal
 */
#[CoversNothing]
final class CampaignsTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $testUrl = Util::getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(apiKey: 'My API Key', baseUrl: $testUrl);

        $this->client = $client;
    }

    #[Test]
    public function testCreate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->number10dlc->campaigns->create(
            affiliateMarketing: false,
            ageGated: false,
            brandID: 'brand_abc123',
            description: 'Send order status updates and shipping notifications to customers who opted in.',
            directLending: false,
            embeddedLink: true,
            embeddedPhone: false,
            name: 'Order Notifications',
            numberPooling: false,
            sampleMessages: [
                'Hi {{name}}, your order #{{order_id}} has shipped! Track it at {{url}}',
                'Your order #{{order_id}} has been delivered. Thank you for your purchase!',
            ],
            subscriberHelp: true,
            subscriberOptIn: true,
            subscriberOptOut: true,
            useCase: 'ACCOUNT_NOTIFICATION',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CampaignNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->number10dlc->campaigns->create(
            affiliateMarketing: false,
            ageGated: false,
            brandID: 'brand_abc123',
            description: 'Send order status updates and shipping notifications to customers who opted in.',
            directLending: false,
            embeddedLink: true,
            embeddedPhone: false,
            name: 'Order Notifications',
            numberPooling: false,
            sampleMessages: [
                'Hi {{name}}, your order #{{order_id}} has shipped! Track it at {{url}}',
                'Your order #{{order_id}} has been delivered. Thank you for your purchase!',
            ],
            subscriberHelp: true,
            subscriberOptIn: true,
            subscriberOptOut: true,
            useCase: 'ACCOUNT_NOTIFICATION',
            helpMessage: 'helpMessage',
            messageFlow: 'messageFlow',
            optInKeywords: ['string'],
            optOutKeywords: ['string'],
            subUseCases: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CampaignNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->number10dlc->campaigns->retrieve('campaignId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CampaignGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->number10dlc->campaigns->update('campaignId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CampaignUpdateResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $page = $this->client->number10dlc->campaigns->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Cursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(TenDlcCampaign::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->number10dlc->campaigns->delete('campaignId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testSubmit(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->number10dlc->campaigns->submit('campaignId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CampaignSubmitResponse::class, $result);
    }

    #[Test]
    public function testSyncStatus(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->number10dlc->campaigns->syncStatus('campaignId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CampaignSyncStatusResponse::class, $result);
    }
}
