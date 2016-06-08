<?php

namespace TariffBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use TariffBundle\Entity\Order;
use TariffBundle\Entity\Tariff;
use Symfony\Component\HttpFoundation\Request;
use TariffBundle\Utils\PurchaseManager;
use \TariffBundle\Utils\PostPurchaseManager;

/**
 * Order controller.
 * 
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/order")
 */
class OrderController extends Controller {

    /**
     * Lists all Order entities.
     *
     * @Route("/", name="order_index")
     * @Template("TariffBundle:order:index.html.twig")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $orders = $em->getRepository('TariffBundle:Order')->findAll();

        return array(
            'orders' => $orders,
        );
    }

    /**
     * Finds and displays a Order entity.
     *
     * @Route("/{id}", name="order_show")
     * @Template("TariffBundle:order:show.html.twig")
     * @Method("GET")
     */
    public function showAction(Order $order) {

        return array(
            'order' => $order,
        );
    }

    /**
     * Finds and displays a Order entity.
     *
     * @Route("/makenew/{id}", name="make_order")
     * @Template("TariffBundle:order:new.html.twig")
     * @ParamConverter("tariff", class="TariffBundle:Tariff")
     * @Security("has_role('ROLE_USER')")
     */
    public function makeOrder(Tariff $tariff, Request $request) {
        $order = new Order();
        $user  = $this->getUser();

        $form = $this->createForm(\TariffBundle\Form\OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pm      = new PurchaseManager;
            $ppm     = new PostPurchaseManager;
            $cardNum = $request->request->get('p_code_cart', null);
            $ccv     = $request->request->get('p_code_ccv', null);

            // great jobs should be done here

            if (!$pm->doPay($tariff->getPrice(), $cardNum, $ccv)) {
                // Оплата не прошла
                throw new \Exception('Ошибка оплаты');
            }
            $order->setPaid(true);
            $order->setStartDate(new \DateTime);
            $order->setEndDate(new \DateTime('+1 year'));
            $order->setTariff($tariff);
            $order->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

            $ppm->prepareToHosting($user->getId(), $tariff);

            $this->addFlash('success', 'Успешно сохранено');
            return $this->redirectToRoute('show_success', array('id' => $order->getId()));
        }

        return array(
            'order'  => $order,
            'tariff' => $tariff,
            'form'   => $form->createView(),
        );
    }

}
