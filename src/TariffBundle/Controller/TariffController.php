<?php

namespace TariffBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use TariffBundle\Entity\Tariff;
use TariffBundle\Form\TariffType;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Tariff controller.
 *
 * @Route("/tariff")
 * @Security("has_role('ROLE_ADMIN')")
 */
class TariffController extends Controller {

    /**
     * Lists all Tariff entities.
     *
     * @Route("/", name="tariff_index")
     * @Method("GET")
     * @Template("TariffBundle:tariff:index.html.twig")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $tariffs = $em->getRepository('TariffBundle:Tariff')->findAll();

        return array(
            'tariffs' => $tariffs,
        );
    }

    /**
     * Creates a new Tariff entity.
     *
     * @Route("/new", name="tariff_new")
     * @Method({"GET", "POST"})
     * @Template("TariffBundle:tariff:new.html.twig")
     */
    public function newAction(Request $request) {
        $tariff = new Tariff();

//        $fc = new \TariffBundle\Entity\FeatureConcrete;
//        $f  = new \TariffBundle\Entity\Feature();
//        $f->setName("test ok");
//        $fc->setFeature($f);
//        $tariff->addFeature($fc);

        $form = $this->createForm(TariffType::class, $tariff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tariff);
            $em->flush();

            $this->addFlash('success', 'Успешно сохранено');
            return $this->redirectToRoute('tariff_show', array('id' => $tariff->getId()));
        }

        return array(
            'tariff' => $tariff,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Tariff entity.
     *
     * @Route("/{id}", name="tariff_show")
     * @Method("GET")
     * @Template("TariffBundle:tariff:show.html.twig")
     */
    public function showAction(Tariff $tariff) {
        $deleteForm = $this->createDeleteForm($tariff);

        return array(
            'tariff'      => $tariff,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Tariff entity.
     *
     * @Route("/{id}/edit", name="tariff_edit")
     * @Method({"GET", "POST"})
     * @Template("TariffBundle:tariff:edit.html.twig")
     */
    public function editAction(Request $request, Tariff $tariff) {
        $originalFeatures = new ArrayCollection();

        foreach ($tariff->getFeatures() as $f) {
            $originalFeatures->add($f);
        }

        $em         = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($tariff);
        $editForm   = $this->createForm(TariffType::class, $tariff);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /**
             * remove the relationship between the feature and the tariff
             * @link http://symfony.com/doc/2.8/cookbook/form/form_collections.html
             */
            foreach ($originalFeatures as $feature) {
                if (false === $tariff->getFeatures()->contains($feature)) {
                    $feature->setTariff(null);
                    $em->persist($feature);
                }
            }

            $em->persist($tariff);
            $em->flush();

            $this->addFlash('success', 'Успешно сохранено');
            return $this->redirectToRoute('tariff_edit', array('id' => $tariff->getId()));
        }

        return array(
            'tariff'      => $tariff,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Tariff entity.
     *
     * @Route("/{id}", name="tariff_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tariff $tariff) {
        $form = $this->createDeleteForm($tariff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tariff);
            
            $this->addFlash('success', 'Успешно удалено');
            $em->flush();
        }

        return $this->redirectToRoute('tariff_index');
    }

    /**
     * Creates a form to delete a Tariff entity.
     *
     * @param Tariff $tariff The Tariff entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tariff $tariff) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('tariff_delete', array('id' => $tariff->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
