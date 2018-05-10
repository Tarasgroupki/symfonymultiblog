<?php

namespace ChatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ChatBundle\Form\MessagesType;
use ChatBundle\Entity\Messages;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/",name="chat")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->createQueryBuilder()->select('m')
                ->from('AcmeUserBundle:User', 'm')
                ->where('m.id != :id')
        ->setParameter('id', $this->getUser()->getId())->getQuery()->execute();
        return $this->render('ChatBundle:Default:index.html.twig',['users' => $users]);
    }
    /**
     * @Route("/{id}", requirements={"id" = "\d+"}, name="chat_index")
     */
    public function DialogAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $from = $this->getUser();
        $whom = $em->getRepository('AcmeUserBundle:User')->findById($id)[0];
        $fromAvatar = $em->getRepository("AcmeUserBundle:Profile")->findByUserId($from->getId())[0]->getAvatar();
        $whomAvatar = $em->getRepository("AcmeUserBundle:Profile")->findByUserId($whom->getId())[0]->getAvatar();
        $messages = $qb->select('m')
            ->from('ChatBundle:Messages', 'm')
            ->where($qb->expr()->andX(
                $qb->expr()->eq('m.from_id', '?1'),
                $qb->expr()->eq('m.whom_id', '?2')
            ))
            ->orwhere($qb->expr()->andX(
                $qb->expr()->eq('m.from_id', '?2'),
                $qb->expr()->eq('m.whom_id', '?1')
            ))
            ->setParameters([1 => $from->getId(), 2 => $whom->getId()])->getQuery()->execute();
       // print_r($messages);die;
        $message = new Messages();
        $form = $this->createForm(MessagesType::class, $message);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message->setFromId($from->getId());
            $message->setWhomId($whom->getId());
           // print_r($messages);die;
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            return $this->redirect($this->generateUrl('chat_index',['id' => $id]));
        }
       // $referer = $request->headers->get('referer');
        return  $this->render('ChatBundle:Default:dialog.html.twig',['form' => $form->createView(),'whom' => $whom,'from' => $from,'messages' => $messages,'fromAvatar' => $fromAvatar, 'whomAvatar' => $whomAvatar]);
    }
    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"}, name="chat_delete")
     */
    public function deleteAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->createQueryBuilder()->update('ChatBundle:Messages', 'c')
            ->set('c.IsDeleteFrom', ':id')
            ->where('c.id = :id')->setParameter('id',$id)->getQuery()->execute();
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }
}
