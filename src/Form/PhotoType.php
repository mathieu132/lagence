<?php

namespace App\Form;

use App\Entity\Photo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Lieu;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lesphotos', FileType::class,[
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('lieu', EntityType::class, [
                "class" => Lieu::class,
                "choice_label" => function (Lieu $lieu){
                    return $lieu->getNomLieu() . " - " . $lieu->getType();
                },
                "placeholder" => ""
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
            'data_class' => Photo::class,
        ]);
    }
}
