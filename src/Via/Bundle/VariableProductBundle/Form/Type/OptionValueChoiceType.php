<?php
namespace Via\Bundle\VariableProductBundle\Form\Type;

use Via\Bundle\VariableProductBundle\Entity\OptionInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ObjectChoiceList;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;


class OptionValueChoiceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $choiceList = function (Options $options) {
            return new ObjectChoiceList($options['option']->getValues(), 'value', array(), null, null, PropertyAccess::createPropertyAccessor());
        };

        $resolver
            ->setDefaults(array(
                'choice_list' => $choiceList
            ))
            ->setRequired(array(
                'option'
            ))
            ->addAllowedTypes(array(
                'option' => 'Via\Bundle\VariableProductBundle\Entity\OptionInterface'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'via_option_value_choice';
    }
}
