<?php

namespace App\Controller;
use App\Entity\DocumentRequest;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    /**
     * @Route("/api/retrieve", name="request_api_retrieve")
     */
    public function retrieveRequestFromAPIAction(Request $request)
    {
        /** @var EntityManagerInterface $em */
        $em = $this->getDoctrine()->getManager();

        try {
            $data = json_decode($request->getContent(), true);

            if(!is_array($data) || !isset($data["fio"]) || !isset($data["citizen"]) || !isset($data["birthDate"]) ||
                !isset($data["birthPlace"]) || !isset($data["type"]) || !isset($data["number"]) || !isset($data["issuedDate"]) ||
                !isset($data["issuedAuthority"]) || !isset($data["term"]) || !isset($data["comment"]) || !isset($data["phone"])){
                throw new \Exception("Incorrect data was received");
            }

            $fio = $data["fio"];
            $citizen = $data["citizen"];
            $birthDate = (new DateTime($data["birthDate"])) ? new DateTime($data["birthDate"]) : null;
            $birthPlace = $data["birthPlace"];
            $type = $data["type"];
            $number = $data["number"];
            $issuedDate = (new DateTime($data["issuedDate"])) ? new DateTime($data["issuedDate"]) : null;
            $issuedAuthority = $data["issuedAuthority"];
            $term = $data["term"];
            $comment = $data["comment"];
            $phone = $data["phone"];

            $documentRequest = new DocumentRequest($fio, $citizen, $birthDate, $birthPlace, $type, $number, $issuedDate,
                $issuedAuthority, $term, $comment, $phone);

            $em->persist($documentRequest);
            $em->flush();
        }
        catch(\Exception $exception){
            return new JsonResponse([
                "success" => false,
                "message" => $exception->getMessage(),
                "content" => $request->getContent(),
            ]);
        }

        return new JsonResponse(["success" => true]);
    }
}