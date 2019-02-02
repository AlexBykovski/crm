<?php

namespace App\Controller;
use App\Entity\DocumentRequest;
use App\Entity\Manager;
use App\Form\DocumentRequestForm;
use App\Form\SearchDocumentForm;
use App\Provider\DocumentProvider;
use DateInterval;
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
    public function showManagerListAction(Request $request, DocumentProvider $provider)
    {
        $form = $form = $this->createForm(SearchDocumentForm::class);
        $form->handleRequest($request);

        return $this->render('request/manager-list.html.twig', [
            "docRequests" => $provider->provide($form, $this->getUser()),
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/logistics-list", name="request_logistics_list")
     *
     * @Security("has_role('ROLE_LOGISTICIAN')")
     */
    public function showLogisticsListAction(Request $request, DocumentProvider $provider)
    {
        $form = $form = $this->createForm(SearchDocumentForm::class);
        $form->handleRequest($request);

        return $this->render('request/logistics-list.html.twig', [
            "docRequests" => $provider->provide($form, $this->getUser()),
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/print-list", name="request_print_list")
     *
     * @Security("has_role('ROLE_PRINTER')")
     */
    public function showPrintListAction(Request $request, DocumentProvider $provider)
    {
        $form = $form = $this->createForm(SearchDocumentForm::class);
        $form->handleRequest($request);

        return $this->render('request/print-list.html.twig', [
            "docRequests" => $provider->provide($form, $this->getUser()),
            "form" => $form->createView(),
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

    /**
     * @Security("has_role('ROLE_MANAGER')")
     *
     * @Route("/work-manager/", name="work_manager_request")
     * @throws \Exception
     */
    public function workManagerAction(Request $request)
    {
        /** @var EntityManagerInterface $em */
        $em = $this->getDoctrine()->getManager();
        /** @var Manager $manager */
        $manager = $this->getUser();
        /** @var DateTime $workedAt */
        $workedAt = $manager->getWorkUpdatedAt();
        $cloneWorkedAt = clone $workedAt;
        $cloneWorkedAt->add(new DateInterval('P5D'));
        $now = new DateTime();

        if($cloneWorkedAt->format("Y-m-d") < $now->format("Y-m-d")){
            $manager->setWorkUpdatedAt($now);
            $em->flush();

            return new JsonResponse(["success" => true]);
        }

        if($workedAt->format("Y-m-d") === $now->format("Y-m-d")){
            return new JsonResponse(["success" => false, "message" => "Вы уже работаете"]);
        }

        $dayStart = new DateTime();
        $dayStart->sub(new DateInterval('P5D'));
        $dayStart->setTime(0,0,0);
        $workedAt->setTime(23, 59, 59);

        $countUnhandledDocuments = (int)$em->getRepository(DocumentRequest::class)
            ->findCountBetweenDates($dayStart, $workedAt, [DocumentRequest::STATUS_NOT_HANDLED])[0]["count"];

        if(!$countUnhandledDocuments){
            $manager->setWorkUpdatedAt($now);
            $em->flush();

            return new JsonResponse(["success" => true]);
        }

        return new JsonResponse(["success" => false, "message" => "Количество необработанных заявок: " . $countUnhandledDocuments]);
    }
}