<?php
namespace Acme\Bundle\UserBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Acme\BlogBundle\Entity\Language;

class GetLanguagesWidget
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getRecentLanguages()
    {
        $em = $this->getDoctrine()->getManager();
        $languages = $em->getRepository('BlogBundle:Language')->findAll();
		return $languages;
    }
}