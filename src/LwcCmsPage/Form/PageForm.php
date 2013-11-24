<?php
namespace LwcCmsPage\Form;

use Zend\Form\Form;
use LwcCmsPage\Options\PageFormOptionsInterface;

class PageForm extends Form
{

    /**
     *
     * @var PageFormOptionsInterface
     */
    protected $pageFormOptions;

    /**
     *
     * @param string $name            
     * @param PageFormOptionsInterface $options            
     */
    public function __construct($name = null, PageFormOptionsInterface $options)
    {
        parent::__construct($name);
        $this->setPageFormOptions($options);
        
        $this->add($this->getIdElement());
        $this->add($this->getIdentifierElement());
        $this->add($this->getLftElement());
        $this->add($this->getRgtElement());
        $this->add($this->getVisibleElement());
        $this->add($this->getTitleElement());
        $this->add($this->getSummaryElement());
        
        if($this->getPageFormOptions()->getSubtitles()) {
            $this->add($this->getSubTitleElement());
        }
        
        if($this->getPageFormOptions()->getLayoutSwitch()) {
            $this->add($this->getLayoutElement());
        }
        
        // seo
        $this->add($this->getPriorityElement());
        $this->add($this->getChangefreqElement());
        
        $this->add($this->getSubmitElement());
    }

    /**
     *
     * @param PageFormOptionsInterface $options            
     * @return \LwcCmsPage\Form\PageForm
     */
    public function setPageFormOptions(PageFormOptionsInterface $options)
    {
        $this->pageFormOptions = $options;
        return $this;
    }

    /**
     *
     * @return \LwcCmsPage\Options\PageFormOptionsInterface
     */
    public function getPageFormOptions()
    {
        return $this->pageFormOptions;
    }

    /**
     *
     * @return array
     */
    public function getIdElement()
    {
        return array(
            'name' => 'id',
            'type' => 'hidden',
            'attributes' => array(
                'required' => 'required'
            )
        );
    }

    /**
     *
     * @return array
     */
    public function getTitleElement()
    {
        return array(
            'name' => 'title',
            'type' => 'text',
            'options' => array(
                'label' => 'Title',
                'label_attributes' => array(
                    'class' => 'control-label'
                )
            ),
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control'
            )
        );
    }

    /**
     *
     * @return array
     */
    public function getSubTitleElement()
    {
        return array(
            'name' => 'subtitle',
            'type' => 'text',
            'options' => array(
                'label' => 'Subtitle',
                'label_attributes' => array(
                    'class' => 'control-label'
                )
            ),
            'attributes' => array(
                'class' => 'form-control'
            )
        );
    }

    /**
     *
     * @return array
     */
    public function getSummaryElement()
    {
        return array(
            'name' => 'summary',
            'type' => 'text',
            'options' => array(
                'label' => 'Summary',
                'label_attributes' => array(
                    'class' => 'control-label'
                )
            ),
            'attributes' => array(
                'class' => 'form-control'
            )
        );
    }

    /**
     *
     * @return array
     */
    public function getIdentifierElement()
    {
        return array(
            'name' => 'identifier',
            'type' => 'text',
            'options' => array(
                'label' => 'Identifier',
                'label_attributes' => array(
                    'class' => 'control-label'
                )
            ),
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control'
            )
        );
    }

    /**
     *
     * @return array
     */
    public function getLftElement()
    {
        return array(
            'name' => 'lft',
            'type' => 'number',
            'options' => array(
                'label' => 'Lft Value',
                'label_attributes' => array(
                    'class' => 'control-label'
                )
            ),
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control'
            )
        );
    }

    /**
     *
     * @return array
     */
    public function getRgtElement()
    {
        return array(
            'name' => 'rgt',
            'type' => 'number',
            'options' => array(
                'label' => 'Rgt Value',
                'label_attributes' => array(
                    'class' => 'control-label'
                )
            ),
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control'
            )
        );
    }

    /**
     *
     * @return array
     */
    public function getPriorityElement()
    {
        return array(
            'name' => 'priority',
            'type' => 'range',
            'options' => array(
                'label' => 'Priority (SEO / Sitemap)',
                'label_attributes' => array(
                    'class' => 'control-label'
                )
            ),
            'attributes' => array(
                'required' => 'required',
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'class' => 'form-control'
            )
        );
    }

    /**
     *
     * @return array
     */
    public function getChangefreqElement()
    {
        return array(
            'name' => 'changefreq',
            'type' => 'select',
            'options' => array(
                'label' => 'Change frequency (SEO / Sitemap)',
                'label_attributes' => array(
                    'class' => 'control-label'
                ),
                'value_options' => array(
                    'always' => 'Always',
                    'hourly' => 'Hourly',
                    'daily' => 'Daily',
                    'weekly' => 'Weekly',
                    'monthly' => 'Monthly',
                    'yearly' => 'Yearly',
                    'never' => 'Never'
                )
            ),
            'attributes' => array(
                'required' => 'required',
                'size' => 1,
                'class' => 'form-control'
            )
        );
    }

    /**
     *
     * @return array
     */
    public function getLayoutElement()
    {
        $layouts = $this->getPageFormOptions()->getLayouts();
        return array(
            'name' => 'layout',
            'type' => 'select',
            'options' => array(
                'label' => 'Layout',
                'label_attributes' => array(
                    'class' => 'control-label'
                ),
                'value_options' => $layouts
            ),
            'attributes' => array(
                'class' => 'form-control',
                'size' => 1,
                'required' => 'required'
            )
        );
    }

    /**
     *
     * @return array
     */
    public function getVisibleElement()
    {
        return array(
            'name' => 'isVisible',
            'type' => 'checkbox',
            'options' => array(
                'label' => 'Is visible',
                'label_attributes' => array(
                    'class' => 'control-label'
                )
            ),
            'attributes' => array(
                'class' => 'checkbox'
            )
        );
    }

    /**
     *
     * @return array
     */
    public function getSubmitElement()
    {
        return array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Submit',
                'class' => 'btn btn-primary'
            )
        );
    }
}