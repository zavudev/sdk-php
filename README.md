# Zavu PHP SDK

Developer-friendly & type-safe PHP SDK for the Zavu multi-channel messaging API.

[![License: MIT](https://img.shields.io/badge/LICENSE_//_MIT-3b5bdb?style=for-the-badge&labelColor=eff6ff)](https://opensource.org/licenses/MIT)

<!-- Start Summary [summary] -->
## Summary

Zavu Messaging API: Unified multi-channel messaging API for Zavu.

Supported channels:
- **SMS**: Simple text messages
- **WhatsApp**: Rich messaging with media, buttons, lists, and templates

Design goals:
- Simple `send()` entrypoint for developers
- Project-level authentication via Bearer token
- Support for all WhatsApp message types (text, image, video, audio, document, sticker, location, contact, buttons, list, reaction, template)
- If a non-text message type is sent, WhatsApp channel is used automatically
- 24-hour WhatsApp conversation window enforcement
<!-- End Summary [summary] -->

<!-- Start Table of Contents [toc] -->
## Table of Contents
<!-- $toc-max-depth=2 -->
* [Zavu PHP SDK](#zavu-php-sdk)
  * [SDK Installation](#sdk-installation)
  * [SDK Example Usage](#sdk-example-usage)
  * [Authentication](#authentication)
  * [Available Resources and Operations](#available-resources-and-operations)
  * [Error Handling](#error-handling)
  * [Server Selection](#server-selection)
* [Development](#development)
  * [Maturity](#maturity)
  * [Contributions](#contributions)

<!-- End Table of Contents [toc] -->

<!-- Start SDK Installation [installation] -->
## SDK Installation



The SDK relies on [Composer](https://getcomposer.org/) to manage its dependencies.

To install the SDK first add the below to your `composer.json` file:

```json
{
    "repositories": [
        {
            "type": "github",
            "url": "https://github.com/zavudev/sdk-php.git"
        }
    ],
    "require": {
        "zavu/sdk-php": "*"
    }
}
```

Then run the following command:

```bash
composer update
```
<!-- End SDK Installation [installation] -->

<!-- Start SDK Example Usage [usage] -->
## SDK Example Usage

### Example

```php
declare(strict_types=1);

require 'vendor/autoload.php';

use Zavu\Sdk;
use Zavu\Sdk\Models\Components;

$sdk = Sdk\Zavu::builder()
    ->setSecurity(
        '<YOUR_BEARER_TOKEN_HERE>'
    )
    ->build();

$body = new Components\MessageRequest(
    to: '+56912345678',
    text: 'Your verification code is 123456',
);

$response = $sdk->sendMessage(
    body: $body,
    zavuSender: 'sender_12345'

);

if ($response->messageResponse !== null) {
    // handle response
}
```
<!-- End SDK Example Usage [usage] -->

<!-- Start Authentication [security] -->
## Authentication

### Per-Client Security Schemes

This SDK supports the following security scheme globally:

| Name         | Type | Scheme      |
| ------------ | ---- | ----------- |
| `bearerAuth` | http | HTTP Bearer |

To authenticate with the API the `bearerAuth` parameter must be set when initializing the SDK. For example:
```php
declare(strict_types=1);

require 'vendor/autoload.php';

use Zavu\Sdk;
use Zavu\Sdk\Models\Components;

$sdk = Sdk\Zavu::builder()
    ->setSecurity(
        '<YOUR_BEARER_TOKEN_HERE>'
    )
    ->build();

$body = new Components\MessageRequest(
    to: '+56912345678',
    text: 'Your verification code is 123456',
);

$response = $sdk->sendMessage(
    body: $body,
    zavuSender: 'sender_12345'

);

if ($response->messageResponse !== null) {
    // handle response
}
```
<!-- End Authentication [security] -->

<!-- Start Available Resources and Operations [operations] -->
## Available Resources and Operations

<details open>
<summary>Available methods</summary>

### [Zavu SDK](docs/sdks/zavu/README.md)

* [sendMessage](docs/sdks/zavu/README.md#sendmessage) - Send a message
* [listMessages](docs/sdks/zavu/README.md#listmessages) - List messages
* [getMessage](docs/sdks/zavu/README.md#getmessage) - Get message by ID
* [sendReaction](docs/sdks/zavu/README.md#sendreaction) - Send reaction to message
* [listTemplates](docs/sdks/zavu/README.md#listtemplates) - List templates
* [createTemplate](docs/sdks/zavu/README.md#createtemplate) - Create template
* [getTemplate](docs/sdks/zavu/README.md#gettemplate) - Get template
* [deleteTemplate](docs/sdks/zavu/README.md#deletetemplate) - Delete template
* [listSenders](docs/sdks/zavu/README.md#listsenders) - List senders
* [createSender](docs/sdks/zavu/README.md#createsender) - Create sender
* [getSender](docs/sdks/zavu/README.md#getsender) - Get sender
* [updateSender](docs/sdks/zavu/README.md#updatesender) - Update sender
* [deleteSender](docs/sdks/zavu/README.md#deletesender) - Delete sender
* [listContacts](docs/sdks/zavu/README.md#listcontacts) - List contacts
* [getContact](docs/sdks/zavu/README.md#getcontact) - Get contact
* [updateContact](docs/sdks/zavu/README.md#updatecontact) - Update contact
* [getContactByPhone](docs/sdks/zavu/README.md#getcontactbyphone) - Get contact by phone number
* [introspectPhone](docs/sdks/zavu/README.md#introspectphone) - Introspect phone number

</details>
<!-- End Available Resources and Operations [operations] -->

<!-- Start Error Handling [errors] -->
## Error Handling

Handling errors in this SDK should largely match your expectations. All operations return a response object or throw an exception.

By default an API error will raise a `Errors\APIException` exception, which has the following properties:

| Property       | Type                                    | Description           |
|----------------|-----------------------------------------|-----------------------|
| `$message`     | *string*                                | The error message     |
| `$statusCode`  | *int*                                   | The HTTP status code  |
| `$rawResponse` | *?\Psr\Http\Message\ResponseInterface*  | The raw HTTP response |
| `$body`        | *string*                                | The response content  |

When custom error responses are specified for an operation, the SDK may also throw their associated exception. You can refer to respective *Errors* tables in SDK docs for more details on possible exception types for each operation. For example, the `sendMessage` method throws the following exceptions:

| Error Type          | Status Code             | Content Type     |
| ------------------- | ----------------------- | ---------------- |
| Errors\Error        | 400, 401, 404, 409, 429 | application/json |
| Errors\Error        | 500                     | application/json |
| Errors\APIException | 4XX, 5XX                | \*/\*            |

### Example

```php
declare(strict_types=1);

require 'vendor/autoload.php';

use Zavu\Sdk;
use Zavu\Sdk\Models\Components;
use Zavu\Sdk\Models\Errors;

$sdk = Sdk\Zavu::builder()
    ->setSecurity(
        '<YOUR_BEARER_TOKEN_HERE>'
    )
    ->build();

try {
    $body = new Components\MessageRequest(
        to: '+56912345678',
        text: 'Your verification code is 123456',
    );

    $response = $sdk->sendMessage(
        body: $body,
        zavuSender: 'sender_12345'

    );

    if ($response->messageResponse !== null) {
        // handle response
    }
} catch (Errors\ErrorThrowable $e) {
    // handle $e->$container data
    throw $e;
} catch (Errors\ErrorThrowable $e) {
    // handle $e->$container data
    throw $e;
} catch (Errors\APIException $e) {
    // handle default exception
    throw $e;
}
```
<!-- End Error Handling [errors] -->

<!-- Start Server Selection [server] -->
## Server Selection

### Override Server URL Per-Client

The default server can be overridden globally using the `setServerUrl(string $serverUrl)` builder method when initializing the SDK client instance. For example:
```php
declare(strict_types=1);

require 'vendor/autoload.php';

use Zavu\Sdk;
use Zavu\Sdk\Models\Components;

$sdk = Sdk\Zavu::builder()
    ->setServerURL('https://api.zavu.dev')
    ->setSecurity(
        '<YOUR_BEARER_TOKEN_HERE>'
    )
    ->build();

$body = new Components\MessageRequest(
    to: '+56912345678',
    text: 'Your verification code is 123456',
);

$response = $sdk->sendMessage(
    body: $body,
    zavuSender: 'sender_12345'

);

if ($response->messageResponse !== null) {
    // handle response
}
```
<!-- End Server Selection [server] -->

<!-- Placeholder for Future Speakeasy SDK Sections -->

# Development

## Maturity

This SDK is in beta, and there may be breaking changes between versions without a major version update. Therefore, we recommend pinning usage
to a specific package version. This way, you can install the same version each time without breaking changes unless you are intentionally
looking for the latest version.

## Contributions

While we value open-source contributions to this SDK, this library is generated programmatically. Any manual changes added to internal files will be overwritten on the next generation. 
We look forward to hearing your feedback. Feel free to open a PR or an issue with a proof of concept and we'll do our best to include it in a future release. 

### SDK Created by [Speakeasy](https://www.speakeasy.com/?utm_source=openapi/openapi&utm_campaign=php)
