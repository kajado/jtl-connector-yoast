<?php
namespace kajado\yoast;

use \jtl\Connector\Plugin\IPlugin;
use \Symfony\Component\EventDispatcher\EventDispatcher;
use \kajado\yoast\listener\ProductListener;
use \jtl\Connector\Event\Product\ProductAfterPushEvent;
use \jtl\Connector\Event\Product\ProductAfterPullEvent;

class Bootstrap implements IPlugin
{
    public function registerListener(EventDispatcher $dispatcher)
    {
        $dispatcher->addListener(ProductAfterPushEvent::EVENT_NAME, [
            new ProductListener(),
            'onProductAfterPushAction'
        ]);

        $dispatcher->addListener(ProductAfterPullEvent::EVENT_NAME, [
            new ProductListener(),
            'onProductAfterPullAction'
        ]);

    }


}