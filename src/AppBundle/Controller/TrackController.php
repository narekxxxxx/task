<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Validator\SortValidator;

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

        $sortFields = [
            'track_name',
            'length',
            'artist',
            'genre',
        ];

        $directions = ['asc', 'desc'];

        $direction = $request->query->get('direction') ?: 'asc';
        $sort = $request->query->get('sort');

        $sortValidator = new SortValidator();
        $sortValidator->setParam($sortFields);
        $response = new JsonResponse();
        if (!$sortValidator->validate($sort)) {
            return $response->setData([
                'message' => $sortValidator->getMessage(),
                'code' => SortValidator::VALIDATION_FAILED_CODE,
            ]);
        }

        $sortValidator->setParam($directions);
        if (!$sortValidator->validate($direction)) {
            return $response->setData([
                'message' => $sortValidator->getMessage(),
                'code' => SortValidator::VALIDATION_FAILED_CODE,
            ]);
        }

        $tracks = $em->getRepository('AppBundle:Track')->getAllTracks($request, $pageSize, $sort, $direction);

        return $response->setData($tracks);
    }
}
