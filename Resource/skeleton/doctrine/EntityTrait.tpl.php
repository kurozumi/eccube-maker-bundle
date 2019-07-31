<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation\EntityExtension;

/**
* @EntityExtension("<?= $entity_extension; ?>")
*/
trait <?= $class_name; ?>
{
}