<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Config\Changelog;

class Converter implements \Magento\Framework\Config\ConverterInterface
{

    /**
     * Convert dom node tree to array
     *
     * @param \DOMDocument $source
     * @return array
     */
    public function convert($source): array
    {
        $output = [];
        $xpath = new \DOMXPath($source);
        $moduleNodes = $xpath->evaluate('/config/module');

        /** @var $node \DOMNode */
        foreach ($moduleNodes as $moduleNode) {
            $nodeId = $moduleNode->getAttribute('id');

            $data = [];
            $data['id'] = $nodeId;
            $data['description'] = $moduleNode->getAttribute('description');
            $data['url'] = $moduleNode->getAttribute('url');

            $data['tags'] = [];

            foreach ($moduleNode->childNodes as $changelogNode) {
                if ($changelogNode->nodeType != XML_ELEMENT_NODE) {
                    continue;
                }

                $output['module'][$nodeId] = $data;
                $this->processTagNodes($changelogNode->childNodes, $output['module'][$nodeId]);
            }
        }

        return $output;
    }

    private function processTagNodes($tagNodes, &$output)
    {
        foreach ($tagNodes as $tagNode) {
            if ($tagNode->nodeType != XML_ELEMENT_NODE) {
                continue;
            }

            $tagChanges = $this->processChangeNodes($tagNode->childNodes, $output);
            $tag['version'] = $tagNode->getAttribute('version');
            $tag['date'] = $tagNode->getAttribute('date');
            $tag['changes'] = $tagChanges;
            $output['tags'][] = $tag;
        }
    }

    private function processChangeNodes($changeNodes, &$output)
    {
        $changes = [];
        foreach ($changeNodes as $changeNode) {

            if ($changeNode->nodeType != XML_ELEMENT_NODE) {
                continue;
            }

            $changes[] = $this->processChangeDetailNodes($changeNode->childNodes, $output);

        }

        return $changes;
    }

    private function processChangeDetailNodes($changeDetailNodes, &$output)
    {
        $changes = [];
        foreach ($changeDetailNodes as $changeDetails) {
            if ($changeDetails->nodeType != XML_ELEMENT_NODE) {
                continue;
            }

            $changes[$changeDetails->nodeName] = $changeDetails->nodeValue;
        }

        return $changes;
    }
}
