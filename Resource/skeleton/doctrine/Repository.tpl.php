<?php echo "<?php\n"; ?>

namespace <?php echo $namespace; ?>;

use <?php echo $entity_full_class_name; ?>;
use Doctrine\Persistence\ManagerRegistry;
use Eccube\Repository\AbstractRepository;

class <?php echo $class_name; ?> extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, <?php echo $entity_class_name; ?>::class);
    }
}
