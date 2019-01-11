<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/task")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/list", name="task_list")
     *
     * @Security("has_role('ROLE_MANAGER') or has_role('ROLE_LOGISTICIAN') or has_role('ROLE_PRINTER')")
     */
    public function showRequestsAction(Request $request)
    {
        return $this->render('task/list.html.twig', []);
    }
}