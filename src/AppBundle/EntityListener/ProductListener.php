<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/25/18
 * Time: 10:09 PM
 */

namespace AppBundle\EntityListener;


use AppBundle\Entity\Product;
use AppBundle\Service\Mailer;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

class ProductListener implements EventSubscriber
{
    private $mailer;
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
        );
    }

    /**
     * Subscribe creating new product and send email
     * @param LifecycleEventArgs $args
     * @author Karol Włodek
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Product) {
            return;
        }

        $this->mailer->sendProductCreationMail($entity);
    }
}