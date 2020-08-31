<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/home", name="homepage")
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
        // replace this example code with whatever you need
        return $this->render('default/appointment.html.twig');
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
        // replace this example code with whatever you need
        return $this->render('default/confirm_appointment.html.twig');
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
        $rdv = $this->getDoctrine()->getRepository('AppBundle:appointment')->findBy(array('idCitoyen' => $user->getId()));
        dump($rdv);
        $idRespo = $rdv[0]->getIdResp();
        $doc = $this->get('fos_user.user_manager')->findUserBy(array('id' => $idRespo));

        return $this->render('citoyen/citoyen_dashboard.html.twig', [ 'rdvs' => $rdv , 'user' => $user, 'doc' => $doc ]);
    }



}
