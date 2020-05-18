<?php

namespace App\Form;

use App\Entity\City;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;

class CityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        /** @var City|null $city */
        $city = $options['data'] ?? null;
        $isEdit = $city && $city->getId();

        $builder
            ->add('name');

        $imageConstraints = [
            new Image([
                'maxSize' => '5M'
            ])
        ];
        //ne contraindre à mettre photo que si new, pas dans edit
        if (!$isEdit || !$city->getPicture()) {
            $imageConstraints[] = new NotNull([
                'message' => 'Veuillez télécharger une image',
            ]);
        }

        $builder
            ->add('pictureFile', FileType::class,[
                'label' => "Télécharger une photo",
                'mapped' => false,
                'required' => false,
                'constraints' => $imageConstraints
        ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => City::class,
        ]);
    }
}
