<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 8/26/17
 * Time: 9:01 AM
 */

namespace Masterclass\Responder;

use Aura\Payload_Interface\PayloadInterface;
use Aura\View\View;
use Aura\Web\Response;

class IndexResponder implements ResponderInterface
{
    /**
     * @var View
     */
    private $view;
    /**
     * @var Response
     */
    private $response;

    public function __construct(View $view, Response $response)
    {

        $this->view = $view;
        $this->response = $response;
    }

    public function getValidContentTypes()
    {
        return [
            'text/html' => 'getHtml',
            'application/json' => 'getJson',
        ];
    }

    public function getHtml(PayloadInterface $payload)
    {
        $stories = $payload->getOutput();

        $this->view->setData(['stories' => $stories]);
        $this->view->setLayout('layout');
        $this->view->setView('index');
        $this->response->content->set($this->view->__invoke());
        return $this->response;
    }

    public function getJson(PayloadInterface $payload)
    {
        $stories = $payload->getOutput();
        $storyArray = [];
        foreach ($stories as $story) {
            $storyArray[] = $story->toArray();
        }

        $this->response->content->set(json_encode($storyArray));
        return $this->response;
    }
}