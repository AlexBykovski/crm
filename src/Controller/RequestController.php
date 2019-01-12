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
        $docRequests = $this->getDoctrine()->getRepository(DocumentRequest::class)->searchInitForManager();

        $parsedDocRequests = [];

        /** @var DocumentRequest $docRequest */
        foreach ($docRequests as $docRequest){
            $date = $docRequest->getCreatedAt()->format("d.m.Y");

            if(!array_key_exists($date, $parsedDocRequests)){
                $parsedDocRequests[$date] = [];
            }

            $parsedDocRequests[$date][] = $docRequest;
        }

        ksort($parsedDocRequests);

        return $this->render('request/manager-list.html.twig', [
            "docRequests" => $parsedDocRequests,
        ]);
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
            if($request->request->get("key") !== "CRM1"){
                throw new \Exception("Incorrect data was received");
            }

            $fio = $request->request->get("fio");
            $citizen = $request->request->get("citizen");
            $birthDate = (new DateTime($request->request->get("birthDate"))) ? new DateTime($request->request->get("birthDate")) : null;
            $birthPlace = $request->request->get("birthPlace");
            $type = $request->request->get("type");
            $number = $request->request->get("number");
            $issuedDate = (new DateTime($request->request->get("issuedDate"))) ? new DateTime($request->request->get("issuedDate")) : null;
            $issuedAuthority = $request->request->get("issuedAuthority");
            $term = $request->request->get("term");
            $comment = $request->request->get("comment");
            $phone = $request->request->get("phone");

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