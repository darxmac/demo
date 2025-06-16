<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Behavior\Translate\ShadowTableStrategy;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductsProductFields Model
 *
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 * @property \App\Model\Table\ProductFieldsTable&\Cake\ORM\Association\BelongsTo $ProductFields
 *
 * @method \App\Model\Entity\ProductsProductField newEmptyEntity()
 * @method \App\Model\Entity\ProductsProductField newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ProductsProductField[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductsProductField get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProductsProductField findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ProductsProductField patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProductsProductField[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductsProductField|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProductsProductField saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProductsProductField[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ProductsProductField[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ProductsProductField[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ProductsProductField[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsProductFieldsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('products_product_fields');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
        ]);
        $this->belongsTo('ProductFields', [
            'foreignKey' => 'product_field_id',
        ]);

        $this->addBehavior('Translate', [
                'strategyClass' => ShadowTableStrategy::class,
                'fields'        => ['value']
            ]
        );
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->uuid('product_id')
            ->notEmptyString('product_id');

        $validator
            ->uuid('product_field_id')
            ->notEmptyString('product_field_id');

        $validator
            ->scalar('value')
            ->maxLength('value', 255)
            ->allowEmptyString('value');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('product_id', 'Products'), ['errorField' => 'product_id']);
        $rules->add($rules->existsIn('product_field_id', 'ProductFields'), ['errorField' => 'product_field_id']);

        return $rules;
    }
}
