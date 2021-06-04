<?php

namespace Cblink\FeiShu;

use Pimple\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use ZhenMu\Support\Traits\PimpleApplicationTrait;

/**
 * Class Application
 * @package Cblink\FeiShu
 *
 * @property-read array $config
 * @property-read Encryptor $encryptor
 * @property-read EventDispatcher $event
 * @property-read Request $request
 * @property-read ServerGuard $serve
 * @property-read AccessToken\AppAccessToken $app_access_token
 * @property-read AccessToken\AppTenantAccessToken $app_tenant_access_token
 * @property-read Message\Message $message
 * @property-read Contact\User $user
 * @property-read Contact\Department $department
 * @property-read WebhookBot\WebhookBot $webhook_bot
 * @property-read Bot\Bot $bot
 */
class Application extends Container
{
    use PimpleApplicationTrait;

    protected $providers = [
        Providers\EventDispatcherServiceProvider::class,
        Providers\RequestServiceProvider::class,
        Serve\ServeServiceProvider::class,
        AccessToken\AccessTokenServiceProvider::class,
        Message\MessageServiceProvider::class,
        Contact\ContactServiceProvider::class,
        WebhookBot\WebhookBotServiceProvider::class,
        Bot\BotServiceProvider::class,
    ];

    protected $accessToken = null;

    public function __construct(array $config = [], array $values = [])
    {
        parent::__construct($values);

        $this['config'] = $config;

        $this->registerProviders();
    }

    public function setHttpClientAccessToken(\ZhenMu\Support\Contracts\AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function getHttpClientAccessToken()
    {
        return $this->accessToken;
    }
}