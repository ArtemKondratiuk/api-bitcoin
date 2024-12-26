<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CurrencyRepository;
use App\Validator\CurrencyRequestValidator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CurrencyController extends AbstractController
{
    #[Route('/api/currency/{from}/{to}', name: 'api-currency', defaults: ['from' => null, 'to' => null], methods: ['GET'])]
    public function getCurrencies(
        Request $request,
        CurrencyRepository $currencyRepository,
        PaginatorInterface $paginator,
        CurrencyRequestValidator $validator,
    ): JsonResponse {
        $validation = $validator->validate($request->query->all());

        if ($validation->count() > 0) {
            return new JsonResponse(['message' => $validation->get(0)->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $from = $request->query->get('from');
        $to = $request->query->get('to');

        $currencies = $currencyRepository->findByRange($from, $to);

        if (!$currencies) {
            return new JsonResponse(['message' => 'Currencies not found'], Response::HTTP_NOT_FOUND);
        }

        $pagination = $paginator->paginate(
            $currencies,
            $request->query->getInt('page', 1),
            10
        );

        return new JsonResponse($pagination->getItems(), Response::HTTP_OK);
    }
}
