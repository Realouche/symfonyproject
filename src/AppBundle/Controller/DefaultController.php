<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Form\appointmentType;
use AppBundle\Entity\appointment;
use Symfony\Component\HttpFoundation\RedirectResponse;


class DefaultController extends Controller
{
    private $entityManager;
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * @Route("/appointment", name="appointment")
     */
    public function appointmentAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager(); //on appelle Doctrine
        $query = $em->createQuery( //creation de la requête
            'SELECT u
            FROM UserUserBundle:User u
            WHERE u.id <> :id'
        )->setParameter('id', $user->getId());
        
        $users = $query->getResult();
        
        // replace this example code with whatever you need
        return $this->render('default/appointment.html.twig', [ 'users' => $users ]);
    }

    /**
     * @Route("/calendar", name="calendar")
     */
    public function calendarAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/calendar.html.twig');
    }

    /**
     * @Route("/confirm_appointment", name="confirm_appointment")
     */
    public function appointmentConfirmAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER',null,'Role not admin');
        dump($request->query->get('id'));
        $userid = $request->query->get('id');

        $doc = $this->get('fos_user.user_manager')->findUserBy(array('id' => $userid));
        dump($doc);
        $appoint = new Appointment();
        $form = $this->createForm(appointmentType::class, $appoint);

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $appoint->setIdCitoyen($this->getUser()->getId());
            $appoint->setIdResp($doc->getId());
            $appoint->setStatus("Pending");
            $em->persist($appoint);
            $em->flush();
            $url = $this->generateUrl('appointment_confirmed',array('idDoc' => $doc->getId(), 'date' => $appoint->getDate()->format('d-m-Y') , 'time' => $appoint->getHour()->format('h:m:s')));
            $response = new RedirectResponse($url);
            return $response;
        }

        // replace this example code with whatever you need
        return $this->render('default/confirm_appointment.html.twig', [ 'user' => $doc ,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/appointmentConfirmed", name="appointment_confirmed")
     */
    public function appointConfirmedAction(Request $request)
    {
        $docid = $request->query->get('idDoc');
        $date = $request->query->get('date');
        $time = $request->query->get('time');
        $doc = $this->getDoctrine()->getRepository('UserUserBundle:User')->findOneBy(array('id' => $docid));
        return $this->render('default/appointment_confirmed.html.twig', ['docid'  => $doc , 'date' => $date , 'time' => $time]);
    }

    /**
     * @Route("/admin_dashboard", name="admin_dashboard")
     */
    public function adminAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN',null,'Role not admin');
        // replace this example code with whatever you need
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        return $this->render('admin/admin_dashboard.html.twig', array('users' =>   $users));
    }
    /**
     * @Route("/admin_dashboard_deleted", name="admin_dashboard_deleted")
     */
    public function deleteAction(Request $request,$id){
        $this->denyAccessUnlessGranted('ROLE_ADMIN',null,'Role not admin');
        // replace this example code with whatever you need
        $user = $this->getUser($id);
        $userManager = $this->get('fos_user.user_manager');
        $userManager->deleteUser($user);

                return $this->render('admin/admin_dashboard_deleted.html.twig');

    }

     /**
     * {@inheritdoc}
     */
    public function findUserById($id)
    {
        return $this->findUserBy(array('id' => $id));
    }

    /**
     * @Route("/citoyen_dashboard", name="citoyen_dashboard")
     */
    public function citoyen_dashboard_Action(Request $request){
        $user = $this->getUser();
        $rdvs = $this->getDoctrine()->getRepository('AppBundle:appointment')->findBy(array('idCitoyen' => $user->getId()));
        dump($rdvs);
        foreach($rdvs as $rdv){
            dump($this->getDoctrine()->getRepository('UserUserBundle:User')->findOneBy(array('id' => $rdv->getIdResp())));
            $rdv->setRespUsername($this->getDoctrine()->getRepository('UserUserBundle:User')->findOneBy(array('id' => $rdv->getIdResp()))->getUsername());
        }
                dump($rdvs);

        
        return $this->render('citoyen/citoyen_dashboard.html.twig', [ 'rdvs' => $rdvs , 'user' => $user ]);
    }



}
