<?php
/* SVN FILE: $Id$ */
/**
 * DboSqlite test
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs
 * @since         CakePHP(tm) v 1.2.0
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
App::import('Core', array('Model', 'DataSource', 'DboSource', 'DboSqlite'));

/**
 * Short description for class.
 *
 * @package       cake.tests
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class DboSqliteTestDb extends DboSqlite {
/**
 * simulated property
 *
 * @var array
 * @access public
 */
	var $simulated = array();
/**
 * execute method
 *
 * @param mixed $sql
 * @access protected
 * @return void
 */
	function _execute($sql) {
		$this->simulated[] = $sql;
		return null;
	}
/**
 * getLastQuery method
 *
 * @access public
 * @return void
 */
	function getLastQuery() {
		return $this->simulated[count($this->simulated) - 1];
	}
}
/**
 * The test class for the DboPostgres
 *
 * @package       cake.tests
 * @subpackage    cake.tests.cases.libs.model.datasources.dbo
 */
class DboSqliteTest extends CakeTestCase {
/**
 * Do not automatically load fixtures for each test, they will be loaded manually using CakeTestCase::loadFixtures
 *
 * @var boolean
 * @access public
 */
	var $autoFixtures = false;
/**
 * Fixtures
 *
 * @var object
 * @access public
 */
	var $fixtures = array('core.user');
/**
 * Actual DB connection used in testing
 *
 * @var object
 * @access public
 */
	var $db = null;
/**
 * Simulated DB connection used in testing
 *
 * @var object
 * @access public
 */
	var $db2 = null;
/**
 * Skip if cannot connect to SQLite
 *
 * @access public
 */
	function skip() {
		$this->_initDb();
		$this->skipif($this->db->config['driver'] != 'sqlite', 'SQLite connection not available');
	}
/**
 * Set up test suite database connection
 *
 * @access public
 */
	function startTest() {
		$this->_initDb();
	}
/**
 * Sets up a Dbo class instance for testing
 *
 * @access public
 */
	function setUp() {
		Configure::write('Cache.disable', true);
		$this->startTest();
		$this->db =& ConnectionManager::getDataSource('test_suite');
		$this->db2 = new DboSqliteTestDb($this->db->config, false);
	}
/**
 * Sets up a Dbo class instance for testing
 *
 * @access public
 */
	function tearDown() {
		Configure::write('Cache.disable', false);
		unset($this->db2);
	}
/**
 * Tests that SELECT queries from DboSqlite::listSources() are not cached
 *
 * @access public
 */
	function testTableListCacheDisabling() {
		$this->assertFalse(in_array('foo_test', $this->db->listSources()));

		$this->db->query('CREATE TABLE foo_test (test VARCHAR(255));');
		$this->assertTrue(in_array('foo_test', $this->db->listSources()));

		$this->db->query('DROP TABLE foo_test;');
		$this->assertFalse(in_array('foo_test', $this->db->listSources()));
	}
/**
 * test Index introspection.
 *
 * @access public
 * @return void
 */	
	function testIndex() {
		$name = $this->db->fullTableName('with_a_key');
		$this->db->query('CREATE TABLE ' . $name . ' ("id" int(11) PRIMARY KEY, "bool" int(1), "small_char" varchar(50), "description" varchar(40) );');
		$this->db->query('CREATE INDEX pointless_bool ON ' . $name . '("bool")');
		$this->db->query('CREATE UNIQUE INDEX char_index ON ' . $name . '("small_char")');
		$expected = array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'pointless_bool' => array('column' => 'bool', 'unique' => 0),
			'char_index' => array('column' => 'small_char', 'unique' => 1),
			
		);
		$result = $this->db->index($name);
		$this->assertEqual($expected, $result);
		$this->db->query('DROP TABLE ' . $name);
		
		$this->db->query('CREATE TABLE ' . $name . ' ("id" int(11) PRIMARY KEY, "bool" int(1), "small_char" varchar(50), "description" varchar(40) );');
		$this->db->query('CREATE UNIQUE INDEX multi_col ON ' . $name . '("small_char", "bool")');
		$expected = array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'multi_col' => array('column' => array('small_char', 'bool'), 'unique' => 1),
		);
		$result = $this->db->index($name);
		$this->assertEqual($expected, $result);
		$this->db->query('DROP TABLE ' . $name);
	}

/**
 * Tests that cached table descriptions are saved under the sanitized key name
 *
 * @access public
 */
	function testCacheKeyName() {
		Configure::write('Cache.disable', false);

		$dbName = 'db' . rand() . '$(*%&).db';
		$this->assertFalse(file_exists(TMP . $dbName));

		$config = $this->db->config;
		$db = new DboSqlite(array_merge($this->db->config, array('database' => TMP . $dbName)));
		$this->assertTrue(file_exists(TMP . $dbName));

		$db->execute("CREATE TABLE test_list (id VARCHAR(255));");

		$db->cacheSources = true;
		$this->assertEqual($db->listSources(), array('test_list'));
		$db->cacheSources = false;

		$fileName = '_' . preg_replace('/[^A-Za-z0-9_\-+]/', '_', TMP . $dbName) . '_list';
		
		$result = Cache::read($fileName, '_cake_model_');
		$this->assertEqual($result, array('test_list'));

		Cache::delete($fileName, '_cake_model_');
		Configure::write('Cache.disable', true);
	}
}

?>