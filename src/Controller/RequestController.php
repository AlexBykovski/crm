<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/request")
 */
class RequestController extends AbstractController
{
    /**
     * @Route("/manager-list", name="request_manager_list")
     *
     * @Security("has_role('ROLE_MANAGER')")
     */
    public function showManagerListAction(Request $request)
    {
        return $this->render('request/manager-list.html.twig', []);
    }

    /**
     * @Route("/logistics-list", name="request_logistics_list")
     *
     * @Security("has_role('ROLE_LOGISTICIAN')")
     */
    public function showLogisticsListAction(Request $request)
    {
        return $this->render('request/logistics-list.html.twig', []);
    }

    /**
     * @Route("/print-list", name="request_print_list")
     *
     * @Security("has_role('ROLE_PRINTER')")
     */
    public function showPrintListAction(Request $request)
    {
        return $this->render('request/print-list.html.twig', []);
    }
}