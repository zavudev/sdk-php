<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Client;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RegulatoryDocuments\RegulatoryDocument;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentGetResponse;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentNewResponse;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentUploadURLResponse;

/**
 * @internal
 */
#[CoversNothing]
final class RegulatoryDocumentsTest extends TestCase
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

        $result = $this->client->regulatoryDocuments->create(
            documentType: 'passport',
            fileSize: 102400,
            mimeType: 'image/jpeg',
            name: 'Passport Scan',
            storageID: 'kg2abc123...',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(RegulatoryDocumentNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->regulatoryDocuments->create(
            documentType: 'passport',
            fileSize: 102400,
            mimeType: 'image/jpeg',
            name: 'Passport Scan',
            storageID: 'kg2abc123...',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(RegulatoryDocumentNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->regulatoryDocuments->retrieve('documentId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(RegulatoryDocumentGetResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $page = $this->client->regulatoryDocuments->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Cursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(RegulatoryDocument::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->regulatoryDocuments->delete('documentId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testUploadURL(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->regulatoryDocuments->uploadURL();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            RegulatoryDocumentUploadURLResponse::class,
            $result
        );
    }
}
