<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductsFixture
 */
class ProductsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 'c6c4c0fd-b25e-4c91-8a72-fab664973e4d',
                'name' => 'Lorem ipsum dolor sit amet',
                'modified' => '2025-06-16 16:23:29',
                'created' => '2025-06-16 16:23:29',
            ],
        ];
        parent::init();
    }
}
