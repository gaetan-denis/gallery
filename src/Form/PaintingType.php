<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Painting;
use App\Entity\Technical;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaintingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre de l\'oeuvre'
            ])
            ->add('description', TextareaType::class, [

            ])
            ->add('creation', IntegerType::class, [

            ])
            ->add('hauteur', IntegerType::class, [

            ])
            ->add('largeur', IntegerType::class, [

            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name'
            ])
            ->add('technical', EntityType::class, [
                'class' => Technical::class,
                'choice_label' => 'name'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Éditez l\'oeuvre'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Painting::class,
        ]);
    }
}
