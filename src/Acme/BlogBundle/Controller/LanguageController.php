<?php

namespace Acme\BlogBundle\Controller;

use Acme\BlogBundle\Entity\Language;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Language controller.
 *
 * @Route("language")
 */
class LanguageController extends Controller
{
    /**
     * Lists all language entities.
     *
     * @Route("/index", name="language_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $languages = $em->getRepository('BlogBundle:Language')->findAll();
        return $this->render('language/index.html.twig', array(
            'languages' => $languages,
        ));
    }

    /**
     * Creates a new language entity.
     *
     * @Route("/new", name="language_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $language = new Language();
		
        $form = $this->createForm('Acme\BlogBundle\Form\LanguageType', $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			$language->setLocale(strtolower($language->getLangSymbol()));
            //print_r($language);die;
			$em = $this->getDoctrine()->getManager();
            $em->persist($language);
            $em->flush();

            return $this->redirectToRoute('language_show', array('lang_id' => $language->getLang_id()));
        }

        return $this->render('language/new.html.twig', array(
            'language' => $language,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a language entity.
     *
     * @Route("/{lang_id}", name="language_show")
     * @Method("GET")
     */
    public function showAction(Language $language)
    {
        $deleteForm = $this->createDeleteForm($language);

        return $this->render('language/show.html.twig', array(
            'language' => $language,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing language entity.
     *
     * @Route("/{lang_id}/edit", name="language_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Language $language)
    {
        $deleteForm = $this->createDeleteForm($language);
        $editForm = $this->createForm('Acme\BlogBundle\Form\LanguageType', $language);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('language_edit', array('lang_id' => $language->getLang_id()));
        }

        return $this->render('language/edit.html.twig', array(
            'language' => $language,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a language entity.
     *
     * @Route("/{lang_id}", name="language_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Language $language)
    {
        $form = $this->createDeleteForm($language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($language);
            $em->flush();
        }

        return $this->redirectToRoute('language_index');
    }

    /**
     * Creates a form to delete a language entity.
     *
     * @param Language $language The language entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Language $language)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('language_delete', array('lang_id' => $language->getLang_id())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
