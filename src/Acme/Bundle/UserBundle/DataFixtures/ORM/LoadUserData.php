<?php
namespace Acme\Bundle\UserBundle\DataFixtures\ORM;

use Acme\Bundle\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
	private $container;
	
	public function load(ObjectManager $manager)
	{
		$user = new User();
		//print_r($user);die;
		//$user->setUsername('admin');
		//$user->setEmail('taras2andry@mail.ru');
		//$encoder = $this->container->get('security.password_encoder');
		//$password = $encoder->encodePassword($user,'0000');
		//$user->setPassword($password);
		//$user->setPlainPassword($password);
		
		//$manager->persist($user);
		//$manager->flush();
	}
	
	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}
}