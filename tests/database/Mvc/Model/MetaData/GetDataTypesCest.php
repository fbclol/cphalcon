<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Tests\Database\Mvc\Model\MetaData;

use DatabaseTester;
use Phalcon\Mvc\Model\MetaData;
use Phalcon\Tests\Fixtures\Traits\DiTrait;
use Phalcon\Tests\Models\Invoices;

/**
 * Class GetDataTypesCest
 */
class GetDataTypesCest
{
    use DiTrait;

    public function _before(DatabaseTester $I)
    {
        $this->setNewFactoryDefault();
        $this->setDatabase($I);
    }

    /**
     * Tests Phalcon\Mvc\Model\MetaData :: getDataTypes()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-02-01
     *
     * @group  mysql
     * @group  pgsql
     * @group  sqlite
     */
    public function mvcModelMetadataGetDataTypes(DatabaseTester $I)
    {
        $I->wantToTest('Mvc\Model\MetaData - getDataTypes()');

        /** @var MetaData $metadata */
        $metadata = $this->container->get('modelsMetadata');

        $model    = new Invoices();
        $expected = $this->getTypes($I);
        $actual   = $metadata->getDataTypes($model);
        $I->assertEquals($expected, $actual);
    }

    private function getTypes(DatabaseTester $I)
    {
        $driver = $I->getDriver();
        switch ($driver) {
            case 'mysql':
                return [
                    'inv_id'          => 0,
                    'inv_cst_id'      => 0,
                    'inv_status_flag' => 26,
                    'inv_title'       => 2,
                    'inv_total'       => 7,
                    'inv_created_at'  => 4,
                ];
            case 'sqlite':
                return [
                    'inv_id'          => 0,
                    'inv_cst_id'      => 0,
                    'inv_status_flag' => 0,
                    'inv_title'       => 2,
                    'inv_total'       => 2,
                    'inv_created_at'  => 2,
                ];
            default:
                return [
                    'inv_id'          => 0,
                    'inv_cst_id'      => 0,
                    'inv_status_flag' => 22,
                    'inv_title'       => 2,
                    'inv_total'       => 3,
                    'inv_created_at'  => 17,
                ];
        }
    }
}
