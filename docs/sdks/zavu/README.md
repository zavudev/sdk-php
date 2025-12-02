# Zavu SDK

## Overview

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


### Available Operations

* [sendMessage](#sendmessage) - Send a message
* [listMessages](#listmessages) - List messages
* [getMessage](#getmessage) - Get message by ID
* [sendReaction](#sendreaction) - Send reaction to message
* [listTemplates](#listtemplates) - List templates
* [createTemplate](#createtemplate) - Create template
* [getTemplate](#gettemplate) - Get template
* [deleteTemplate](#deletetemplate) - Delete template
* [listSenders](#listsenders) - List senders
* [createSender](#createsender) - Create sender
* [getSender](#getsender) - Get sender
* [updateSender](#updatesender) - Update sender
* [deleteSender](#deletesender) - Delete sender
* [listContacts](#listcontacts) - List contacts
* [getContact](#getcontact) - Get contact
* [updateContact](#updatecontact) - Update contact
* [getContactByPhone](#getcontactbyphone) - Get contact by phone number
* [introspectPhone](#introspectphone) - Introspect phone number

## sendMessage

Send a message to a recipient via SMS or WhatsApp.

**Channel selection:**
- If `channel` is omitted and `messageType` is `text`, defaults to SMS
- If `messageType` is anything other than `text`, WhatsApp is used automatically

**WhatsApp 24-hour window:**
- Free-form messages (non-template) require an open 24h window
- Window opens when the user messages you first
- Use template messages to initiate conversations outside the window

### Example Usage

<!-- UsageSnippet language="php" operationID="sendMessage" method="post" path="/v1/messages" -->
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

### Parameters

| Parameter                                                                          | Type                                                                               | Required                                                                           | Description                                                                        | Example                                                                            |
| ---------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------- |
| `body`                                                                             | [Components\MessageRequest](../../Models/Components/MessageRequest.md)             | :heavy_check_mark:                                                                 | N/A                                                                                |                                                                                    |
| `zavuSender`                                                                       | *?string*                                                                          | :heavy_minus_sign:                                                                 | Optional sender profile ID. If omitted, the project's default sender will be used. | sender_12345                                                                       |

### Response

**[?Operations\SendMessageResponse](../../Models/Operations/SendMessageResponse.md)**

### Errors

| Error Type              | Status Code             | Content Type            |
| ----------------------- | ----------------------- | ----------------------- |
| Errors\Error            | 400, 401, 404, 409, 429 | application/json        |
| Errors\Error            | 500                     | application/json        |
| Errors\APIException     | 4XX, 5XX                | \*/\*                   |

## listMessages

List messages previously sent by this project.

### Example Usage

<!-- UsageSnippet language="php" operationID="listMessages" method="get" path="/v1/messages" -->
```php
declare(strict_types=1);

require 'vendor/autoload.php';

use Zavu\Sdk;
use Zavu\Sdk\Models\Operations;

$sdk = Sdk\Zavu::builder()
    ->setSecurity(
        '<YOUR_BEARER_TOKEN_HERE>'
    )
    ->build();

$request = new Operations\ListMessagesRequest();

$response = $sdk->listMessages(
    request: $request
);

if ($response->object !== null) {
    // handle response
}
```

### Parameters

| Parameter                                                                        | Type                                                                             | Required                                                                         | Description                                                                      |
| -------------------------------------------------------------------------------- | -------------------------------------------------------------------------------- | -------------------------------------------------------------------------------- | -------------------------------------------------------------------------------- |
| `$request`                                                                       | [Operations\ListMessagesRequest](../../Models/Operations/ListMessagesRequest.md) | :heavy_check_mark:                                                               | The request object to use for the request.                                       |

### Response

**[?Operations\ListMessagesResponse](../../Models/Operations/ListMessagesResponse.md)**

### Errors

| Error Type          | Status Code         | Content Type        |
| ------------------- | ------------------- | ------------------- |
| Errors\Error        | 401                 | application/json    |
| Errors\APIException | 4XX, 5XX            | \*/\*               |

## getMessage

Get message by ID

### Example Usage

<!-- UsageSnippet language="php" operationID="getMessage" method="get" path="/v1/messages/{messageId}" -->
```php
declare(strict_types=1);

require 'vendor/autoload.php';

use Zavu\Sdk;

$sdk = Sdk\Zavu::builder()
    ->setSecurity(
        '<YOUR_BEARER_TOKEN_HERE>'
    )
    ->build();



$response = $sdk->getMessage(
    messageId: '<id>'
);

if ($response->messageResponse !== null) {
    // handle response
}
```

### Parameters

| Parameter          | Type               | Required           | Description        |
| ------------------ | ------------------ | ------------------ | ------------------ |
| `messageId`        | *string*           | :heavy_check_mark: | N/A                |

### Response

**[?Operations\GetMessageResponse](../../Models/Operations/GetMessageResponse.md)**

### Errors

| Error Type          | Status Code         | Content Type        |
| ------------------- | ------------------- | ------------------- |
| Errors\Error        | 401, 404            | application/json    |
| Errors\APIException | 4XX, 5XX            | \*/\*               |

## sendReaction

Send an emoji reaction to an existing WhatsApp message. Reactions are only supported for WhatsApp messages.

### Example Usage

<!-- UsageSnippet language="php" operationID="sendReaction" method="post" path="/v1/messages/{messageId}/reactions" -->
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

$body = new Components\ReactionRequest(
    emoji: '👍',
);

$response = $sdk->sendReaction(
    messageId: '<id>',
    body: $body,
    zavuSender: 'sender_12345'

);

if ($response->messageResponse !== null) {
    // handle response
}
```

### Parameters

| Parameter                                                                          | Type                                                                               | Required                                                                           | Description                                                                        | Example                                                                            |
| ---------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------- |
| `messageId`                                                                        | *string*                                                                           | :heavy_check_mark:                                                                 | N/A                                                                                |                                                                                    |
| `body`                                                                             | [Components\ReactionRequest](../../Models/Components/ReactionRequest.md)           | :heavy_check_mark:                                                                 | N/A                                                                                |                                                                                    |
| `zavuSender`                                                                       | *?string*                                                                          | :heavy_minus_sign:                                                                 | Optional sender profile ID. If omitted, the project's default sender will be used. | sender_12345                                                                       |

### Response

**[?Operations\SendReactionResponse](../../Models/Operations/SendReactionResponse.md)**

### Errors

| Error Type          | Status Code         | Content Type        |
| ------------------- | ------------------- | ------------------- |
| Errors\Error        | 400, 401, 404       | application/json    |
| Errors\APIException | 4XX, 5XX            | \*/\*               |

## listTemplates

List WhatsApp message templates for this project.

### Example Usage

<!-- UsageSnippet language="php" operationID="listTemplates" method="get" path="/v1/templates" -->
```php
declare(strict_types=1);

require 'vendor/autoload.php';

use Zavu\Sdk;

$sdk = Sdk\Zavu::builder()
    ->setSecurity(
        '<YOUR_BEARER_TOKEN_HERE>'
    )
    ->build();



$response = $sdk->listTemplates(

);

if ($response->object !== null) {
    // handle response
}
```

### Response

**[?Operations\ListTemplatesResponse](../../Models/Operations/ListTemplatesResponse.md)**

### Errors

| Error Type          | Status Code         | Content Type        |
| ------------------- | ------------------- | ------------------- |
| Errors\Error        | 401                 | application/json    |
| Errors\APIException | 4XX, 5XX            | \*/\*               |

## createTemplate

Create a WhatsApp message template. Note: Templates must be approved by Meta before use.

### Example Usage

<!-- UsageSnippet language="php" operationID="createTemplate" method="post" path="/v1/templates" -->
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

$request = new Components\TemplateCreateRequest(
    name: 'order_confirmation',
    body: 'Hi {{1}}, your order {{2}} has been confirmed and will ship within 24 hours.',
    whatsappCategory: Components\WhatsAppCategory::Utility,
    variables: [
        'customer_name',
        'order_id',
    ],
);

$response = $sdk->createTemplate(
    request: $request
);

if ($response->template !== null) {
    // handle response
}
```

### Parameters

| Parameter                                                                            | Type                                                                                 | Required                                                                             | Description                                                                          |
| ------------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------ |
| `$request`                                                                           | [Components\TemplateCreateRequest](../../Models/Components/TemplateCreateRequest.md) | :heavy_check_mark:                                                                   | The request object to use for the request.                                           |

### Response

**[?Operations\CreateTemplateResponse](../../Models/Operations/CreateTemplateResponse.md)**

### Errors

| Error Type          | Status Code         | Content Type        |
| ------------------- | ------------------- | ------------------- |
| Errors\Error        | 400, 401            | application/json    |
| Errors\APIException | 4XX, 5XX            | \*/\*               |

## getTemplate

Get template

### Example Usage

<!-- UsageSnippet language="php" operationID="getTemplate" method="get" path="/v1/templates/{templateId}" -->
```php
declare(strict_types=1);

require 'vendor/autoload.php';

use Zavu\Sdk;

$sdk = Sdk\Zavu::builder()
    ->setSecurity(
        '<YOUR_BEARER_TOKEN_HERE>'
    )
    ->build();



$response = $sdk->getTemplate(
    templateId: '<id>'
);

if ($response->template !== null) {
    // handle response
}
```

### Parameters

| Parameter          | Type               | Required           | Description        |
| ------------------ | ------------------ | ------------------ | ------------------ |
| `templateId`       | *string*           | :heavy_check_mark: | N/A                |

### Response

**[?Operations\GetTemplateResponse](../../Models/Operations/GetTemplateResponse.md)**

### Errors

| Error Type          | Status Code         | Content Type        |
| ------------------- | ------------------- | ------------------- |
| Errors\Error        | 401, 404            | application/json    |
| Errors\APIException | 4XX, 5XX            | \*/\*               |

## deleteTemplate

Delete template

### Example Usage

<!-- UsageSnippet language="php" operationID="deleteTemplate" method="delete" path="/v1/templates/{templateId}" -->
```php
declare(strict_types=1);

require 'vendor/autoload.php';

use Zavu\Sdk;

$sdk = Sdk\Zavu::builder()
    ->setSecurity(
        '<YOUR_BEARER_TOKEN_HERE>'
    )
    ->build();



$response = $sdk->deleteTemplate(
    templateId: '<id>'
);

if ($response->statusCode === 200) {
    // handle response
}
```

### Parameters

| Parameter          | Type               | Required           | Description        |
| ------------------ | ------------------ | ------------------ | ------------------ |
| `templateId`       | *string*           | :heavy_check_mark: | N/A                |

### Response

**[?Operations\DeleteTemplateResponse](../../Models/Operations/DeleteTemplateResponse.md)**

### Errors

| Error Type          | Status Code         | Content Type        |
| ------------------- | ------------------- | ------------------- |
| Errors\Error        | 401, 404            | application/json    |
| Errors\APIException | 4XX, 5XX            | \*/\*               |

## listSenders

List senders

### Example Usage

<!-- UsageSnippet language="php" operationID="listSenders" method="get" path="/v1/senders" -->
```php
declare(strict_types=1);

require 'vendor/autoload.php';

use Zavu\Sdk;

$sdk = Sdk\Zavu::builder()
    ->setSecurity(
        '<YOUR_BEARER_TOKEN_HERE>'
    )
    ->build();



$response = $sdk->listSenders(

);

if ($response->object !== null) {
    // handle response
}
```

### Response

**[?Operations\ListSendersResponse](../../Models/Operations/ListSendersResponse.md)**

### Errors

| Error Type          | Status Code         | Content Type        |
| ------------------- | ------------------- | ------------------- |
| Errors\Error        | 401                 | application/json    |
| Errors\APIException | 4XX, 5XX            | \*/\*               |

## createSender

Create sender

### Example Usage

<!-- UsageSnippet language="php" operationID="createSender" method="post" path="/v1/senders" -->
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

$request = new Components\SenderCreateRequest(
    name: '<value>',
    phoneNumber: '1-697-351-3400 x33934',
);

$response = $sdk->createSender(
    request: $request
);

if ($response->sender !== null) {
    // handle response
}
```

### Parameters

| Parameter                                                                        | Type                                                                             | Required                                                                         | Description                                                                      |
| -------------------------------------------------------------------------------- | -------------------------------------------------------------------------------- | -------------------------------------------------------------------------------- | -------------------------------------------------------------------------------- |
| `$request`                                                                       | [Components\SenderCreateRequest](../../Models/Components/SenderCreateRequest.md) | :heavy_check_mark:                                                               | The request object to use for the request.                                       |

### Response

**[?Operations\CreateSenderResponse](../../Models/Operations/CreateSenderResponse.md)**

### Errors

| Error Type          | Status Code         | Content Type        |
| ------------------- | ------------------- | ------------------- |
| Errors\Error        | 400, 401            | application/json    |
| Errors\APIException | 4XX, 5XX            | \*/\*               |

## getSender

Get sender

### Example Usage

<!-- UsageSnippet language="php" operationID="getSender" method="get" path="/v1/senders/{senderId}" -->
```php
declare(strict_types=1);

require 'vendor/autoload.php';

use Zavu\Sdk;

$sdk = Sdk\Zavu::builder()
    ->setSecurity(
        '<YOUR_BEARER_TOKEN_HERE>'
    )
    ->build();



$response = $sdk->getSender(
    senderId: '<id>'
);

if ($response->sender !== null) {
    // handle response
}
```

### Parameters

| Parameter          | Type               | Required           | Description        |
| ------------------ | ------------------ | ------------------ | ------------------ |
| `senderId`         | *string*           | :heavy_check_mark: | N/A                |

### Response

**[?Operations\GetSenderResponse](../../Models/Operations/GetSenderResponse.md)**

### Errors

| Error Type          | Status Code         | Content Type        |
| ------------------- | ------------------- | ------------------- |
| Errors\Error        | 401, 404            | application/json    |
| Errors\APIException | 4XX, 5XX            | \*/\*               |

## updateSender

Update sender

### Example Usage

<!-- UsageSnippet language="php" operationID="updateSender" method="patch" path="/v1/senders/{senderId}" -->
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

$body = new Components\SenderUpdateRequest();

$response = $sdk->updateSender(
    senderId: '<id>',
    body: $body

);

if ($response->sender !== null) {
    // handle response
}
```

### Parameters

| Parameter                                                                        | Type                                                                             | Required                                                                         | Description                                                                      |
| -------------------------------------------------------------------------------- | -------------------------------------------------------------------------------- | -------------------------------------------------------------------------------- | -------------------------------------------------------------------------------- |
| `senderId`                                                                       | *string*                                                                         | :heavy_check_mark:                                                               | N/A                                                                              |
| `body`                                                                           | [Components\SenderUpdateRequest](../../Models/Components/SenderUpdateRequest.md) | :heavy_check_mark:                                                               | N/A                                                                              |

### Response

**[?Operations\UpdateSenderResponse](../../Models/Operations/UpdateSenderResponse.md)**

### Errors

| Error Type          | Status Code         | Content Type        |
| ------------------- | ------------------- | ------------------- |
| Errors\Error        | 400, 401, 404       | application/json    |
| Errors\APIException | 4XX, 5XX            | \*/\*               |

## deleteSender

Delete sender

### Example Usage

<!-- UsageSnippet language="php" operationID="deleteSender" method="delete" path="/v1/senders/{senderId}" -->
```php
declare(strict_types=1);

require 'vendor/autoload.php';

use Zavu\Sdk;

$sdk = Sdk\Zavu::builder()
    ->setSecurity(
        '<YOUR_BEARER_TOKEN_HERE>'
    )
    ->build();



$response = $sdk->deleteSender(
    senderId: '<id>'
);

if ($response->statusCode === 200) {
    // handle response
}
```

### Parameters

| Parameter          | Type               | Required           | Description        |
| ------------------ | ------------------ | ------------------ | ------------------ |
| `senderId`         | *string*           | :heavy_check_mark: | N/A                |

### Response

**[?Operations\DeleteSenderResponse](../../Models/Operations/DeleteSenderResponse.md)**

### Errors

| Error Type          | Status Code         | Content Type        |
| ------------------- | ------------------- | ------------------- |
| Errors\Error        | 400, 401, 404       | application/json    |
| Errors\APIException | 4XX, 5XX            | \*/\*               |

## listContacts

List contacts

### Example Usage

<!-- UsageSnippet language="php" operationID="listContacts" method="get" path="/v1/contacts" -->
```php
declare(strict_types=1);

require 'vendor/autoload.php';

use Zavu\Sdk;

$sdk = Sdk\Zavu::builder()
    ->setSecurity(
        '<YOUR_BEARER_TOKEN_HERE>'
    )
    ->build();



$response = $sdk->listContacts(
    limit: 50
);

if ($response->object !== null) {
    // handle response
}
```

### Parameters

| Parameter          | Type               | Required           | Description        |
| ------------------ | ------------------ | ------------------ | ------------------ |
| `phoneNumber`      | *?string*          | :heavy_minus_sign: | N/A                |
| `limit`            | *?int*             | :heavy_minus_sign: | N/A                |
| `cursor`           | *?string*          | :heavy_minus_sign: | N/A                |

### Response

**[?Operations\ListContactsResponse](../../Models/Operations/ListContactsResponse.md)**

### Errors

| Error Type          | Status Code         | Content Type        |
| ------------------- | ------------------- | ------------------- |
| Errors\Error        | 401                 | application/json    |
| Errors\APIException | 4XX, 5XX            | \*/\*               |

## getContact

Get contact

### Example Usage

<!-- UsageSnippet language="php" operationID="getContact" method="get" path="/v1/contacts/{contactId}" -->
```php
declare(strict_types=1);

require 'vendor/autoload.php';

use Zavu\Sdk;

$sdk = Sdk\Zavu::builder()
    ->setSecurity(
        '<YOUR_BEARER_TOKEN_HERE>'
    )
    ->build();



$response = $sdk->getContact(
    contactId: '<id>'
);

if ($response->contact !== null) {
    // handle response
}
```

### Parameters

| Parameter          | Type               | Required           | Description        |
| ------------------ | ------------------ | ------------------ | ------------------ |
| `contactId`        | *string*           | :heavy_check_mark: | N/A                |

### Response

**[?Operations\GetContactResponse](../../Models/Operations/GetContactResponse.md)**

### Errors

| Error Type          | Status Code         | Content Type        |
| ------------------- | ------------------- | ------------------- |
| Errors\Error        | 401, 404            | application/json    |
| Errors\APIException | 4XX, 5XX            | \*/\*               |

## updateContact

Update contact

### Example Usage

<!-- UsageSnippet language="php" operationID="updateContact" method="patch" path="/v1/contacts/{contactId}" -->
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

$body = new Components\ContactUpdateRequest();

$response = $sdk->updateContact(
    contactId: '<id>',
    body: $body

);

if ($response->contact !== null) {
    // handle response
}
```

### Parameters

| Parameter                                                                          | Type                                                                               | Required                                                                           | Description                                                                        |
| ---------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------- |
| `contactId`                                                                        | *string*                                                                           | :heavy_check_mark:                                                                 | N/A                                                                                |
| `body`                                                                             | [Components\ContactUpdateRequest](../../Models/Components/ContactUpdateRequest.md) | :heavy_check_mark:                                                                 | N/A                                                                                |

### Response

**[?Operations\UpdateContactResponse](../../Models/Operations/UpdateContactResponse.md)**

### Errors

| Error Type          | Status Code         | Content Type        |
| ------------------- | ------------------- | ------------------- |
| Errors\Error        | 400, 401, 404       | application/json    |
| Errors\APIException | 4XX, 5XX            | \*/\*               |

## getContactByPhone

Get contact by phone number

### Example Usage

<!-- UsageSnippet language="php" operationID="getContactByPhone" method="get" path="/v1/contacts/phone/{phoneNumber}" -->
```php
declare(strict_types=1);

require 'vendor/autoload.php';

use Zavu\Sdk;

$sdk = Sdk\Zavu::builder()
    ->setSecurity(
        '<YOUR_BEARER_TOKEN_HERE>'
    )
    ->build();



$response = $sdk->getContactByPhone(
    phoneNumber: '397-335-4175 x077'
);

if ($response->contact !== null) {
    // handle response
}
```

### Parameters

| Parameter           | Type                | Required            | Description         |
| ------------------- | ------------------- | ------------------- | ------------------- |
| `phoneNumber`       | *string*            | :heavy_check_mark:  | E.164 phone number. |

### Response

**[?Operations\GetContactByPhoneResponse](../../Models/Operations/GetContactByPhoneResponse.md)**

### Errors

| Error Type          | Status Code         | Content Type        |
| ------------------- | ------------------- | ------------------- |
| Errors\Error        | 401, 404            | application/json    |
| Errors\APIException | 4XX, 5XX            | \*/\*               |

## introspectPhone

Validate a phone number and check if a WhatsApp conversation window is open.

### Example Usage

<!-- UsageSnippet language="php" operationID="introspectPhone" method="post" path="/v1/introspect/phone" -->
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

$request = new Components\PhoneIntrospectionRequest(
    phoneNumber: '+56912345678',
);

$response = $sdk->introspectPhone(
    request: $request
);

if ($response->phoneIntrospectionResponse !== null) {
    // handle response
}
```

### Parameters

| Parameter                                                                                    | Type                                                                                         | Required                                                                                     | Description                                                                                  |
| -------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------- |
| `$request`                                                                                   | [Components\PhoneIntrospectionRequest](../../Models/Components/PhoneIntrospectionRequest.md) | :heavy_check_mark:                                                                           | The request object to use for the request.                                                   |

### Response

**[?Operations\IntrospectPhoneResponse](../../Models/Operations/IntrospectPhoneResponse.md)**

### Errors

| Error Type          | Status Code         | Content Type        |
| ------------------- | ------------------- | ------------------- |
| Errors\Error        | 400, 401            | application/json    |
| Errors\APIException | 4XX, 5XX            | \*/\*               |