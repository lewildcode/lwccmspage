<?php
namespace LwcCmsPage\Entity;

use LwcCmsContent\Model\ContentEntityInterface;

interface RowEntityInterface
{

    /**
     *
     * @return integer
     */
    public function getId();

    /**
     *
     * @param integer $id
     * @return RowEntityInterface
     */
    public function setId($id);

    /**
     *
     * @return integer
     */
    public function getPageId();

    /**
     *
     * @param integer $pageId
     * @return RowEntityInterface
     */
    public function setPageId($pageId);

    /**
     *
     * @param ContentEntityInterface $content
     */
    public function addContent(ContentEntityInterface $content);

    /**
     *
     * @return array
     */
    public function getContents();

    /**
     *
     * @return boolean
     */
    public function hasContents();

    /**
     *
     * @param mixed $contents
     * @return RowEntityInterface
     */
    public function setContents($contents);
}