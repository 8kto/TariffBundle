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
        $em      = $this->getDoctrine()->getManager();
        $tariffs = $em->getRepository('TariffBundle:Tariff')->findBy([
            'active' => true
        ]);


        return [
            'tariffs' => $tariffs
        ];
    }

    /**
     * TODO token со сроком годности
     * @Route("/success/{id}", name="show_success")
     * @Template("TariffBundle:Default:success.html.twig")
     */
    public function successAction($id) {
        return [
            'id' => $id
        ];
    }

}
