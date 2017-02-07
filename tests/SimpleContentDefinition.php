<?php
/**
 * File SimpleContentDefinition.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\FormTest\Tests;

use Epfremme\FormTest\ContentDefinitionInterface;
use Symfony\Component\Form\Extension\Core\Type;

/**
 * Class SimpleContentDefinition
 *
 * @package Epfremme\FormTest\Tests
 */
class SimpleContentDefinition implements ContentDefinitionInterface
{
    /**
     * @return string[]
     */
    public function getFields()
    {
        return [
            'field_1' => Type\TextType::class,
            'field_2' => Type\CheckboxType::class,
        ];
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return 'simple_content_form.html.twig';
    }
}
