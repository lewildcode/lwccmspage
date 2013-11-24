<?php
namespace LwcCmsPage\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements PageFormOptionsInterface
{

    /**
     *
     * @var override
     *      ZF
     */
    protected $__strictMode__ = false;

    /**
     *
     * @var boolean
     */
    protected $layoutSwitch = true;

    /**
     *
     * @var string
     */
    protected $defaultLayout;

    /**
     *
     * @var array
     */
    protected $layouts = array();

    /**
     *
     * @var boolean
     */
    protected $subtitles = true;

    /**
     * (non-PHPdoc)
     * 
     * @see \LwcCmsPage\Options\PageFormOptionsInterface::getLayouts()
     */
    public function getLayouts()
    {
        return $this->layouts;
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \LwcCmsPage\Options\PageFormOptionsInterface::setLayouts()
     */
    public function setLayouts(array $layouts)
    {
        $this->layouts = $layouts;
        return $this;
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \LwcCmsPage\Options\PageFormOptionsInterface::getDefaultLayout()
     */
    public function getDefaultLayout()
    {
        return $this->defaultLayout;
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \LwcCmsPage\Options\PageFormOptionsInterface::setDefaultLayout()
     */
    public function setDefaultLayout($layout)
    {
        $this->defaultLayout = trim($layout);
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \LwcCmsPage\Options\PageFormOptionsInterface::getSubtitles()
     */
    public function getSubtitles()
    {
        return $this->subtitles;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \LwcCmsPage\Options\PageFormOptionsInterface::setSubtitles()
     */
    public function setSubtitles($flag)
    {
        $this->subtitles = (bool) $flag;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \LwcCmsPage\Options\PageFormOptionsInterface::getLayoutSwitch()
     */
    public function getLayoutSwitch()
    {
        return $this->layoutSwitch;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \LwcCmsPage\Options\PageFormOptionsInterface::setLayoutSwitch()
     */
    public function setLayoutSwitch($flag)
    {
        $this->layoutSwitch = (bool) $flag;
        return $this;
    }
}