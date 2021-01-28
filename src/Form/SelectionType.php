<?php

namespace App\Form;

use App\Entity\Selection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Abonne, App\Entity\Lieu;

class SelectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_debut', DateType::class, [
                "widget"=>"single_text",
                "label" => "Début le"
            ])
            ->add('date_fin', DateType::class, [
                "widget" => "single_text",
                "label" => "Fin le",
                "required" => false
            ])
            ->add('lieu', EntityType::class, [
                "class" => Lieu::class,
                "choice_label" => function (Lieu $lieu){
                    return $lieu->getNomLieu() . " - " . $lieu->getPrix(). " € ";
                },
                "placeholder" => ""
            ])
            ->add('abonne', EntityType::class, [
                "class" => Abonne::class,
                "choice_label" => function (Abonne $abonne){
                    return $abonne->getNom() . " - " . $abonne->getPrenom();
                },
                "placeholder" => "" 
            ])
        
            ->add("enregistrer", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Selection::class,
        ]);
    }

    
}
