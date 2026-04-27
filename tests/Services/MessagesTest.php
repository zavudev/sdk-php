<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Client;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\Messages\Channel;
use Zavudev\Messages\Message;
use Zavudev\Messages\MessageResponse;
use Zavudev\Messages\MessageType;

/**
 * @internal
 */
#[CoversNothing]
final class MessagesTest extends TestCase
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
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->messages->retrieve('messageId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MessageResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $page = $this->client->messages->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Cursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(Message::class, $item);
        }
    }

    #[Test]
    public function testReact(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->messages->react('messageId', emoji: '👍');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MessageResponse::class, $result);
    }

    #[Test]
    public function testReactWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->messages->react(
            'messageId',
            emoji: '👍',
            zavuSender: 'sender_12345'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MessageResponse::class, $result);
    }

    #[Test]
    public function testSend(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->messages->send(to: '+56912345678');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MessageResponse::class, $result);
    }

    #[Test]
    public function testSendWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->messages->send(
            to: '+56912345678',
            attachments: [
                [
                    'filename' => 'invoice.pdf',
                    'content' => 'content',
                    'contentID' => 'logo',
                    'contentType' => 'application/pdf',
                    'path' => 'https://example.com',
                ],
            ],
            channel: Channel::AUTO,
            content: [
                'buttons' => [['id' => 'id', 'title' => 'title']],
                'contacts' => [['name' => 'name', 'phones' => ['string']]],
                'ctaDisplayText' => 'See Dates',
                'ctaHeaderMediaURL' => 'https://example.com',
                'ctaHeaderText' => 'ctaHeaderText',
                'ctaHeaderType' => 'text',
                'ctaURL' => 'https://example.com/schedule',
                'emoji' => 'emoji',
                'filename' => 'invoice.pdf',
                'footerText' => 'Dates subject to change.',
                'latitude' => 0,
                'listButton' => 'listButton',
                'locationAddress' => 'locationAddress',
                'locationName' => 'locationName',
                'longitude' => 0,
                'mediaID' => 'mediaId',
                'mediaURL' => 'https://example.com/image.jpg',
                'mimeType' => 'image/jpeg',
                'reactToMessageID' => 'reactToMessageId',
                'sections' => [
                    [
                        'rows' => [
                            ['id' => 'id', 'title' => 'title', 'description' => 'description'],
                        ],
                        'title' => 'title',
                    ],
                ],
                'templateButtonVariables' => ['0' => 'abc-report-token'],
                'templateID' => 'templateId',
                'templateVariables' => ['1' => 'John', '2' => 'ORD-12345'],
            ],
            fallbackEnabled: true,
            htmlBody: 'htmlBody',
            idempotencyKey: 'msg_01HZY4ZP7VQY2J3BRW7Z6G0QGE',
            messageType: MessageType::TEXT,
            metadata: ['foo' => 'string'],
            replyTo: 'support@example.com',
            subject: 'Your order confirmation',
            text: 'Your verification code is 123456',
            voiceLanguage: 'es-ES',
            zavuSender: 'sender_12345',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MessageResponse::class, $result);
    }
}
