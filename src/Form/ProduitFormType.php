<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProduitFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'empty_data' => '',
            ])
            ->add('prix', TextType::class,[
                'empty_data' => '',
            ])
            ->add('qte',NumberType::class,[
                'empty_data' => '',
            ])
            //pour un champ selecteur on peut selectionner les datas de la base
            //en passant par l' entité
            ->add('category',EntityType::class,[
                'placeholder' => 'selectionner une categorie',
                'empty_data' => '',
                'label' => 'catégorie',
                'class' => Category::class,
                'choice_label' => 'libelle',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class
        ]);
    }
}
