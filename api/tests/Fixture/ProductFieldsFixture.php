<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductFieldsFixture
 */
class ProductFieldsFixture extends TestFixture
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
                'id' => 'daffe8a3-f254-4ae1-903c-38aa9625d51f',
                'name' => 'Lorem ipsum dolor sit amet',
                'type' => 'Lorem ipsum dolor sit amet',
                'is_localized' => 1,
                'modified' => '2025-06-16 16:23:39',
                'created' => '2025-06-16 16:23:39',
            ],
        ];
        parent::init();
    }
}
