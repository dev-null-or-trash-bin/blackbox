<?php
namespace Via\Bundle\VariableProductBundle\Form\Type;

use Via\Bundle\VariableProductBundle\Entity\OptionInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Common\Util\Debug;

class OptionValueCollectionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!isset($options['options']) ||
            !is_array($options['options']) &&
            !($options['options'] instanceof \Traversable && $options['options'] instanceof \ArrayAccess)
        ) {
            throw new LogicException(
                'array or (\Traversable and \ArrayAccess) of "Via\Bundle\VariableProductBundle\Entity\OptionInterface" must be passed to collection'
            );
        }

        foreach ($options['options'] as $i => $option) {
            if (!$option instanceof Option) {
                throw new LogicException('Each object passed as option list must implement "Via\Bundle\VariableProductBundle\Entity\OptionInterface"');
            }

            $builder->add((string) $i, 'via_option_value_choice', array(
                'label'         => $option->getName(),
                'option'        => $option,
                'property_path' => '['.$i.']'
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'options' => null
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'via_option_value_collection';
    }
}
