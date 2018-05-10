<?php
namespace Acme\BlogBundle\Service;

use Acme\BlogBundle\Entity\Language;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Widget
{
    protected $container;
	protected $em;
	protected $token_storage;

    public function __construct(ContainerInterface $container,\Doctrine\ORM\EntityManager $em,\Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage $token_storage)
    {
        $this->container = $container;
		$this->em = $em;
		$this->token_storage = $token_storage;
    }

    public function getLanguages()
    {
       $languages = $this->em->getRepository('BlogBundle:Language')->findAll();
	   
	   return $languages;
    }
	public function getProfile()
	{
		$token = $this->token_storage->getToken()->getUser();
		if(!is_string($token)){
		$avatar = $this->em->getRepository('AcmeUserBundle:Profile')->find($token->getId());
		    return isset($avatar) ? $avatar->getAvatar() : null;
		}
		else
		{
			return null;
		}
	}
}