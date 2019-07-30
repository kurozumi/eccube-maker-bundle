<?= "<?php\n" ?>

namespace <?= $namespace ?>;

<?php if ($api_resource): ?>use ApiPlatform\Core\Annotation\ApiResource;
<?php endif ?>
use Doctrine\ORM\Mapping as ORM;

/**
<?php if ($api_resource): ?> * @ApiResource()
<?php endif ?>
* @ORM\Entity(repositoryClass="<?= $repository_full_class_name ?>")
*/
class <?= $class_name; ?> extends \Eccube\Entity\AbstractEntity
{
    /**
    * @ORM\Column(name="id", type="integer", options={"unsigned":true})
    * @ORM\Id()
    * @ORM\GeneratedValue(strategy="IDENTITY")
    */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}