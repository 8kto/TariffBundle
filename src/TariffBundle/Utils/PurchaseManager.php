<?php

namespace TariffBundle\Utils;

/**
 * Класс-заглушка для операций с оплатой хостинга.
 *
 * @author Okto <web@axisful.info>
 */
class PurchaseManager {

    // Много кода

    const MERCHANT_ID = '88888888';
    const CAPTCHA_ID  = '77777777';

    /**
     * Попытаться провести оплату
     * 
     * @param str $sum
     * @param str $cartNum
     * @param str $cvv
     * @return boolean
     */
    public function doPay($sum, $cartNum, $cvv) {
        return true; // most stable method in the world
    }

}
