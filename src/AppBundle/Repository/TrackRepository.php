<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;


class TrackRepository extends EntityRepository
{
    public function getAllTracks(Request $request, $pageSize, $sort, $direction)
    {
        $searchMap = [
            'genre' => 'g.name',
            'artist' => 'a.name',
            'year' => 't.year',
        ];

        $perPage = (int)$request->query->get('per_page') ?: $pageSize;
        $page = (int)$request->query->get('page') ? $request->query->get('page') - 1 : 0;

        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('t.name as track_name, t.length as length, t.year as year, a.name as artist, g.name as genre')
            ->from('AppBundle:Track', 't')
            ->leftJoin('AppBundle:Artist', 'a', 'WITH', 'a.id = t.artist')
            ->leftJoin('AppBundle:Genre', 'g', 'WITH', 'g.id = t.genre');

        foreach ($searchMap as $key => $search) {
            if ($val = $request->query->get($key)) {
                $query->andWhere($search . ' LIKE :' . $key)
                    ->setParameter($key, '%' . $val . '%');
            }
        }

        if ($sort) {
            $query->orderBy($sort, $direction);
        };

        $result = $query->getQuery()
            ->setMaxResults($perPage)
            ->setFirstResult($perPage * $page)
            ->getResult();

        return [
            'code' => 200,
            'content' => $result,
        ];
    }
}
