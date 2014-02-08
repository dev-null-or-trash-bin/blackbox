<?php
namespace Via\Bundle\CoreBundle\Entity;

interface ProductInterface
{
   
    /**
     * Gets product price.
     *
     * @return integer $price
     */
    public function getPrice();
    
    /**
     * Sets product price.
     *
     * @param float $price
    */
    public function setPrice($price);
    
    /**
     * Get product short description.
     *
     * @return string
    */
    public function getShortDescription();
    
    /**
     * Set product short description.
     *
     * @param string $shortDescription
    */
    public function setShortDescription($shortDescription);
    
    /**
     * Get all product images.
     *
     * @return Collection
     */
    public function getImages();
    
    /**
     * Get product main image.
     *
     * @return ImageInterface
    */
    public function getImage();

}