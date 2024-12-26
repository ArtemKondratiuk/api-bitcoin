<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\CurrencyRepository;
use App\Service\CurrencyApiService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Scheduler\Attribute\AsPeriodicTask;

#[AsCommand(
    name: 'app:currency-update',
    description: 'update currencies',
)]
#[AsPeriodicTask('1 hour', schedule: 'default')]
final class UpdateCurrencyCommand extends Command
{
    public function __construct(
        private readonly CurrencyApiService $currencyApiService,
        private readonly CurrencyRepository $currencyRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $currencies = $this->currencyApiService->getCurrencies();

        $this->currencyRepository->save($currencies);

        return Command::SUCCESS;
    }
}
