<?php

namespace Cblink\FeiShu;

use Cblink\FeiShu\Exceptions\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ServerGuard
{
    protected $app;

    protected $alwaysValidate = false;

    /**
     * ServerGuard constructor.
     * @param $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function serve()
    {
        $response = $this->validate()->resolve();

        return $response;
    }

    public function validate()
    {
        if (!$this->alwaysValidate && !$this->isSafeMode()) {
            return $this;
        }

        if ($this->isSafeMode()) {
            $data = $this->getMessage();
            if ($data['token'] !== $this->app['config']['event_verification_token']) {
                throw new BadRequestException('Invalid request signature.', 400);
            }
        }

        return $this;
    }

    protected function resolve(): Response
    {
        $result = $this->handleRequest();

        $response = new JsonResponse($result ?? []);

        return $response;
    }

    protected function handleRequest()
    {
        $messageArray = $this->getMessage();

        switch ($messageArray['type']) {
            case 'url_verification':
                return $this->handleUrlVerification($messageArray);
            case 'event_callback':
                return $this->handleEventCallback($messageArray);
            default:
                throw new BadRequestException('unknown message type '. $messageArray['type']);
        }
    }

    public function handleUrlVerification(array $message)
    {
        return [
            'challenge' => $message['challenge'],
        ];
    }

    public function handleEventCallback(array $message)
    {
        $event = $message['event'];
        $eventType = $event['type'];
//        $metadata = new EventMetadata($json->ts, $json->uuid, $eventType);
//        $this->eventHub->{$eventType}($metadata, $event);
        dd($message);
        $this->app['events']->dispatch();
        return [
            'msg' => 'success',
        ];
    }
    
    public function forceValidate()
    {
        $this->alwaysValidate = true;

        return $this;
    }

    protected function isSafeMode(): bool
    {
        return !empty($this->app['request']->request->all()['encrypt']);
    }

    protected function getMessage()
    {
        if (!$this->isSafeMode()) {
            $data = $this->app['request']->request->all();
        } else {
            $message = $this->decryptMessage($this->app['request']->request->all()['encrypt']);
            $data = json_decode($message, true);
        }

        if (!is_array($data) || empty($data)) {
            throw new BadRequestException('No message received.');
        }

        return $data;
    }

    protected function decryptMessage(string $message)
    {
        return $this->app['encryptor']->decryptString(
            $message,
        );
    }
}