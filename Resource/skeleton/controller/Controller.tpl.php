<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

use Eccube\Controller\<?= $parent_class_name; ?>;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

class <?= $class_name; ?> extends <?= $parent_class_name; ?><?= "\n" ?>
{
    /**
     * @Route("<?= $route_path ?>", name="<?= $route_name ?>")
     * @Template("<?= $template_name ?>")
     */
    public function index()
    {
<?php if ($with_template) { ?>
        return [
            'controller_name' => '<?= $class_name ?>',
        ];
<?php } else { ?>
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => '<?= $relative_path; ?>',
        ]);
<?php } ?>
    }
}
