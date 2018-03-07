<?php

namespace Acme\BlogBundle\Form;

use Acme\BlogBundle\Entity\MultiCategory;
use Acme\BlogBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Acme\BlogBundle\Controller\CategoryController;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Doctrine\Common\Collections\ArrayCollection;
use Acme\BlogBundle\Repository\CategoryRepository;

class CategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('multi_categories', CollectionType::class, array(
            'entry_type' => MultiCategoryType::class
        ))->add('parentId', EntityType::class, array(
		'class' => 'BlogBundle:Category',
		'query_builder' => function(\Doctrine\ORM\EntityRepository $repo) {
           $cats = $repo->createQueryBuilder('i')
           ->where('i.locale = :locale')
		   ->setParameter('locale','en');
		   //print_r($cats);die;
		return $cats;
                },
				//'data' => function(\Doctrine\ORM\EntityRepository $em){$em->getReference('BlogBundle:Category',4);},
				//'preferred_choices' => array(3),
				'choice_label' => 'cat_name'))->add('created');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\BlogBundle\Entity\Category'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'acme_blogbundle_category';
    }

}
