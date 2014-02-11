<?php
namespace Via\Bundle\VariableProductBundle\Generator;

use Doctrine\Common\Persistence\ObjectRepository;
use Via\Bundle\ProductBundle\Entity\ProductInterface;
use Symfony\Component\Validator\ValidatorInterface;
use Doctrine\Common\Util\Debug;

class VariantGenerator implements VariantGeneratorInterface
{
    /**
     * Validator.
     *
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * Variant manager.
     *
     * @var ObjectRepository
     */
    protected $variantRepository;

    /**
     * Constructor.
     *
     * @param ValidatorInterface $validator
     * @param ObjectRepository   $variantRepository
     */
    public function __construct(ValidatorInterface $validator, ObjectRepository $variantRepository)
    {
        $this->validator = $validator;
        $this->variantRepository = $variantRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(ProductInterface $product)
    {
        if (!$product->hasOptions()) {
            throw new \InvalidArgumentException('Cannot generate variants for product without options');
        }

        $optionSet = array();
        $optionMap = array();

        foreach ($product->getOptions() as $k => $option) {
            foreach ($option->getValues() as $value) {
                $optionSet[$k][] = $value->getId();
                $optionMap[$value->getId()] = $value;
            }
        }

        $permutations = $this->getPermutations($optionSet);

        foreach ($permutations as $permutation) {
            $variant = $this->variantRepository->createNew();
            
            $mastervariant = $product->getMasterVariant();
            
            $variant->setProduct($product);
            $variant->setDefaults($product->getMasterVariant());
            $variant->setPrice($mastervariant->getPrice());
            $variant->setSku($mastervariant->getSku());

            if (is_array($permutation)) {
                foreach ($permutation as $id) {
                    $variant->addOption($optionMap[$id]);
                }
            } else {
                $variant->addOption($optionMap[$permutation]);
            }
                        
            $product->addVariant($variant);
            
            #Debug::dump($this->validator->validate($variant, array('via'))); die();

            if (0 < count($this->validator->validate($variant, array('via')))) {
                $product->removeVariant($variant);
            }
        }
    }

    /**
     * Get all permutations of option set.
     * Cartesian product.
     *
     * @param array   $array
     * @param Boolean $recursing
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    protected function getPermutations($array, $recursing = false)
    {
        $countArrays = count($array);

        if (1 === $countArrays) {
            return reset($array);
        } elseif (0 === $countArrays) {
            throw new \InvalidArgumentException('At least one array is required.');
        }

        $keys = array_keys($array);

        $a = array_shift($array);
        $k = array_shift($keys);

        $b = $this->getPermutations($array, true);

        $result = array();

        foreach ($a as $valueA) {
            if ($valueA) {
                foreach ($b as $valueB) {
                    if ($recursing) {
                        $result[] = array_merge(array($valueA), (array) $valueB);
                    } else {
                        $result[] = array($k => $valueA) + array_combine($keys, (array) $valueB);
                    }
                }
            }
        }

        return $result;
    }
}
