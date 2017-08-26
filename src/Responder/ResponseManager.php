<?php

namespace Masterclass\Responder;

use Aura\Accept\Accept;
use Aura\Payload_Interface\PayloadInterface;
use Aura\View\View;
use Aura\Web\Response;

class ResponseManager
{
    /**
     * @var Accept
     */
    protected $contentNegotiation;

    /**
     * The negotiated types.
     *
     * @var string
     */
    protected $useType = null;

    /**
     * The content type to use for the response.
     * @var string
     */
    protected $contentType;

    public function __construct(
        Accept $accept
    ) {
        $this->contentNegotiation = $accept;
    }

    protected function determineResponseType($accept)
    {
        $bestType = $this->contentNegotiation->negotiateMedia($accept);
        if ($bestType instanceof \Aura\Accept\Media\MediaValue) {
            $this->contentType = $bestType->getValue();
            $this->useType = $bestType->getSubtype();
            return;
        }

        throw new \Exception('The content type requested was not a valid response type');
    }

    public function execute(ResponderInterface $responder, PayloadInterface $data)
    {
        $validTypes = $responder->getValidContentTypes();
        $validKeys = array_keys($validTypes);
        $this->determineResponseType($validKeys);

        foreach($validKeys as $validKey)
        {
            if ($validKey == $this->contentType) {
                $func = $validTypes[$validKey];
                $result = call_user_func_array([$responder, $func], [$data]);
                return $this->sendResponse($result);
            }
        }

        // We should never get here but just in case...
        throw new \Exception('The content requested could not be found');
    }

    public function sendResponse(Response $response)
    {
        header($response->status->get(), true, $response->status->getCode());

        // send non-cookie headers
        foreach ($response->headers->get() as $label => $value) {
            header("{$label}: {$value}");
        }

        // send cookies
        foreach ($response->cookies->get() as $name => $cookie) {
            setcookie(
                $name,
                $cookie['value'],
                $cookie['expire'],
                $cookie['path'],
                $cookie['domain'],
                $cookie['secure'],
                $cookie['httponly']
            );
        }
        header('Connection: close');

        // send content
        print($response->content->get());
    }
}