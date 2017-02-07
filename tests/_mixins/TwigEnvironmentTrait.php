<?php
/**
 * File TwigEnvironmentTrait.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\FormTest\Tests\_mixins;

use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Bridge\Twig\Tests\Extension\Fixtures\StubTranslator;
use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_RuntimeLoaderInterface;

/**
 * Class TwigEnvironmentTrait
 *
 * @package Epfremme\FormTest\Tests\_mixins
 */
trait TwigEnvironmentTrait
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @before
     */
    public function setupTwig()
    {
        $twigLoader = new Twig_Loader_Filesystem(['tests/_templates'], __DIR__ . '/../../');
        $twigLoader->addPath('src/Resources/views/Form', 'FormTest');
        $twigLoader->addPath('vendor/symfony/twig-bridge/Resources/views/Form');

        $this->twig = $twig = new Twig_Environment($twigLoader, ['cache' => false]);

        $this->twig->addExtension(new FormExtension());
        $this->twig->addExtension(new TranslationExtension(new StubTranslator()));
        $this->twig->addRuntimeLoader(new class ($twig) implements Twig_RuntimeLoaderInterface {
            /**
             * @var Twig_Environment
             */
            private $environment;

            /**
             * Runtime Loader Constructor
             *
             * @param Twig_Environment $environment
             */
            public function __construct(Twig_Environment $environment)
            {
                $this->environment = $environment;
            }

            /**
             * {@inheritdoc}
             */
            public function load($class)
            {
                return new TwigRenderer(new TwigRendererEngine([
                    '@FormTest/form_div_layout.html.twig',
                ], $this->environment));
            }
        });
    }
}
