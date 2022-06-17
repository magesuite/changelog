<?php

namespace MageSuite\Changelog\Controller\Adminhtml\Changelog;

class Markdown extends \MageSuite\Changelog\Controller\Adminhtml\Changelog\AbstractChangelogAction
{
    const NEW_LINE = "\r\n";
    const NEW_DOUBLE_LINE = "\r\n\r\n";

    public function execute()
    {
        $content = '<textarea style="width:95%;height:100%;">';
        $entries = $this->getEntries();
        $params = $this->parseParams();

        $content .= __('Changes introduced between **%1** and **%2**', $params['from'], $params['to'])."\r\n\r\n";

        foreach ($entries as $module => $tags) {
            $content .= self::NEW_LINE.'### ' . $module . self::NEW_DOUBLE_LINE;
            $content .= $this->getTagsInformation($tags);
        }

        $content .= '</textarea>';
        $result = $this->resultRawFactory->create();
        $result->setContents($content);

        return $result;
    }

    private function getTagsInformation($tags): string
    {
        $content = $this->getModuleDescription($tags).self::NEW_DOUBLE_LINE;
        foreach ($tags as $tagVersion => $changes) {
            $content .=  '#### Version: '.$tagVersion.':'.self::NEW_LINE;
            $content .= $this->getChanges($changes);
        }

        return $content;
    }

    private function getModuleDescription($tags)
    {
        foreach ($tags as $tagChanges) {
            foreach ($tagChanges as $change) {
                return $change['description'];
            }
        }
    }

    private function getChanges($changes)
    {
        $content = '';
        foreach ($changes as $change) {
            $content .= '   - '.$change['change_overview'].self::NEW_LINE;
        }

        return $content;
    }
}
