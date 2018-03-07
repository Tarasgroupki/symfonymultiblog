<?php

namespace Acme\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
	public function findAllCategories()
	{
		$categories = $this->getEntityManager()
		->createQuery('SELECT p FROM BlogBundle:Category p WHERE p.locale = "en"')
		->getResult();
		foreach($categories as $key => $category)
		{
			$cats[$category->getCatName()] = $category->getCat_id(); 
		}
		return $cats;
	}
}