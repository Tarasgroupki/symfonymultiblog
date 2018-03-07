<?php
namespace Acme\Bundle\UserBundle\Form;

use Acme\Bundle\UserBundle\Entity\Roles_Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class Change_RolesType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('public', CheckboxType::class, array(
    'label' => '',
	'attr' => array('checked' => 'checked'),
	//'data' => 'lhkth',
    //'required' => false,
));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Roles_Item::class,
        ));
    }
}