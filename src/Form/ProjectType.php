<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\City;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'help' => 'Veuillez saisir un titre pour votre nouveau projet'
            ])
            ->add('excerpt', TextType::class, [
                'label' => 'Petit descriptif',
                'help' => 'Décrivez en une phrase votre projet'
            ])
            ->add('description', TextareaType::class,[
                'label' => 'Description',
                'help' => 'Décrivez votre projet plus en détail'
                ])

            ->add('pictureFile', FileType::class,[
                'label' => "Télécharger une photo",
                'mapped' => false,
                'required' => false,
               // 'constraints' => $imageConstraints
                ])
            ->add('cost', MoneyType::class, [
                'label' => 'Coût du projet',
                'help' => 'Saisissez l\'estimation du coût de votre projet'
            ])

            ->add('city', EntityType::class,[
                'label' => 'Ville',
                'class' => City::class,
                'choice_label' => 'name',
        ]   )
            ->add('categories', EntityType::class,[
                'label' => 'Catégorie',
                'class' => Category::class,
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
