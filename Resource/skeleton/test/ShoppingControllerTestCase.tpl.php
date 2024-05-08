<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

use Eccube\Tests\Web\AbstractShoppingControllerTestCase;

class <?= $class_name ?> extends AbstractShoppingControllerTestCase
{
    public function testSomething(): void
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Hello World', $crawler->filter('h1')->text());
    }
}
