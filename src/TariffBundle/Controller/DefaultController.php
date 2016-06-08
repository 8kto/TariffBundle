<?php

namespace TariffBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller {

    /**
     * @Route("/", name="index")
     * @Template("TariffBundle:Default:page_index.html.twig")
     */
    public function indexAction() {
//        $user     = $this->getUser();
//        $timezone = $user->getTimezone();
//        date_default_timezone_set($timezone);
//
//        return [
//            'timezone' => $timezone,
//        ];
        return [];
    }

}
