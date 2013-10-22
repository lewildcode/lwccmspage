<?php
namespace LwcCmsPage\Entity;

use LwcCmsContent\Model\ContentEntityInterface;

class RowEntity implements RowEntityInterface
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $pageId;

    /**
     *
     * @var array
     */
    protected $contents = array();

    /**
     * (non-PHPdoc)
     *
     * @see \LwcCmsPage\Entity\RowEntityInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \LwcCmsPage\Entity\RowEntityInterface::setId()
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \LwcCmsPage\Entity\RowEntityInterface::getPageId()
     */
    public function getPageId()
    {
        return $this->pageId;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \LwcCmsPage\Entity\RowEntityInterface::setPageId()
     */
    public function setPageId($pageId)
    {
        $this->pageId = (int) $pageId;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \LwcCmsPage\Entity\RowEntityInterface::getContents()
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \LwcCmsPage\Entity\RowEntityInterface::setContents()
     */
    public function setContents($contents)
    {
        $this->contents = array();

        foreach($contents as $content) {
            $this->addContent($content);
        }
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \LwcCmsPage\Entity\RowEntityInterface::hasContents()
     */
    public function hasContents()
    {
        return count($this->getContents()) > 0;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \LwcCmsPage\Entity\RowEntityInterface::addContent()
     */
    public function addContent(ContentEntityInterface $content)
    {
        $this->contents[] = $content;
        return $this;
    }
}