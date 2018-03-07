<?php
namespace Acme\Bundle\UserBundle\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityRepository;

class RolesRepository extends EntityRepository
{
	public function loadRoles($id)
	{
		return $this->createQueryBuilder('r')
		->where('r.user_id = :user_id')
		->setParameter('user_id',$id)
		->getQuery()
		->getResult();
	}
}