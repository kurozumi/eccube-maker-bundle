<?php echo "<?php\n"; ?>

namespace <?php echo $namespace; ?>;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Entity\AbstractEntity;

if(!class_exists(<?php echo $class_name; ?>::class)) {
    /**
    * @ORM\Table(name="<?php echo $table_name; ?>")
    * @ORM\Entity(repositoryClass="<?php echo $repository_full_class_name; ?>")
    * @ORM\InheritanceType("SINGLE_TABLE")
    * @ORM\DiscriminatorColumn(name="discriminator_type", type="string", length=255)
    * @ORM\HasLifecycleCallbacks()
    */
    class <?php echo $class_name; ?> extends AbstractEntity
    {
        /**
        * @var int
        *
        * @ORM\Column(name="id", type="integer", options={"unsigned":true})
        * @ORM\Id()
        * @ORM\GeneratedValue(strategy="IDENTITY")
        */
        private $id;

        public function getId(): int
        {
            return $this->id;
        }
    }
}
