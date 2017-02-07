<?php
/**
 * File index.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */

use Epfremme\FormTest\Form\Type\VariableType;
use Epfremme\FormTest\Tests\_mixins\TwigEnvironmentTrait;
use Epfremme\FormTest\Tests\ComplexContentDefinition;
use Epfremme\FormTest\Tests\SimpleContentDefinition;
use Symfony\Component\Form\FormFactoryBuilder;

require_once 'vendor/autoload.php';

$twig = new class {
    use TwigEnvironmentTrait;

    public function render()
    {
        if (!$this->twig) {
            $this->setupTwig();
        }

        $args = func_get_args();

        return call_user_func_array([$this->twig, 'render'], $args);
    }
};

$formFactory = (new FormFactoryBuilder())->getFormFactory();

$form = $formFactory->create(VariableType::class, null, [
    VariableType::CONTENT_TYPES_KEY => [
        SimpleContentDefinition::class,
        ComplexContentDefinition::class,
    ]
]);

$html = $twig->render('variable_form_type.html.twig', [
    'form' => $form->createView()
]);

?>
<body>
    <?php echo $html; ?>
</body>
