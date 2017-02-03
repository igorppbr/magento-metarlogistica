<?php
/**
 * @package     Igorludgero_Metarlogistica
 * @author      Igor Ludgero Miura
 * @copyright   Igor Ludgero Miura - https://www.igorludgero.com/ - igor@igorludgero.com
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('metarlogistica_cotacoes'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'ID')
    ->addColumn('cidade', Varien_Db_Ddl_Table::TYPE_VARCHAR, 0, array(
        'nullable'  => false,
    ), 'Nome da Cidade.')
    ->addColumn('uf', Varien_Db_Ddl_Table::TYPE_VARCHAR, 0, array(
        'nullable'  => false,
    ), 'UF da Cidade.')
    ->addColumn('tipo_cidade', Varien_Db_Ddl_Table::TYPE_INTEGER, 0, array(
        'nullable'  => false,
    ), '1 - Capital, 2 - Interior.')
    ->addColumn('cep_inicio', Varien_Db_Ddl_Table::TYPE_VARCHAR, 0, array(
        'nullable'  => false,
    ), 'Primeiro CEP da Faixa.')
    ->addColumn('cep_fim', Varien_Db_Ddl_Table::TYPE_VARCHAR, 0, array(
        'nullable'  => false,
    ), 'Último CEP da Faixa.')
    ->addColumn('prazo', Varien_Db_Ddl_Table::TYPE_INTEGER, 0, array(
        'nullable'  => false,
    ), 'Prazo de Entrega');

$installer->getConnection()->createTable($table);

$table = $installer->getConnection()
    ->newTable($installer->getTable('metarlogistica_cotacoes_precos'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'ID')
    ->addColumn('uf', Varien_Db_Ddl_Table::TYPE_VARCHAR, 0, array(
        'nullable'  => false,
    ), 'UF.')
    ->addColumn('tipo', Varien_Db_Ddl_Table::TYPE_INTEGER, 0, array(
        'nullable'  => false,
    ), '(1 - Capital, 2 - Interior.')
    ->addColumn('peso_min', Varien_Db_Ddl_Table::TYPE_FLOAT, 0, array(
        'nullable'  => false,
    ), 'Peso Mínimo.')
    ->addColumn('peso_max', Varien_Db_Ddl_Table::TYPE_FLOAT, 0, array(
        'nullable'  => false,
    ), 'Peso Máximo.')
    ->addColumn('valor', Varien_Db_Ddl_Table::TYPE_FLOAT, 0, array(
        'nullable'  => false,
    ), 'Valor.')
    ->addColumn('excedente', Varien_Db_Ddl_Table::TYPE_FLOAT, 0, array(
        'nullable'  => true,
    ), 'Valor por Kg Excedente.');

$installer->getConnection()->createTable($table);

$installer->endSetup();