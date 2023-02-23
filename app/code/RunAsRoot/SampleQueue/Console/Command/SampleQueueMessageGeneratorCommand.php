<?php

declare(strict_types=1);

namespace RunAsRoot\SampleQueue\Console\Command;

use Magento\Framework\Console\Cli;
use RunAsRoot\SampleQueue\Service\SendMessageToSampleQueueService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SampleQueueMessageGeneratorCommand extends Command
{
    public const COMMAND_NAME = 'sample-queue:generate-message';
    public const COMMAND_DESCRIPTION = 'Generates a message and sent it to the sample queue';

    public function __construct(
        string $name = null,
        private SendMessageToSampleQueueService $sendMessageToSampleQueueService
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription(self::COMMAND_DESCRIPTION);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Starting Generating a Message');
        $this->sendMessageToSampleQueueService->execute();
        $io->success('Message was sent to the queue');
        return Cli::RETURN_SUCCESS;
    }
}
