<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * List of products with pagination
     * @Route("/", name="product_list")
     */
    public function productListAction(Request $request)
    {
        $productPaginator = $this->get('app.paginator.product');
        $paginator = $productPaginator->getPaginator($request->query->filter('page', 1, FILTER_VALIDATE_INT));

        return $this->render('@App/Admin/product_list.html.twig', ["paginator" => $paginator]);
    }

    /**
     * Creating new product view
     * @Route("/new-product", methods={"GET"})
     */
    public function newProductAction()
    {
        $form = $this->getProductForm();
        return $this->render('@App/Admin/product_new.html.twig', ["form" => $form->createView()]);
    }

    /**
     * Validate and Flush product to database
     * @Route("/new-product", methods={"POST"})
     */
    public function newProductPostAction(Request $request)
    {
        $productManager = $this->get('app.product_manager');
        $product = new Product();
        $form = $this->getProductForm($product);

        $form->handleRequest($request);
        $err = false;
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $productManager->create($product, $this->getUser());
            } catch (\Exception $e) {
                $this->addFlash('error', 'Cannot create product');
                $err = true;
            }
        } else {
            $this->addFlash('error', 'Cannot create product');
            $err = true;
        }

        if ($err) {
            return $this->render('@App/Admin/product_new.html.twig', ["form" => $form->createView()]);
        }

        return $this->redirectToRoute('product_list');
    }

    /**
     * Get product form
     * @param Product|null $product
     * @return \Symfony\Component\Form\FormInterface
     * @author Karol Włodek
     */
    public function getProductForm(Product $product = null)
    {
        $productManager = $this->get('app.product_manager');
        try {
            $form = $this->createForm(ProductType::class, $product, ["currency" => $productManager->getCurrency()]);
        } catch (\Exception $e) {
            throw new BadRequestHttpException("Locale error");
        }

        return $form;
    }
}
