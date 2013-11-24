<?php
namespace LwcCmsPage\Form;

use Zend\InputFilter\InputFilter;

class PageFormFilter extends InputFilter
{

    public function __construct()
    {
        $this->add($this->getPriority());
        $this->add($this->getIdentifier());
        $this->add($this->getSanitize('title'));
        $this->add($this->getSanitize('subtitle', false));
        $this->add($this->getSanitize('summary', false));
    }
    
    /**
     * 
     * @param string $name
     * @param boolean $required OPTIONAL
     * @return array
     */
    protected function getSanitize($name, $required = true)
    {
        return array(
            'name' => $name,
            'required' => $required,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                ),
                array(
                    'name' => 'Null'
                ),
            )
        );
    }
    
    /**
     *
     * @return array
     */
    public function getIdentifier()
    {
        return array(
            'name' => 'identifier',
            'filters' => array(
                array(
                    'name' => 'StringToLower',
                ),
                array(
                    'name' => 'StripTags',
                ),
                array(
                    'name' => 'StringTrim',
                ),
                array(
                    'name' => 'PregReplace',
                    'options' => array(
                        'pattern' => '/[ ]/',
                        'replacement' => '-',
                    ),
                ),
                array(
                    'name' => 'PregReplace',
                    'options' => array(
                        'pattern' => '/[^a-zA-Z0-9_-]/',
                        'replacement' => '',
                    ),
                ),
            )
        );
    }
    
    /**
     * 
     * @return array
     */
    public function getPriority()
    {
        return array(
            'name' => 'priority',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'Callback',
                    'options' => array(
                        'callback' => function($value) {
                            return (float) $value;
                        }
                    )
                ),
            )
        );
    }
}