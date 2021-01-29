<?php

namespace App\Form;

use App\Entity\Lieu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Image;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_lieu', TextType::class, [
                "label" => "Nom du lieu*",
                "constraints" => [
                    new Length([
                        "min" => 4,
                        "minMessage" => "Le nom du lieu doit comporter au moins 4 caractères",
                    ])
                ]
            ])
            ->add('adresse', TextType::class, [
                "label" => "Adresse*",
                "constraints" => [
                    new Length([
                        "min" => 4,
                        "minMessage" => "L'adresse doit comporter au moins 4 caractères",
                    ])
                ]
            ])
            ->add('prix', TextType::class, [
                "label" => "Prix*",
                "constraints" => [
                    new Length([
                        "min" => 2,
                        "minMessage" => "Le prix doit comporter au moins 2 caractères",
                    ])
                ]
            ])
            ->add('surface', TextType::class, [
                "label" => "Surface*",
                "constraints" => [
                    new Length([
                        "min" => 2,
                        "minMessage" => "La surface doit comporter au moins 2 caractères",
                    ])
                ]
            ])
            ->add('capacite', TextType::class, [
                "label" => "Capacité*",
                "constraints" => [
                    new Length([
                        "min" => 2,
                        "minMessage" => "La capacité doit comporter au moins 2 caractères",
                    ])
                ]
            ])
            ->add('type', ChoiceType::class, [
                "choices" => [
                    "Choisir un type" => "type",
                    "Loft" => "loft",
                    "Péniche" => "peniche",
                    "Terrasse" => "terrasse",
                    "Atypique" => "atypique"
                ],
                
            ])
            ->add('image', FileType::class, [
                "mapped" => false,
                "required" => false,
                "constraints" => [
                    new Image([
                        "mimeTypes" => ["image/png", "image/jpeg", "image/gif"],
                        "mimeTypesMessage" => "Vous ne pouvez téléchargé que des fichiers jpg, png ou gif",
                        "maxSize" => "2048k",
                        "maxSizeMessage" => "Le fichier ne doit pas dépasser 2Mo"
                    ])
                ]
            ])
            ->add('lesphotos', FileType::class,[
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add("enregistrer", SubmitType::class, [
                "attr" => [ 
                    "class" => "btn btn-primary"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
