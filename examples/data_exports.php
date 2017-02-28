<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/config.php';

use Digitouch\AdForm\Client\HttpClient;
use Digitouch\AdForm\ApiFactory;
use Digitouch\AdForm\Auth\Ticket;
use Digitouch\AdForm\Exception\Response\AdFormResponseException;
use Digitouch\AdForm\Exception\Response as ResponseException;

$errorOccurred = 0;
$error = null;
$file = __DIR__.'/ticket.txt';
if(!file_exists($file)){
    file_put_contents($file, '');
}

$api = new ApiFactory(new HttpClient);

do {
    try {

        $staticTicket = file_get_contents($file);
        $ticket = new Ticket($staticTicket);
        $result = $api->call(ApiFactory::DATA_EXPORT, $ticket, ['DataExportsIds' => 149843]);
        dump($result->fetch());
        exit(0);

    } catch (ResponseException\AdFormResponseException $e) {
        $error = $e;
        $errorOccurred++;
        if($e instanceof ResponseException\TicketInvalidException || $e instanceof ResponseException\TicketMissingException) {
            $ticket = $api->auth(USERNAME, PASSWORD);
            file_put_contents($file, $ticket);
        }

    } catch (\Exception $e) {
        dump($e->getMessage());
        exit(0);
    }

} while ($errorOccurred < 2 && null !== $error);


if (null !== $error) {
    dump(get_class($error), $error->getMessage(), $error->getResponse());
    exit(0);
}
