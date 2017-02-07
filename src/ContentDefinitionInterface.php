<?php
/**
 * File ContentDefinitionInterface.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\FormTest;

/**
 * Interface ContentDefinitionInterface
 *
 * @package Epfremme\FormTest
 */
interface ContentDefinitionInterface
{
    /**
     * @return string[]
     */
    public function getFields();

    /**
     * @return string
     */
    public function getTemplate();
}
