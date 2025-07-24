# Laravel Wise Payment Gateway

A Laravel package for integrating **Wise (formerly TransferWise)** payment gateway with ease.

---

## Features
- Create **currency quotes** (USD → EUR, etc.).
- Create **recipients**.
- Create and **fund transfers**.
- Supports **sandbox** and **production** environments.
- Easy configuration and ready-to-use **Facade (Wise)**.

---

## Installation

Install via Composer:

```bash
composer require ikbal/laravel-wise-payment
```

### Add to your `.env` file:

```env
WISE_API_URL=https://api.sandbox.transferwise.tech
WISE_API_TOKEN=your_api_token
WISE_PROFILE_ID=your_profile_id
```

For production, use:

```env
WISE_API_URL=https://api.transferwise.com
```

---

## Usage

Now call Wise API services easily:

```php
use Wise;

// Create a quote
$quote = Wise::createQuote(100, 'USD', 'EUR');

// Create a recipient
$recipient = Wise::createRecipient('John Doe', 'EUR', 'DE89370400440532013000');

// Create a transfer
$transfer = Wise::createTransfer($recipient['id'], $quote['id']);

// Fund the transfer
$fund = Wise::fundTransfer($transfer['id']);
```

---

## Example Controller

```php
namespace App\Http\Controllers;

use Wise;

class PaymentController extends Controller
{
    public function sendPayment()
    {
        $quote = Wise::createQuote(100, 'USD', 'EUR');
        $recipient = Wise::createRecipient('John Doe', 'EUR', 'DE89370400440532013000');
        $transfer = Wise::createTransfer($recipient['id'], $quote['id']);
        $fund = Wise::fundTransfer($transfer['id']);

        return response()->json(compact('quote', 'recipient', 'transfer', 'fund'));
    }
}
```


