<?php
namespace Acme\Bundle\UserBundle\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
	public function loadUserByUsername($username)
	{
		return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
	}
	public function loadRoles($id)
	{
		return $this->createQueryBuilder('r')
		->Join('AcmeUserBundle:Roles','c')
		->where('c.user_id = :user_id')
		->setParameter('user_id',$id)
		->getQuery()
		->getResult();
	}
}