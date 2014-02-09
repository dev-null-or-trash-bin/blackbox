<?php
namespace Via\Bundle\ProductBundle\Entity;

use Gedmo\Translatable\Translatable;

interface ProductInterface extends Translatable
{
    public function getId();
    
    public function __toString();
}