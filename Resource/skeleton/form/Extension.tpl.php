<?= "<?php\n" ?>

namespace <?= $namespace ?>;

<?php if ($extended_full_class_name): ?>
use <?= $extended_full_class_name ?>;
<?php endif ?>
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class <?= $class_name ?> extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'constraints' => [
                new NotBlank(),
                new Length(['max' => 255]),
            ],
        ]);
    }

    /**
    * {@inheritdoc}
    */
    public function getExtendedType()
    {
        return <?php echo $extended_class_name;?>::class;
    }
}
