<?php

/**
 * This file is part of the Sulaeman Checkout Unique Grand Total package.
 *
 * @author Sulaeman <me@sulaeman.com>
 * @package Sulaeman_CheckoutUniqueGrandTotal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sulaeman\CheckoutUniqueGrandTotal\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

use Sulaeman\CheckoutUniqueGrandTotal\Model\UniqueNumber;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $connection = $installer->getConnection();

        /**
         * Add columns to table 'quote'
         */
        $table = $installer->getTable('quote');

        $columns = [
            UniqueNumber::FIELD => [
                'type'    => Table::TYPE_INTEGER,
                'default' => '0',
                'comment' => 'Unique number'
            ]
        ];

        foreach ($columns as $name => $definition) {
            $connection->addColumn($table, $name, $definition);
        }

        /**
         * Add columns to table 'sales_order'
         */
        $table = $installer->getTable('sales_order');

        $columns = [
            UniqueNumber::FIELD => [
                'type'    => Table::TYPE_INTEGER,
                'default' => '0',
                'comment' => 'Unique number'
            ]
        ];

        foreach ($columns as $name => $definition) {
            $connection->addColumn($table, $name, $definition);
        }

        /**
         * Add columns to table 'sales_order'
         */
        $table = $installer->getTable('sales_invoice');

        $columns = [
            UniqueNumber::FIELD => [
                'type'    => Table::TYPE_INTEGER,
                'default' => '0',
                'comment' => 'Unique number'
            ]
        ];

        foreach ($columns as $name => $definition) {
            $connection->addColumn($table, $name, $definition);
        }

        $installer->endSetup();
    }
}
