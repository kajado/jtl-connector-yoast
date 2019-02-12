<?php

namespace kajado\yoast\listener;

use \jtl\Connector\Event\Product\ProductAfterPushEvent;
use \jtl\Connector\Event\Product\ProductAfterPullEvent;
use \jtl\Connector\Core\Logger\Logger;
use \jtl\Connector\Formatter\ExceptionFormatter;
use \jtl\Connector\Core\Utilities\Language as LanguageUtil;

class ProductListener
{
    public function onProductAfterPushAction(ProductAfterPushEvent $event)
    {

        if (strlen($event->getProduct()->getId()->getEndpoint()) == 0) {
            return;
        }

        try {
            foreach ($event->getProduct()->getI18ns() as $i18n) {

                $kjd_product_id = $i18n->getProductId()->getEndpoint();
                $kjd_product_meta_description = $i18n->getMetaDescription();
                $kjd_product_meta_title = $i18n->getTitleTag();

                update_post_meta($kjd_product_id, '_yoast_wpseo_title', $kjd_product_meta_title);
                update_post_meta($kjd_product_id, '_yoast_wpseo_metadesc', $kjd_product_meta_description);


            }

        } catch (\Exception $e) {
            Logger::write(ExceptionFormatter::format($e), Logger::WARNING, 'plugin');
        }
    }

    public function onProductAfterPullAction(ProductAfterPullEvent $event)
    {

        if (strlen($event->getProduct()->getId()->getEndpoint()) == 0) {
            return;
        }

        try {

            foreach ($event->getProduct()->getI18ns() as $i18n) {

                $kjd_product_id = $i18n->getProductId()->getEndpoint();
                $kjd_product_meta_description = get_post_meta($kjd_product_id, '_yoast_wpseo_metadesc',true);
                $kjd_product_meta_title = get_post_meta($kjd_product_id, '_yoast_wpseo_title',true);
                $i18n->setMetaDescription($kjd_product_meta_description);
                $i18n->setTitleTag($kjd_product_meta_title);

            }

        } catch (\Exception $e) {
            Logger::write(ExceptionFormatter::format($e), Logger::WARNING, 'plugin');
        }
    }
}