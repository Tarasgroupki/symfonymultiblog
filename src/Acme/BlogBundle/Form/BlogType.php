<?php

namespace Acme\BlogBundle\Form;

//use Acme\BlogBundle\Entity\Blog;
use Acme\BlogBundle\Entity\Title;
use Acme\BlogBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
//use Symfony\Bridge\Doctrine\Form\Type\EntityType

class BlogType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {//$em = new EntityManager;
        $builder/*->add('titles'
	//	array(
    //       'entry_type' => static::class,
  //          'entry_options' => array('label' => false),
 // )
  )*/->add('titles', CollectionType::class, array(
            'entry_type' => TitleType::class
        ))
		->add('categoryId', EntityType::class, array(
		'class' => 'BlogBundle:Category',
		'query_builder' => function(\Doctrine\ORM\EntityRepository $repo) {
           $cats = $repo->createQueryBuilder('i')
           ->where('i.locale = :locale')
		   ->setParameter('locale','en')
		   ->orderBy('i.cat_name', 'ASC');
		return $cats;
                },
               // 'data' => $em->getReference("AcmeBlogBundle:Category", 3),
				'choice_label' => 'cat_name',
				'choice_value' => 'category_id'))->add('created');
  
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\BlogBundle\Entity\Blog'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'acme_blogbundle_blog';
    }


}
