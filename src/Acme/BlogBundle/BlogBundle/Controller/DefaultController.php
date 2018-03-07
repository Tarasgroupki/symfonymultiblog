<?php

namespace Acme\BlogBundle\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Acme\BlogBundle\Entity\Language;
use Acme\Bundle\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction($_locale = 'en')
    {
		/*$em = $this->getDoctrine()->getManager();
        $languages = $em->getRepository('BlogBundle:Language')->findAll();
        $categories = $em->getRepository('BlogBundle:Category')->findByLocale($_locale);
		if($this->getUser()){
		$avatar = $em->getRepository('AcmeUserBundle:Profile')->find($this->getUser()->getId());
		}
		$blogs = $em->getRepository('BlogBundle:Blog')->findByLocale($_locale);
        if($this->getUser()):
		$tokenStorage = $this->get('security.token_storage');
		$user = $tokenStorage->getToken()->getUser();
		foreach($this->getRoles() as $key => $obj)
		{
			$arr[$key] = $obj->getItemName();
		}
		  $token = new UsernamePasswordToken(
          $user,
          null,
          'main',
          $arr
        ); 
		$this->get('security.token_storage')->setToken($token);
		endif;
		return $this->render('BlogBundle:Default:index.html.twig',
		[
		   'languages' => $languages,
		   'blogs' => $blogs,
		   'categories' => $categories,
		   'avatar' => (isset($avatar)) ? $avatar->getAvatar() : null
		]);*/
		return $this->redirect('/symfony/web/app_dev.php/en');
    }
	   public function showAction(Blog $blog)
    {
		return $this->render('BlogBundle:Default:show.html.twig', array(
            'blog' => $blog,
        ));
    }
	public function numberAction($id)
	{
		return $this->render('BlogBundle:Default:number.html.twig',
		[
		  'id' => $id
		]
		);
	}
	private function getRoles()
	  {
		  $em = $this->getDoctrine()->getManager();
		  return $em->getRepository('AcmeUserBundle:Roles')->findByUserId($this->getUser()->getId());
	  }
	public function helloAction()
	{
		return $this->render('BlogBundle::base.html.twig');
	}
}
