<?php
namespace Via\Bundle\VariableProductBundle\Form\Type;

class OptionEntityChoiceType extends OptionChoiceType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'entity';
    }
}
