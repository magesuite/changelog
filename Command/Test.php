<?php

namespace MageSuite\Changelog\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Test extends Command
{

    private $dataConfig;

    protected $flattenChangelogFactory;

    protected $saveChangelogInDatabase;

    protected $groupChangelogByKey;

    public function __construct(
        \MageSuite\Changelog\Config\Changelog\Data $dataConfig,
        \MageSuite\Changelog\Service\FlattenChangelogFactory $flattenChangelogFactory,
        \MageSuite\Changelog\Service\SaveChangelogInDatabase $saveChangelogInDatabase,
        \MageSuite\Changelog\Service\GroupChangelogByKey $groupChangelogByKey,

        string $name = null
    ) {
        parent::__construct($name);
        $this->dataConfig = $dataConfig;
        $this->flattenChangelogFactory = $flattenChangelogFactory;
        $this->saveChangelogInDatabase = $saveChangelogInDatabase;
        $this->groupChangelogByKey = $groupChangelogByKey;
    }

    protected function configure()
    {
        $this->setName('magesuite:changelog:show');
        $this->setDescription('Lists all changelog entries as flat list.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dataConfig = $this->dataConfig;

        $flattenChangelog = $this->flattenChangelogFactory->create();

        $entries = $dataConfig->getTotals();
        $entries = $flattenChangelog->execute($entries);

        $this->saveChangelogInDatabase->execute($entries);
        $groupedEntries = $this->groupChangelogByKey->execute($entries);

        foreach($groupedEntries as $module => $entries){
            $output->writeln('<info>'.$module.'</info>');
            $output->setDecorated(true);
            foreach($entries as $version => $changes){
                $output->writeln('    <comment>'.$version.'</comment>');
                foreach($changes as $change){
                    $output->writeln(sprintf('      [%s] %s ',$change['change_type'], $change['change_overview']));
                }
            }
        }

        $output->writeln('-- Listing completed.');
    }
}
