<?php

namespace App\Controller;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/task")
 *
 * @Security("has_role('ROLE_MANAGER') or has_role('ROLE_LOGISTICIAN') or has_role('ROLE_PRINTER')")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/list", name="task_list")
     */
    public function showRequestsAction(Request $request)
    {
        return $this->render('task/list.html.twig', []);
    }

    /**
     * @Route("/add-new/", name="task_add_new")
     */
    public function addNewTaskAction(Request $request)
    {
        /** @var EntityManagerInterface $em */
        $em = $this->getDoctrine()->getManager();

        $taskText = $request->request->get("text");

        $task = new Task();
        $task->setText($taskText);
        $task->setUser($this->getUser());

        $em->persist($task);
        $em->flush();

        return new JsonResponse([
            "success" => true,
            "id" => $task->getId(),
        ]);
    }

    /**
     * @Route("/change-status/{id}", name="task_change_status")
     *
     * @ParamConverter("task", class="App:Task", options={"id" = "id"})
     */
    public function changeStatusAction(Request $request, Task $task)
    {
        $task->setIsChecked(!$task->isChecked());

        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(["success" => true]);
    }

    /**
     * @Route("/delete/{id}", name="task_delete")
     *
     * @ParamConverter("task", class="App:Task", options={"id" = "id"})
     */
    public function deleteAction(Request $request, Task $task)
    {
        /** @var EntityManagerInterface $em */
        $em = $this->getDoctrine()->getManager();

        $em->remove($task);
        $em->flush();

        return new JsonResponse(["success" => true]);

    }
}