<?php
namespace LwcCmsPage\Options;

interface PageFormOptionsInterface
{

    /**
     *
     * @return string
     */
    public function getDefaultLayout();
    
    /**
     * @return array
     */
    public function getLayouts();
    
    /**
     * 
     * @param array $layouts
     */
    public function setLayouts(array $layouts);

    /**
     *
     * @param string $layout            
     */
    public function setDefaultLayout($layout);

    /**
     *
     * @param boolean $subtitles            
     */
    public function setSubtitles($subtitles);

    /**
     *
     * @return boolean
     */
    public function getSubtitles();

    /**
     * @reutrn
     * boolean
     */
    public function getLayoutSwitch();

    /**
     *
     * @param boolean $flag            
     */
    public function setLayoutSwitch($flag);
}