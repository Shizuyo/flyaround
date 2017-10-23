<?php

namespace WCS\flyReservationBundle\Controller;

use WCS\flyReservationBundle\Entity\Terrain;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Terrain controller.
 *
 * @Route("terrain")
 */
class TerrainController extends Controller
{
    /**
     * Lists all terrain entities.
     *
     * @Route("/", name="terrain_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $terrains = $em->getRepository('WCSflyReservationBundle:Terrain')->findAll();

        return $this->render('terrain/index.html.twig', array(
            'terrains' => $terrains,
        ));
    }

    /**
     * Creates a new terrain entity.
     *
     * @Route("/new", name="terrain_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $terrain = new Terrain();
        $form = $this->createForm('WCS\flyReservationBundle\Form\TerrainType', $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($terrain);
            $em->flush();

            return $this->redirectToRoute('terrain_show', array('id' => $terrain->getId()));
        }

        return $this->render('terrain/new.html.twig', array(
            'terrain' => $terrain,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a terrain entity.
     *
     * @Route("/{id}", name="terrain_show")
     * @Method("GET")
     */
    public function showAction(Terrain $terrain)
    {
        $deleteForm = $this->createDeleteForm($terrain);

        return $this->render('terrain/show.html.twig', array(
            'terrain' => $terrain,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing terrain entity.
     *
     * @Route("/{id}/edit", name="terrain_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Terrain $terrain)
    {
        $deleteForm = $this->createDeleteForm($terrain);
        $editForm = $this->createForm('WCS\flyReservationBundle\Form\TerrainType', $terrain);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('terrain_edit', array('id' => $terrain->getId()));
        }

        return $this->render('terrain/edit.html.twig', array(
            'terrain' => $terrain,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a terrain entity.
     *
     * @Route("/{id}", name="terrain_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Terrain $terrain)
    {
        $form = $this->createDeleteForm($terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($terrain);
            $em->flush();
        }

        return $this->redirectToRoute('terrain_index');
    }

    /**
     * Creates a form to delete a terrain entity.
     *
     * @param Terrain $terrain The terrain entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Terrain $terrain)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('terrain_delete', array('id' => $terrain->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
