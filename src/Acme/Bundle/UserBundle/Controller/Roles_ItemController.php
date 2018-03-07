<?php

namespace Acme\Bundle\UserBundle\Controller;

use Acme\Bundle\UserBundle\Entity\Roles_Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Roles_item controller.
 *
 * @Route("admin/roles_item")
 */
class Roles_ItemController extends Controller
{
    /**
     * Lists all roles_Item entities.
     *
     * @Route("/", name="roles_item_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $roles_Items = $em->getRepository('AcmeUserBundle:Roles_Item')->findAll();

        return $this->render('roles_item/index.html.twig', array(
            'roles_Items' => $roles_Items,
        ));
    }

    /**
     * Creates a new roles_Item entity.
     *
     * @Route("/new", name="roles_item_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $roles_Item = new Roles_item();
        $form = $this->createForm('Acme\Bundle\UserBundle\Form\Roles_ItemType', $roles_Item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($roles_Item);
            $em->flush();

            return $this->redirectToRoute('roles_item_show', array('id' => $roles_Item->getId()));
        }

        return $this->render('roles_item/new.html.twig', array(
            'roles_Item' => $roles_Item,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a roles_Item entity.
     *
     * @Route("/{id}", name="roles_item_show")
     * @Method("GET")
     */
    public function showAction(Roles_Item $roles_Item)
    {
        $deleteForm = $this->createDeleteForm($roles_Item);

        return $this->render('roles_item/show.html.twig', array(
            'roles_Item' => $roles_Item,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing roles_Item entity.
     *
     * @Route("/{id}/edit", name="roles_item_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Roles_Item $roles_Item)
    {
        $deleteForm = $this->createDeleteForm($roles_Item);
        $editForm = $this->createForm('Acme\Bundle\UserBundle\Form\Roles_ItemType', $roles_Item);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('roles_item_edit', array('id' => $roles_Item->getId()));
        }

        return $this->render('roles_item/edit.html.twig', array(
            'roles_Item' => $roles_Item,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a roles_Item entity.
     *
     * @Route("/{id}", name="roles_item_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Roles_Item $roles_Item)
    {
        $form = $this->createDeleteForm($roles_Item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($roles_Item);
            $em->flush();
        }

        return $this->redirectToRoute('roles_item_index');
    }

    /**
     * Creates a form to delete a roles_Item entity.
     *
     * @param Roles_Item $roles_Item The roles_Item entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Roles_Item $roles_Item)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('roles_item_delete', array('id' => $roles_Item->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
