<?php
namespace Via\Bundle\VariableProductBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VariantController extends CRUDController
{
    /**
     * Generate all possible variants for given product id.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function generateAction(Request $request)
    {
        if (null === $productId = $this->getRequest()->get($this->admin->getIdParameter())) {
            throw new NotFoundHttpException('No product given.');
        }
    
        $product = $this->findProductOr404($productId);
        $this->getGenerator()->generate($product);
    
        $this->persistAndFlush($product);
    
        $this->addFlash('sonata_flash_success', 'Variants have been successfully generated.');
    
        return $this
        ->redirectTo($product)
        ;
    }
    
    public function persistAndFlush($resource, $action = 'create')
    {
        $manager = $this->get('via.manager.variant');
    
        $manager->persist($resource);
        #$this->dispatchEvent($action, $resource);
        $manager->flush();
        #$this->dispatchEvent(sprintf('post_%s', $action), $resource);
    }
    
    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        if (null === $productId = $this->getRequest()->get($this->admin->getIdParameter())) {
            throw new NotFoundHttpException('No parent product given.');
        }
    
        $product = $this->findProductOr404($productId);
    
        $variant = $this->get('via.repository.variant');
        $variant->setProduct($product);
    
        return $variant;
    }
    
    /**
     * Get variant generator.
     *
     * @return VariantGeneratorInterface
     */
    protected function getGenerator()
    {
        return $this->get('via.generator.variant');
    }
    
    /**
     * Get product repository.
     *
     * @return ObjectRepository
     */
    protected function getProductRepository()
    {
        return $this->get('via.repository.product');
    }
    
    /**
     * Get product or 404.
     *
     * @param integer $id
     *
     * @return ProductInterface
     */
    protected function findProductOr404($id)
    {
        if (!$product = $this->getProductRepository()->find($id)) {
            throw new NotFoundHttpException('Requested product does not exist.');
        }
    
        return $product;
    }
}