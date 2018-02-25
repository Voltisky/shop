<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/25/18
 * Time: 10:18 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Product;
use Symfony\Bridge\Twig\TwigEngine;

class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var TwigEngine
     */
    private $templating;

    public function __construct(\Swift_Mailer $mailer, TwigEngine $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function sendProductCreationMail(Product $product){
        $this->sendMail('test@test.pl', 'test@test.pl', "Product created {$product->getName()}", $this->templating->render("@App/Mailer/product_new.html.twig"));
    }

    /**
     * Send mail with Swift_Mailer
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $body
     * @return bool
     * @author Karol Włodek
     */
    private function sendMail(string $from, string $to, string $subject, string $body)
    {
        try {
            $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($from)
                ->setTo($to)
                ->setBody($body, 'text/html');

            $this->mailer->send($message);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}