<!-- Start SDK Example Usage [usage] -->
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