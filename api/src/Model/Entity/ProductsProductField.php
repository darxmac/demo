<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductsProductField Entity
 *
 * @property string $id
 * @property string $product_id
 * @property string $product_field_id
 * @property string|null $value
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\ProductField $product_field
 */
class ProductsProductField extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'product_id' => true,
        'product_field_id' => true,
        'value' => true,
        'modified' => true,
        'created' => true,
        'product' => true,
        'product_field' => true,
    ];
}
