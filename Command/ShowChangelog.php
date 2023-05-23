<?php

namespace MageSuite\Changelog\Command;

class ShowChangelog extends \Symfony\Component\Console\Command\Command
{

    protected $dataConfigFactory;

    protected $flattenChangelogFactory;

    protected $saveChangelogInDatabaseFactory;

    protected $groupChangelogByKeyFactory;

    public function __construct(
        \MageSuite\Changelog\Config\Changelog\DataFactory $dataConfigFactory,
        \MageSuite\Changelog\Service\FlattenChangelogFactory $flattenChangelogFactory,
        \MageSuite\Changelog\Service\SaveChangelogInDatabaseFactory $saveChangelogInDatabaseFactory,
        \MageSuite\Changelog\Service\GroupChangelogByKeyFactory $groupChangelogByKeyFactory,
        string $name = null
    ) {
        parent::__construct($name);
        $this->dataConfigFactory = $dataConfigFactory;
        $this->flattenChangelogFactory = $flattenChangelogFactory;
        $this->saveChangelogInDatabaseFactory = $saveChangelogInDatabaseFactory;
        $this->groupChangelogByKeyFactory = $groupChangelogByKeyFactory;
    }

    protected function configure()
    {
        $this->setName('magesuite:changelog:show');
        $this->setDescription('Lists all changelog entries as flat list.');
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        $dataConfig = $this->dataConfigFactory->create();
        $flattenChangelog = $this->flattenChangelogFactory->create();

        $entries = $dataConfig->getData();
        $entries = $flattenChangelog->execute($entries);

        $this->saveChangelogInDatabaseFactory->create()->execute($entries);
        $groupedEntries = $this->groupChangelogByKeyFactory->create()->execute($entries);

        foreach ($groupedEntries as $module => $entries) {
            $output->writeln('<info>'.$module.'</info>');
            $output->setDecorated(true);
            foreach ($entries as $version => $changes) {
                $output->writeln('    <comment>'.$version.'</comment>');
                foreach ($changes as $change) {
                    $output->writeln(sprintf('      [%s] %s ', $change['change_type'], $change['change_overview']));
                }
            }
        }

        $output->writeln('-- Listing completed.');

        return \Magento\Framework\Console\Cli::RETURN_SUCCESS;
    }
}
