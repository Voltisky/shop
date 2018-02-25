<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/25/18
 * Time: 1:15 AM
 */

namespace AppBundle\Manager;


use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\User;

class ProductManager
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * ProductManager constructor.
     * @param RequestStack $requestStack
     * @param EntityManager $entityManager
     */
    public function __construct(RequestStack $requestStack, EntityManager $entityManager)
    {
        $this->requestStack = $requestStack;
        $this->em = $entityManager;
    }

    /**
     * Create new instance of product with assign default data like createdBy(At), updatedBy(At)
     * @param Product $product
     * @param User $user
     * @author Karol Włodek
     */
    public function create(Product $product, User $user)
    {
        $product->setCreatedBy($user->getUsername());
        $product->setUpdatedBy($user->getUsername());

        $product->setCreatedAt(new \DateTime());
        $product->setUpdatedAt(new \DateTime());

        $product->setCurrency($this->getCurrency());

        $this->em->persist($product);
        $this->em->flush();
    }

    /**
     * Return current currency symbol
     * @return bool|string
     * @author Karol Włodek
     */
    public function getCurrency(): string
    {
        $locale = $this->getRequest()->getLocale();
        $formatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);

        $currency = $formatter->getTextAttribute(\NumberFormatter::CURRENCY_CODE);
        if (!$currency) {
            $currency = "PLN";
        }

        return $currency;
    }

    /**
     * Get Master Request
     * @return null|\Symfony\Component\HttpFoundation\Request
     * @author Karol Włodek
     */
    private function getRequest()
    {
        return $this->requestStack->getMasterRequest();
    }
}