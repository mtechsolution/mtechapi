# Mtech limited Php SDK

[![Latest Stable Version](https://img.shields.io/packagist/v/mtechke/api)](https://packagist.org/packages/mtechke/api)

> This SDK provides a seamless integration to MTECH products

## Documentation

[//]: # (Take a look at the [API docs here]&#40;http://docs.mtechcomm.co.ke)

## Install

You can install the PHP SDK via composer or by downloading the source

#### Via Composer

The recommended way to install the SDK is with [Composer](http://getcomposer.org/).

```bash
composer require mtechke/api
```

## Usage

The SDK needs to be instantiated using your username and API key, which you can get from the [MTECH service portal](https://mtechcomm.co.ke/).

### Token Generation

```php
use Mtechke\Api\MtechApi;;

$username = 'YOUR_USERNAME'; 
$apiKey   = 'YOUR_API_KEY'; 
$mtechApi       = new MtechApi($username, $apiKey);

$token      = $mtechApi->token();
$result   = $token->getToken();

print_r($result);
```

### Send SMS

```php
use Mtechke\Api\MtechApi;;

$username = 'YOUR_USERNAME'; 
$apiKey   = 'YOUR_API_KEY'; 
$mtechApi       = new MtechApi($username, $apiKey);

// Get one of the services
$token      = $mtechApi->sms();

$result   = $token->sendSms([
    "msisdns" => ["254XXXXXXXXX","254XXXXXXXXX"],
    'sender' => "sender id",
    'message_id' => uniqid(),
    'message' => "Message",
    'token' => "XXXX", // token generated on the token generation
    "message_type" => "Promotional",
    "dlr_url" => "https://callbackexample.com"
]);

print_r($result);
```

### SMS

- `message_id`: This is the unique alphanumeric that is used to identify each client message. This is the id that will be used to send the delivery status of client messages via the "dlr_url" provided.

- `message`: This is the message string that is to be delivered to the handset user. NB: There is no upper limit for the message string length. Do note that a message is 160 characters. If you send a message with 161 characters, we will charge as 2 messages.

- `sender`: This the SenderName to be used to deliver the message. If you not sure what to provide, kindly contact Mtech support for counsel.

- `message_type`: This can be either be "Transactional" or "Promotional". "Transactional" takes higher priority than "Promotional" messages. "Transactional" messages include OTPs.

- `dlr_url`: This is the GET callback url Mtech will use to forward the delivery status of each message to client system. Sample request: _https://callbackexample.com?message_id=aa747fhvhh-47748-464&status=DeliveredToTerminal&msisdn=254712723648_ **NB**: Mtech will forward the message delivery report for each sent message immediately after we receive it from the network.

- `encrypted`: Provide "1" if the string provided in the "message" parameter is encrypted. Else, provide "0" if the message is in plaintext.

- `encryption_method`: This is the encryption method used to encrypt the string provided in the message parameter E.g id-aes256-GCM

- `msisdns`: This parameter takes an array containing the list of phone numbers to receive the message. E.g ["254726789778","254726789778"]

**NB**: _We advice that you send the messages in batches (1-500 msisdns in each request ) to reduce the size of the payload_
**NB**: _Use international country prefixes when providing the msisdns e.g 254712723648_

## Issues

_If you find a bug, please file an issue on [our issue tracker on GitHub](https://github.com/mtechsolution/mtechapi/issues)._