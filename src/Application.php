<?php

namespace Cblink\FeiShu;

use Pimple\Container;
use ZhenMu\Support\Http\AbstractRequestClient;
use ZhenMu\Support\Traits\PimpleApplicationTrait;

/**
 * Class Application
 * @package Cblink\FeiShu
 *
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
        AccessToken\AccessTokenServiceProvider::class,
        Message\MessageServiceProvider::class,
        Contact\ContactServiceProvider::class,
        WebhookBot\WebhookBotServiceProvider::class,
        Bot\BotServiceProvider::class,
    ];

    public function __construct(array $config = [], array $values = [])
    {
        parent::__construct($values);

        $this['config'] = $config;

        $this->registerProviders();
    }

    public function setHttpClientAccessToken(\ZhenMu\Support\Contracts\AccessToken $accessToken)
    {
        AbstractRequestClient::$accessToken = $accessToken;
    }

    public function getHttpClientAccessToken()
    {
        return AbstractRequestClient::$accessToken;
    }
}