<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Track;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class TrackController extends Controller
{
    /**
     * @Route("/api/tracks", name="tracks")
     * @Method({"GET"})
     */
    public function getTracksAction(Request $request)
    {
        $pageSize = $this->container->getParameter('pagination_size');
        $em = $this->getDoctrine()->getManager();

        $tracks = $em->getRepository('AppBundle:Track')->getAllTracks($request, $pageSize);

        return new JsonResponse($tracks);
    }
}
