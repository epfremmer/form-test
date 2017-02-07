<?php
/**
 * File ContentFormFactory.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\FormTest\Factory;

use Epfremme\FormTest\ContentDefinitionInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class ContentFormFactory
 *
 * @package Epfremme\FormTest\Factory
 */
class ContentFormFactory
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * ContentFormFactory constructor
     *
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * Build form for provided content definition
     *
     * @param ContentDefinitionInterface $contentDefinition
     * @param null|string $name
     * @return FormBuilderInterface
     */
    public function build(ContentDefinitionInterface $contentDefinition, $name = null)
    {
        $fields = $contentDefinition->getFields();
        $builder = is_null($name) ? $this->formFactory->createBuilder() : $this->formFactory->createNamedBuilder($name);

        foreach ($fields as $name => $type) {
            if (is_subclass_of($type, ContentDefinitionInterface::class)) {
                $builder->add($this->build(new $type(), $name));
                continue;
            }

            $builder->add($name, $type);
        }

        return $builder;
    }
}
