<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductFieldsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductFieldsTable Test Case
 */
class ProductFieldsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductFieldsTable
     */
    protected $ProductFields;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.ProductFields',
        'app.Products',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ProductFields') ? [] : ['className' => ProductFieldsTable::class];
        $this->ProductFields = $this->getTableLocator()->get('ProductFields', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ProductFields);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ProductFieldsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
