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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

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
            ->add('title', TextType::class, [
                'label' => "Nom du gite"
            ])
            ->add('surface')
            ->add('nbrRoom', NumberType::class, [
                'label' => 'Nombre de chambre'
            ])
            ->add('nbrBed', NumberType::class, [
                'label' => 'Nombre de lit'
            ])
            ->add('isAnimalAllowed')
            ->add('animalPrice')
            ->add('description')

            ->add('contact', EntityType::class, [
                'class' => User::class,
                'label' => 'Si vous ne voulez pas être contacté, veuillez choisir un contact déjà enregistré',
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
            
            ->add('photos', CollectionType::class, [
                'entry_type' => PhotoGiteType::class,
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
