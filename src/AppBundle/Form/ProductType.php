<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/25/18
 * Time: 1:00 AM
 */

namespace AppBundle\Form;


use AppBundle\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (empty($options["currency"])) {
            throw new \UnexpectedValueException();
        }

        $builder
            ->add('name', null, ["label" => "app.form.product.name"])
            ->add('description', null, ["label" => "app.form.product.description"])
            ->add('price', MoneyType::class, ["label" => "app.form.product.price", "currency" => $options["currency"]])
            ->add('submit', SubmitType::class, ["label" => "app.form.product.submit"]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Product::class,
            "currency" => null
        ]);
    }
}