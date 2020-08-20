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
     * @Route("/confirm_appointment", name="confirm_appointment")
     */
    public function appointmentConfirmAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/confirm_appointment.html.twig');
    }
}
