<?php

namespace TariffBundle\Utils;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PostPurchaseManager {
    // Много кода

    /**
     * 
     * @param int $userId
     * @param Tariff $tariff
     */
    public function prepareToHosting($userId, \TariffBundle\Entity\Tariff $tariff) {
        // prepare space and filesystem
        // send emails
        // create important msgs to logs
    }

}
