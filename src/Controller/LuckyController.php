<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    /**
     * @Route("/lucky/number/{num<\d+>?}", name="any_lucky_number")
     *
     * @param int $num
     * @return Response
     */
    public function number(int $num = null)
    {
        return $this->render('lucky/number.html.twig', [
            'number' => $num ?? 0,
        ]);
    }
}
