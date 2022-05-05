<?php

namespace App\Form;

use App\Entity\Hobbie;
use App\Entity\Personne;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('age')
            ->add('firstname')
            ->add('profil')
            ->add('hobbie',EntityType::class,[
                'expanded'=>true,
            'class'=>Hobbie::class,
                'multiple'=>true,
                'query_builder'=>function(EntityRepository $er){
                return $er->createQueryBuilder('h')->orderBy('h.deseniation','DESC');
                },
                'choice_label'=>'deseniation',

            ])
            ->add('editer',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
