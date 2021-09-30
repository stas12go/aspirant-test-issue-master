<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Interfaces\RouteCollectorInterface;
use Twig\Environment;

class HomeController
{
    public function __construct(
        private RouteCollectorInterface $routeCollector,
        private Environment $twig,
        private EntityManagerInterface $em
    ) {
    }

    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $trailers = $this->fetchData()->toArray();
        $firstTrailer = array_shift($trailers);

        try {
            $data = $this->twig->render('home/index.html.twig', [
                'trailers' => $trailers,
                'firstTrailer' => $firstTrailer,
                'className' => __CLASS__,
                'methodName' => __METHOD__,
            ]);
        } catch (\Exception $e) {
            throw new HttpBadRequestException($request, $e->getMessage(), $e);
        }

        // dd($this->fetchData()->toArray());

        $response->getBody()->write($data);

        return $response;
    }

    protected function fetchData(): Collection
    {
        $data = $this->em->getRepository(Movie::class)
            ->findAll();

        return new ArrayCollection($data);
    }

    public function show(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $movie = $this->em->getRepository(Movie::class)
            ->find($request->getAttribute('id'));

        if (is_null($movie)) {
            $error = $this->twig->render('404.html.twig');
            $response->getBody()->write($error);
            return $response;
        }

        try {
            $data = $this->twig->render('movie/show.html.twig', [
                'movie' => $movie,
            ]);
        } catch (\Exception $e) {
            throw new HttpBadRequestException($request, $e->getMessage(), $e);
        }

        $response->getBody()->write($data);
        return $response;
    }
}
