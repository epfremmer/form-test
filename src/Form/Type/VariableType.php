<?php
/**
 * File VariableType.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\FormTest\Form\Type;

use Epfremme\FormTest\Factory\ContentFormFactory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\RuntimeException;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryBuilder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class VariableType
 *
 * @package Epfremme\FormTest\Form\Type
 */
class VariableType extends AbstractType
{
    const CONTENT_TYPES_KEY = 'content_types';
    const CONTENT_TYPE_FIELD = 'type';

    /**
     * @var ContentFormFactory
     */
    private $contentFormFactory;

    /**
     * VariableType constructor
     *
     * @param ContentFormFactory $contentFormFactory
     */
    public function __construct(ContentFormFactory $contentFormFactory = null)
    {
        $this->contentFormFactory = $contentFormFactory ?: new ContentFormFactory(
            (new FormFactoryBuilder())->getFormFactory()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $availableConfigurations = $options[self::CONTENT_TYPES_KEY];

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($availableConfigurations) {
            $form = $event->getForm();
            $data = $event->getData();

            if (!$form->isSubmitted()) {
                return;
            }

            if (!array_key_exists(self::CONTENT_TYPE_FIELD, $data)) {
                throw new RuntimeException('Missing content type in form data');
            }

            $type = $data[self::CONTENT_TYPE_FIELD];

            if (!in_array($type, $availableConfigurations)) {
                throw new RuntimeException(sprintf('Invalid form configuration %s submitted for form', $type));
            }

            $form->add('form', $this->contentFormFactory->build($type));
        });
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $availableConfigurations = $options[self::CONTENT_TYPES_KEY];

        $view->vars['prototypes'] = [];

        foreach ($availableConfigurations as $configuration) {
            $prototype = $this->contentFormFactory->build(new $configuration());
            $prototype->add(self::CONTENT_TYPE_FIELD, HiddenType::class, [
                'data' => $configuration,
                'mapped' => false
            ]);

            $view->vars['prototypes'][$configuration] = $prototype->getForm()->createView($view);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault(self::CONTENT_TYPES_KEY, []);
    }
}
