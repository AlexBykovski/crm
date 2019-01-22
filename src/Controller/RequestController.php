<?php

namespace App\Controller;
use App\Entity\DocumentRequest;
use App\Form\DocumentRequestForm;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
        return $this->render('request/manager-list.html.twig', [
            "docRequests" => $this->getInitDocuments(),
        ]);
    }

    /**
     * @Route("/logistics-list", name="request_logistics_list")
     *
     * @Security("has_role('ROLE_LOGISTICIAN')")
     */
    public function showLogisticsListAction(Request $request)
    {
        return $this->render('request/logistics-list.html.twig', [
            "docRequests" => $this->getInitDocuments(),
        ]);
    }

    /**
     * @Route("/print-list", name="request_print_list")
     *
     * @Security("has_role('ROLE_PRINTER')")
     */
    public function showPrintListAction(Request $request)
    {
        return $this->render('request/print-list.html.twig', [
            "docRequests" => $this->getInitDocuments(),
        ]);
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

    /**
     * @Security("has_role('ROLE_MANAGER') or has_role('ROLE_LOGISTICIAN') or has_role('ROLE_PRINTER')")
     *
     * @Route("/edit-document-request/{id}", name="edit_document_request")
     * @ParamConverter("documentRequest", class="App:DocumentRequest", options={"id" = "id"})
     */
    public function editDocumentRequestAction(Request $request, DocumentRequest $documentRequest)
    {
        /** @var EntityManagerInterface $em */
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(DocumentRequestForm::class, $documentRequest, ["user_role" => $this->getUser()->getRole()]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();

            return new JsonResponse(["success" => true, "redirectUrl" => $request->headers->get('referer')]);
        }

        return $this->render('request/modal/edit-document-request.html.twig', [
            "form" => $form->createView(),
        ]);
    }

    public function getInitDocuments()
    {
        $docRequests = $this->getDoctrine()->getRepository(DocumentRequest::class)->search($this->getUser());

        $parsedDocRequests = [];

        /** @var DocumentRequest $docRequest */
        foreach ($docRequests as $docRequest){
            $date = $docRequest->getCreatedAt()->format("d.m.Y");

            if(!array_key_exists($date, $parsedDocRequests)){
                $parsedDocRequests[$date] = [];
            }

            $parsedDocRequests[$date][] = $docRequest;
        }

        krsort($parsedDocRequests);

        return $parsedDocRequests;
    }
}