<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Client;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\Senders\Sender;
use Zavudev\Senders\SenderUpdateProfileResponse;
use Zavudev\Senders\SenderUploadProfilePictureResponse;
use Zavudev\Senders\WebhookEvent;
use Zavudev\Senders\WebhookSecretResponse;
use Zavudev\Senders\WhatsappBusinessProfileResponse;

/**
 * @internal
 */
#[CoversNothing]
final class SendersTest extends TestCase
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
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->create(
            name: 'name',
            phoneNumber: 'phoneNumber'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Sender::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->create(
            name: 'name',
            phoneNumber: 'phoneNumber',
            setAsDefault: true,
            webhookEvents: [WebhookEvent::MESSAGE_QUEUED],
            webhookURL: 'https://example.com',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Sender::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->retrieve('senderId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Sender::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->update('senderId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Sender::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $page = $this->client->senders->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Cursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(Sender::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->delete('senderId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testGetProfile(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->getProfile('senderId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(WhatsappBusinessProfileResponse::class, $result);
    }

    #[Test]
    public function testRegenerateWebhookSecret(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->regenerateWebhookSecret('senderId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(WebhookSecretResponse::class, $result);
    }

    #[Test]
    public function testUpdateProfile(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->updateProfile('senderId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SenderUpdateProfileResponse::class, $result);
    }

    #[Test]
    public function testUploadProfilePicture(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->uploadProfilePicture(
            'senderId',
            imageURL: 'https://example.com/profile.jpg',
            mimeType: 'image/jpeg',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SenderUploadProfilePictureResponse::class, $result);
    }

    #[Test]
    public function testUploadProfilePictureWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->uploadProfilePicture(
            'senderId',
            imageURL: 'https://example.com/profile.jpg',
            mimeType: 'image/jpeg',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SenderUploadProfilePictureResponse::class, $result);
    }
}
