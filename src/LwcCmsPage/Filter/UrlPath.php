<?php
namespace LwcCmsPage\Filter;

use Zend\Filter\FilterInterface;
use Zend\Filter\FilterChain;
use Zend\Filter\PregReplace;
use Zend\Filter\StringToLower;

class UrlPath implements FilterInterface
{

    /**
     *
     * @return \Zend\Filter\PregReplace
     */
    protected function getUmlauts()
    {
        $pattern = array(
            '/é/',
            '/ä/',
            '/ö/',
            '/ü/',
            '/ß/',
            '/ - /',
            '/ + /',
            '/_/'
        );
        $replacement = array(
            'e',
            'ae',
            'oe',
            'ue',
            'ss',
            '-',
            '-',
            '-'
        );
        return new PregReplace(array(
            'pattern' => $pattern,
            'replacement' => $replacement
        ));
    }

    /**
     *
     * @return \Zend\Filter\PregReplace
     */
    protected function getNotAlnum()
    {
        return new PregReplace(array(
            'pattern' => '/[^a-z0-9_-]/isU',
            'replacement' => ''
        ));
    }

    /**
     *
     * @param string $sep
     * @return \Zend\Filter\PregReplace
     */
    protected function getSeparator($sep = '-')
    {
        return new PregReplace(array(
            'pattern' => '/\s/s',
            'replacement' => $sep
        ));
    }

    /**
     *
     * @return \Zend\Filter\StringToLower
     */
    protected function getStringToLower()
    {
        return new StringToLower('UTF-8');
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\Filter\FilterInterface::filter()
     */
    public function filter($value)
    {
        $chain = new FilterChain();
        $chain->attach($this->getStringToLower())
            ->attach($this->getUmlauts())
            ->attach($this->getSeparator())
            ->attach($this->getNotAlnum())
            ->attachByName('stringtrim');

        return $chain->filter($value);
    }
}