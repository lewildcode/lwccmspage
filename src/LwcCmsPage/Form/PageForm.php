<?php

namespace LwcCmsPage\Form;

use Zend\Form\Form;
use Zend\Form\Element\Text;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Select;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\DateTime;
class PageForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('lwccmspage', $options);

        $visible = new Checkbox('isVisible');
        $visible->setLabel('lwccmspage.visible');

        $title = new Text('title');
        $title->setLabel('lwccmspage.title');

        $subtitle = new Text('subtitle');
        $subtitle->setLabel('lwccmspage.subtitle');

        $summary = new Text('summary');
        $summary->setLabel('lwccmspage.summary');

        $identifier = new Text('identifier');
        $identifier->setLabel('lwccmspage.identifier');

        $layout = new Select('layout');
        $layout->setLabel('lwccmspage.layout');
        $layout->setValueOptions(array(
            'layout/demo' => 'Demo Layout'
        ));

        $submit = new Submit('save_page');
        $submit->setValue('lwccmspage.submit');

        $this->add($visible);
        $this->add($title);
        $this->add($subtitle);
        $this->add($summary);
        $this->add($layout);
        $this->add($identifier);
        $this->add($submit);
    }
}