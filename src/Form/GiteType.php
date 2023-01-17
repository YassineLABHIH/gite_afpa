<?php

namespace App\Form;

use App\Entity\EquipementExt;
use App\Entity\EquipementInt;
use App\Entity\Gite;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GiteType extends AbstractType
{

    public function __construct(
        private readonly Security $security
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /**
         * @var User $current_user
         */
        $current_user = $this->security->getUser();


        $builder
            ->add('title')
            ->add('surface')
            ->add('nbrRoom')
            ->add('nbrBed')
            ->add('isAnimalAllowed')
            ->add('animalPrice')
            ->add('description')

            ->add('contact', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (UserRepository $er) use ($current_user) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.owner = :id_user')
                        ->setParameter('id_user', $current_user->getId());
                },
            ])
            ->add('equipementExts', EntityType::class, [
                'class' => EquipementExt::class,
                'expanded' => true,
                'multiple' => true
            ])
            ->add('EquipementInts', EntityType::class, [
                'class' => EquipementInt::class,
                'expanded' => true,
                'multiple' => true
            ])

            ->add('giteServices', CollectionType::class, [
                'entry_type' => GiteServiceType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gite::class,
        ]);
    }
}
