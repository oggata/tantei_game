<?php
/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) Tests <https://trac.cakephp.org/wiki/Developement/TestSuite>
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 *  Licensed under The Open Group Test Suite License
 *  Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          https://trac.cakephp.org/wiki/Developement/TestSuite CakePHP(tm) Tests
 * @package       cake.tests
 * @subpackage    cake.tests.fixtures
 * @since         CakePHP(tm) v 1.2.0.4667
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
/**
 * Short description for class.
 *
 * @package       cake.tests
 * @subpackage    cake.tests.fixtures
 */
class CacheTestModelFixture extends CakeTestFixture {
/**
 * name property
 *
 * @var string 'CacheTestModel'
 * @access public
 */
	var $name = 'CacheTestModel';
/**
 * fields property
 *
 * @var array
 * @access public
 */
	var $fields = array(
		'id'		=> array('type' => 'string', 'length' => 255, 'key' => 'primary'),
		'data'		=> array('type' => 'string', 'length' => 255, 'default' => ''),
		'expires'	=> array('type' => 'integer', 'length' => 10, 'default' => '0'),
	);
}

?>
