<?php

namespace App\Controller;

use App\Entity\Logistician;
use App\Entity\Manager;
use App\Entity\Printer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        if ($this->getUser() instanceof Logistician) {
            return $this->redirectToRoute('request_logistics_list');
        }

        if ($this->getUser() instanceof Printer) {
            return $this->redirectToRoute('request_print_list');
        }

        return $this->redirectToRoute('request_manager_list');
    }
}