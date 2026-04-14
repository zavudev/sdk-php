<?php

namespace Tests\Services\Number10dlc;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Client;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\Number10dlc\Brands\BrandGetResponse;
use Zavudev\Number10dlc\Brands\BrandListUseCasesResponse;
use Zavudev\Number10dlc\Brands\BrandNewResponse;
use Zavudev\Number10dlc\Brands\BrandSubmitResponse;
use Zavudev\Number10dlc\Brands\BrandSyncStatusResponse;
use Zavudev\Number10dlc\Brands\BrandUpdateResponse;
use Zavudev\Number10dlc\Brands\TenDlcBrand;

/**
 * @internal
 */
#[CoversNothing]
final class BrandsTest extends TestCase
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

        $result = $this->client->number10dlc->brands->create(
            city: 'San Francisco',
            country: 'US',
            displayName: 'Acme Corp',
            email: 'compliance@acme.com',
            entityType: 'PRIVATE_PROFIT',
            phone: '+14155551234',
            postalCode: '94102',
            state: 'CA',
            street: '123 Main St',
            vertical: 'Technology',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BrandNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->number10dlc->brands->create(
            city: 'San Francisco',
            country: 'US',
            displayName: 'Acme Corp',
            email: 'compliance@acme.com',
            entityType: 'PRIVATE_PROFIT',
            phone: '+14155551234',
            postalCode: '94102',
            state: 'CA',
            street: '123 Main St',
            vertical: 'Technology',
            companyName: 'Acme Corporation',
            ein: '12-3456789',
            firstName: 'firstName',
            lastName: 'lastName',
            stockExchange: 'stockExchange',
            stockSymbol: 'stockSymbol',
            website: 'https://acme.com',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BrandNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->number10dlc->brands->retrieve('brandId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BrandGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->number10dlc->brands->update('brandId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BrandUpdateResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $page = $this->client->number10dlc->brands->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Cursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(TenDlcBrand::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->number10dlc->brands->delete('brandId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testListUseCases(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->number10dlc->brands->listUseCases();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BrandListUseCasesResponse::class, $result);
    }

    #[Test]
    public function testSubmit(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->number10dlc->brands->submit('brandId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BrandSubmitResponse::class, $result);
    }

    #[Test]
    public function testSyncStatus(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->number10dlc->brands->syncStatus('brandId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BrandSyncStatusResponse::class, $result);
    }
}
