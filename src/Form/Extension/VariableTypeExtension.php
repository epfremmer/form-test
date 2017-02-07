<?php
/**
 * File VariableTypeExtension.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\FormTest\Form\Extension;

use Epfremme\FormTest\Factory\ContentFormFactory;
use Epfremme\FormTest\Form\Type\VariableType;
use Symfony\Component\Form\AbstractExtension;

/**
 * Class VariableTypeExtension
 *
 * @package Epfremme\FormTest\Form\Extension
 */
class VariableTypeExtension extends AbstractExtension
{
    /**
     * @var ContentFormFactory
     */
    private $contentFormFactory;

    /**
     * VariableTypeExtension constructor
     *
     * @param ContentFormFactory $contentFormFactory
     */
    public function __construct(ContentFormFactory $contentFormFactory)
    {
        $this->contentFormFactory = $contentFormFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function loadTypes()
    {
        return [
            new VariableType($this->contentFormFactory),
        ];
    }
}
