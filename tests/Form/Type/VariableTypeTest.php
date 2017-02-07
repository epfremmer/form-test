<?php
/**
 * File VariableTypeTest.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\FormTest\Tests\Form\Type;

use Epfremme\FormTest\Form\Type\VariableType;
use Epfremme\FormTest\Tests\_mixins\TwigEnvironmentTrait;
use Epfremme\FormTest\Tests\ComplexContentDefinition;
use Epfremme\FormTest\Tests\SimpleContentDefinition;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Form\FormFactoryBuilder;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class VariableTypeTest
 *
 * @package Epfremme\FormTest\Tests\Form\Type
 */
class VariableTypeTest extends PHPUnit_Framework_TestCase
{
    use TwigEnvironmentTrait;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->formFactory = (new FormFactoryBuilder())->getFormFactory();
    }
    /**
     * @group Form
     */
    public function testBuild()
    {
        $form = $this->formFactory->create(VariableType::class, null, [
            VariableType::CONTENT_TYPES_KEY => [
                SimpleContentDefinition::class,
                ComplexContentDefinition::class,
            ]
        ]);

        echo $this->twig->render('variable_form_type.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
