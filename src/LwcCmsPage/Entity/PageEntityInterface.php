<?php
namespace LwcCmsPage\Entity;

interface PageEntityInterface
{

    /**
     *
     * @return integer
     */
    public function getId();

    /**
     *
     * @param integer $id
     */
    public function setId($id);

    /**
     *
     * @return integer
     */
    public function getLft();

    /**
     *
     * @param integer $lft
     */
    public function setLft($lft);

    /**
     *
     * @return integer
     */
    public function getRgt();

    /**
     *
     * @param integer $rgt
     */
    public function setRgt($rgt);

    /**
     *
     * @return string
     */
    public function getIdentifier();

    /**
     *
     * @param string $identifier
     */
    public function setIdentifier($identifier);

    /**
     *
     * @return string
     */
    public function getTitle();

    /**
     *
     * @param string $title
     */
    public function setTitle($title);

    /**
     *
     * @param string $summary
     */
    public function setSummary($summary);

    /**
     *
     * @return string
     */
    public function getSummary();

    /**
     *
     * @return array
     */
    public function getContentRows();

    /**
     *
     * @param array $rows
     */
    public function setContentRows(array $rows);

    /**
     *
     * @param RowEntityInterface $row
     */
    public function addContentRow(RowEntityInterface $row);

    /**
     *
     * @return boolean
     */
    public function getIsVisible();

    /**
     *
     * @return integer
     */
    public function getDepth();

    /**
     *
     * @param integer $depth
     */
    public function setDepth($depth);

    /**
     *
     * @return string
     */
    public function getChangefreq();

    /**
     *
     * @param string $freq
     */
    public function setChangefreq($freq);

    /**
     *
     * @return float
     */
    public function getPriority();

    /**
     *
     * @param float $prio
    */
    public function setPriority($prio);
}