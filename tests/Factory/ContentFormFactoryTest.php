<?php
/**
 * File ContentFormFactoryTest.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\FormTest\Tests\Factory;

use Epfremme\FormTest\Factory\ContentFormFactory;
use Epfremme\FormTest\Tests\_mixins\TwigEnvironmentTrait;
use Epfremme\FormTest\Tests\ComplexContentDefinition;
use Epfremme\FormTest\Tests\SimpleContentDefinition;
use Mockery as m;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormFactoryBuilder;
use Symfony\Component\Form\ResolvedFormTypeInterface;

/**
 * Class ContentFormFactoryTest
 *
 * @package Epfremme\FormTest\Tests\Factory
 */
class ContentFormFactoryTest extends PHPUnit_Framework_TestCase
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
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        m::close();
    }

    /**
     * @group Factory
     */
    public function testConstruct()
    {
        $factory = new ContentFormFactory($this->formFactory);

        $this->assertAttributeInstanceOf(FormFactoryInterface::class, 'formFactory', $factory);
    }

    /**
     * @group Factory
     */
    public function testBuildSimpleContentForm()
    {
        $factory = new ContentFormFactory($this->formFactory);

        $builder = $factory->build($definition = new SimpleContentDefinition());

        $this->assertInstanceOf(FormBuilderInterface::class, $builder);
        $this->assertCount(2, $builder);
        $this->assertInstanceOf(FormBuilderInterface::class, $builder->get('field_1'));
        $this->assertInstanceOf(FormBuilderInterface::class, $builder->get('field_2'));
        $this->assertInstanceOf(ResolvedFormTypeInterface::class, $builder->get('field_1')->getType());
        $this->assertInstanceOf(ResolvedFormTypeInterface::class, $builder->get('field_2')->getType());
        $this->assertInstanceOf(Type\TextType::class, $builder->get('field_1')->getType()->getInnerType());
        $this->assertInstanceOf(Type\CheckboxType::class, $builder->get('field_2')->getType()->getInnerType());

        $form = $builder->getForm();

        $this->assertInstanceOf(Form::class, $form);
        $this->assertInstanceOf(Form::class, $form->get('field_1'));
        $this->assertInstanceOf(Form::class, $form->get('field_2'));

        echo $this->twig->render($definition->getTemplate(), [
            'form' => $form->createView()
        ]);
    }

    /**
     * @group Factory
     */
    public function testBuildComplexContentForm()
    {
        $factory = new ContentFormFactory($this->formFactory);

        $builder = $factory->build($definition = new ComplexContentDefinition());

        $this->assertInstanceOf(FormBuilderInterface::class, $builder);
        $this->assertCount(3, $builder);
        $this->assertInstanceOf(FormBuilderInterface::class, $builder->get('field_1'));
        $this->assertInstanceOf(FormBuilderInterface::class, $builder->get('field_2'));
        $this->assertInstanceOf(FormBuilderInterface::class, $builder->get('field_3'));
        $this->assertInstanceOf(ResolvedFormTypeInterface::class, $builder->get('field_1')->getType());
        $this->assertInstanceOf(ResolvedFormTypeInterface::class, $builder->get('field_2')->getType());
        $this->assertInstanceOf(ResolvedFormTypeInterface::class, $builder->get('field_3')->getType());
        $this->assertInstanceOf(Type\TextType::class, $builder->get('field_1')->getType()->getInnerType());
        $this->assertInstanceOf(Type\CheckboxType::class, $builder->get('field_2')->getType()->getInnerType());
        $this->assertInstanceOf(Type\FormType::class, $builder->get('field_3')->getType()->getInnerType());

        $subFormBuilder = $builder->get('field_3');

        $this->assertInstanceOf(FormBuilderInterface::class, $subFormBuilder->get('field_1'));
        $this->assertInstanceOf(FormBuilderInterface::class, $subFormBuilder->get('field_2'));
        $this->assertInstanceOf(ResolvedFormTypeInterface::class, $subFormBuilder->get('field_1')->getType());
        $this->assertInstanceOf(ResolvedFormTypeInterface::class, $subFormBuilder->get('field_2')->getType());
        $this->assertInstanceOf(Type\TextType::class, $subFormBuilder->get('field_1')->getType()->getInnerType());
        $this->assertInstanceOf(Type\CheckboxType::class, $subFormBuilder->get('field_2')->getType()->getInnerType());

        $form = $builder->getForm();

        $this->assertInstanceOf(Form::class, $form);
        $this->assertInstanceOf(Form::class, $form->get('field_1'));
        $this->assertInstanceOf(Form::class, $form->get('field_2'));
        $this->assertInstanceOf(Form::class, $form->get('field_3'));
        $this->assertInstanceOf(Form::class, $form->get('field_3')->get('field_1'));
        $this->assertInstanceOf(Form::class, $form->get('field_3')->get('field_2'));

        echo $this->twig->render($definition->getTemplate(), [
            'form' => $form->createView()
        ]);
    }
}
