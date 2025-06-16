<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductsProductFieldsFixture
 */
class ProductsProductFieldsFixture extends TestFixture
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
                'id' => '11bfb573-40d0-49fc-8dbf-d7a7db66bb1e',
                'product_id' => '1a6324b1-00f8-4af3-8cdd-4d628b51871d',
                'product_field_id' => '075c4b31-e2c3-4df4-a63f-eebf8e95b370',
                'value' => 'Lorem ipsum dolor sit amet',
                'modified' => '2025-06-16 16:23:52',
                'created' => '2025-06-16 16:23:52',
            ],
        ];
        parent::init();
    }
}
