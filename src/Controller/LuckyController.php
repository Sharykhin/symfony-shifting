<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    /**
     * @Route("/lucky/number/{num<\d+>?}", name="any_lucky_number")
     *
     * @param int $num
     * @param LoggerInterface $logger
     * @return Response
     */
    public function number(
        Request $request,
        int $num = null
    )
    {
        return $this->json(array('num' => $num));
    }
}
