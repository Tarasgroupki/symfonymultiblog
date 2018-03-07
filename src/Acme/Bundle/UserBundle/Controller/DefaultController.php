<?php

namespace Acme\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\Bundle\UserBundle\Form\UserType;
use Acme\Bundle\UserBundle\Form\ProfileType;
use Acme\Bundle\UserBundle\Form\Change_RolesType;
use Acme\Bundle\UserBundle\Form\Roles_ItemType;
use Acme\Bundle\UserBundle\Entity\Profile;
use Acme\Bundle\UserBundle\Entity\Roles;
use Acme\Bundle\UserBundle\Entity\Roles_Item;
use Acme\Bundle\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Acme\BlogBundle\Entity\Language;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Acme\Bundle\UserBundle\Repository;
use Acme\Bundle\UserBundle\Entity\UploadFile;
use Acme\Bundle\UserBundle\FileManager;
use Acme\Bundle\UserBundle\Model\FileUploadModel;

class DefaultController extends Controller
{
	
    public function indexAction()
    {
		$em = $this->getDoctrine()->getManager();
		$users = $em->getRepository('AcmeUserBundle:User')->findAll();
        return $this->render('AcmeUserBundle:Default:index.html.twig',['users' => $users]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function loginAction(Request $request)
	{//print_r($request);die;	     
		$em = $this->getDoctrine()->getManager();
		//print_r($this->getRoles());
        $languages = $em->getRepository('BlogBundle:Language')->findAll();
		$authUtils = $this->get("security.authentication_utils");
		$errors = $authUtils->getLastAuthenticationError();
		$lastUserName = $authUtils->getLastUsername();
		return $this->render('AcmeUserBundle:Default:login.html.twig',array('languages' => $languages,'errors' => $errors,'username' => $lastUserName));
	}
	public function logoutAction()
	{
		
	}
    public function registerAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
        $languages = $em->getRepository('BlogBundle:Language')->findAll();
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
//echo $user->getPlainPassword();
            // 3) Encode the password (you could also do this via Doctrine listener)
            $encoder = $this->container->get('security.password_encoder');
			$password = $encoder->encodePassword($user,$user->getPlainPassword());
			//$password = md5($user->getPlainPassword());
            $user->setPassword($password);
//print_r($password);die;
            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('acme_user_homepage');
        }

        return $this->render(
            'AcmeUserBundle:Default:register.html.twig',
            array('form' => $form->createView(),'languages' => $languages,'avatar' => null)
        );
    }
	public function profileAction(Request $request)
	{
		//$getLanguagesWidget = $this->get('getLanguagesWidget');
		//print_r($getLanguagesWidget);die;
		$em = $this->getDoctrine()->getManager();
        $languages = $em->getRepository('BlogBundle:Language')->findAll();
		$profile = new Profile();
		$profile_data = $em->getRepository('AcmeUserBundle:Profile')
		->find($this->getUser()->getId());
		if($profile_data){
		$profile->setFirstName($profile_data->getFirstName());
		$profile->setSecondName($profile_data->getSecondName());
		$profile->setBirthday($profile_data->getBirthday());
		}
		$form = $this->createForm(ProfileType::class, $profile);	
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {	
		$profile->setUserId($this->getUser()->getId());
			$uploadedFile = $profile->getFile();
			if($uploadedFile){
			$fileName = md5(uniqid()).'.'.$uploadedFile->guessExtension();
			$profile->setAvatar('/symfony/web/images/'.$fileName);
			$profile->getFile()->move('X:\home/symfony.ua/www/symfony/web/images/',$fileName);
			if($profile_data){
			$em->createQueryBuilder()->update('AcmeUserBundle:Profile', 'c')
			->set('c.avatar', ':avatar')->where('c.user_id = :id')
			->setParameter('avatar',$profile->getAvatar())
			->setParameter('id',$this->getUser()->getId())
			->getQuery()->execute();
			}}
			if(!$profile_data){
            $em->persist($profile);
            $em->flush();
			}
			else
			{
			$em->createQueryBuilder()->update('AcmeUserBundle:Profile', 'c')
			->set('c.first_name', ':first_name')
			->set('c.second_name', ':second_name')
			->set('c.birthday', ':birthday')
			->where('c.user_id = :id')
			->setParameter('first_name',$profile->getFirstName())
			->setParameter('second_name',$profile->getSecondName())
			->setParameter('birthday',$profile->getBirthday())
			->setParameter('id',$this->getUser()->getId())
			->getQuery()->execute();
			}
		}
		return $this->render(
		     'AcmeUserBundle:Default:profile.html.twig',
			 array('languages' => $languages,'form' => $form->createView(),'avatar' => ($profile_data) ? $profile_data->getAvatar() : null)
		);
	}
	public function AddRolesAction(Request $request,$id)
	{
    $em = $this->getDoctrine()->getManager();	
	$addrole = $em->getRepository('AcmeUserBundle:Roles_Item')->findAll();	
	$checked_roles = $em->getRepository('AcmeUserBundle:Roles')->findByUserId($id);	
	if ($request->get('subscribe')) {//print_r($request->get('subscribe'));die;
		$qb = $this->getDoctrine()->getEntityManager()->getConnection();   
	    //print_r($addrole);
		$croles = $request->get('subscribe');
		//foreach($request->get('subscribe') as $key => $subscribe):
		foreach($addrole as $key => $value):
		echo $key;
		if(!isset($checked_roles[$key]) || isset($croles[$key])):
		echo $croles[$key];
		//if(((isset($checked_roles[$key])) ? $checked_roles[$key]->getItemName() : null) != $subscribe):
		if(!isset($checked_roles[$key])):
		$query = $qb->insert('roles',array('id' => '','item_name' => $croles[$key],'user_id' => $id,'created' => date('Y-m-d')));
	    endif;
		elseif(isset($checked_roles[$key])): echo $checked_roles[$key]->getItemName();//die;
		$em->createQueryBuilder()->delete('AcmeUserBundle:Roles','b')
		->where('b.item_name = :item_name')
		->setParameter('item_name',$checked_roles[$key]->getItemName())
		->getQuery()->execute();
		endif;
		endforeach;
	}
	$checked_roles = $em->getRepository('AcmeUserBundle:Roles')->findByUserId($id);
	return $this->render('AcmeUserBundle:Default:addroles.html.twig',['addrole' => $addrole,'checked_roles' => ($checked_roles) ? $checked_roles : null]);		
	}
	/*private function getRoles()
	  {
		  $em = $this->getDoctrine()->getManager();
		  return $em->getRepository('AcmeUserBundle:Roles')->findByUserId($this->getUser()->getId());
	  }*/
}
