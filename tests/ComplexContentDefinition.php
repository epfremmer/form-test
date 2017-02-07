<?php
/**
 * File ComplexContentDefinition.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\FormTest\Tests;

use Epfremme\FormTest\ContentDefinitionInterface;
use Symfony\Component\Form\Extension\Core\Type;

/**
 * Class ComplexContentDefinition
 *
 * @package Epfremme\FormTest\Tests
 */
class ComplexContentDefinition implements ContentDefinitionInterface
{
    /**
     * @return string[]
     */
    public function getFields()
    {
        return [
            'field_1' => Type\TextType::class,
            'field_2' => Type\CheckboxType::class,
            'field_3' => SimpleContentDefinition::class,
        ];
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return 'complex_content_form.html.twig';
    }
}
