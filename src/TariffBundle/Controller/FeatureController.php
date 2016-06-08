<?php

namespace TariffBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use TariffBundle\Entity\Feature;
use TariffBundle\Form\FeatureType;

/**
 * Feature controller.
 *
 * @Route("/feature")
 * @Security("has_role('ROLE_ADMIN')")
 */
class FeatureController extends Controller {

    /**
     * Lists all Feature entities.
     *
     * @Route("/", name="feature_index")
     * @Method("GET")
     * @Template("TariffBundle:feature:index.html.twig")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $features = $em->getRepository('TariffBundle:Feature')->findAll();

        return array(
            'features' => $features,
        );
    }

    /**
     * Creates a new Feature entity.
     *
     * @Route("/new", name="feature_new")
     * @Method({"GET", "POST"})
     * @Template("TariffBundle:feature:new.html.twig")
     */
    public function newAction(Request $request) {
        $feature = new Feature();
        $form    = $this->createForm(FeatureType::class, $feature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($feature);
            $em->flush();

            return $this->redirectToRoute('feature_show', array('id' => $feature->getId()));
        }

        return array(
            'feature' => $feature,
            'form'    => $form->createView(),
        );
    }

    /**
     * Finds and displays a Feature entity.
     *
     * @Route("/{id}", name="feature_show")
     * @Method("GET")
     * @Template("TariffBundle:feature:show.html.twig")
     */
    public function showAction(Feature $feature) {
        $deleteForm = $this->createDeleteForm($feature);

        return array(
            'feature'     => $feature,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Feature entity.
     *
     * @Route("/{id}/edit", name="feature_edit")
     * @Method({"GET", "POST"})
     * @Template("TariffBundle:feature:edit.html.twig")
     */
    public function editAction(Request $request, Feature $feature) {
        $deleteForm = $this->createDeleteForm($feature);
        $editForm   = $this->createForm(FeatureType::class, $feature);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($feature);
            $em->flush();

            return $this->redirectToRoute('feature_index');
        }

        return array(
            'feature'     => $feature,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Feature entity.
     *
     * @Route("/{id}", name="feature_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Feature $feature) {
        $form = $this->createDeleteForm($feature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($feature);
            $em->flush();
        }

        return $this->redirectToRoute('feature_index');
    }

    /**
     * Creates a form to delete a Feature entity.
     *
     * @param Feature $feature The Feature entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Feature $feature) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('feature_delete', array('id' => $feature->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
