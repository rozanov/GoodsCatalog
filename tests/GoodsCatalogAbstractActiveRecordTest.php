<?php
/**
 * Каталог товаров
 *
 * Модульные тесты
 *
 * @version ${product.version}
 *
 * @copyright 2010, ООО "Два слона", http://dvaslona.ru/
 * @license http://www.gnu.org/licenses/gpl.txt	GPL License 3
 * @author Михаил Красильников <mk@3wstyle.ru>
 *
 * Данная программа является свободным программным обеспечением. Вы
 * вправе распространять ее и/или модифицировать в соответствии с
 * условиями версии 3 либо (по вашему выбору) с условиями более поздней
 * версии Стандартной Общественной Лицензии GNU, опубликованной Free
 * Software Foundation.
 *
 * Мы распространяем эту программу в надежде на то, что она будет вам
 * полезной, однако НЕ ПРЕДОСТАВЛЯЕМ НА НЕЕ НИКАКИХ ГАРАНТИЙ, в том
 * числе ГАРАНТИИ ТОВАРНОГО СОСТОЯНИЯ ПРИ ПРОДАЖЕ и ПРИГОДНОСТИ ДЛЯ
 * ИСПОЛЬЗОВАНИЯ В КОНКРЕТНЫХ ЦЕЛЯХ. Для получения более подробной
 * информации ознакомьтесь со Стандартной Общественной Лицензией GNU.
 *
 * Вы должны были получить копию Стандартной Общественной Лицензии
 * GNU с этой программой. Если Вы ее не получили, смотрите документ на
 * <http://www.gnu.org/licenses/>
 *
 * @package GoodsCatalog
 * @subpackage Tests
 *
 * $Id$
 */

include_once dirname(__FILE__) . '/../src/goodscatalog/AbstractActiveRecord.php';

/**
 * @package GoodsCatalog
 * @subpackage Tests
 */
class GoodsCatalogAbstractActiveRecordTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Setup test enviroment
	 */
	protected function setUp()
	{
		$this->fixture = new GoodsCatalogAbstractActiveRecord_Stub(new GoodsCatalog());
	}
	//-----------------------------------------------------------------------------

	/**
	 * Проверяем вброс исключения EresusPropertyNotExistsException при обращении к несуществующему
	 * свойству.
	 *
	 * @expectedException EresusPropertyNotExistsException
	 */
	public function testGetUnexistentProperty()
	{
		$x = $this->fixture->unexistent;
	}
	//-----------------------------------------------------------------------------

	/**
	 * Проверяем чтение неустановленного свойства.
	 *
	 */
	public function testGetUnsetProperty()
	{
		$this->assertNull($this->fixture->id);
	}
	//-----------------------------------------------------------------------------

	/**
	 * Проверяем вброс исключения EresusPropertyNotExistsException при обращении к несуществующему
	 * свойству.
	 *
	 * @expectedException EresusPropertyNotExistsException
	 */
	public function testSetUnexistentProperty()
	{
		$this->fixture->unexistent = true;
	}
	//-----------------------------------------------------------------------------

	/**
	 * Проверяем установку и чтение
	 *
	 */
	public function testSetGet()
	{
		$this->fixture->id = 123;
		$this->assertEquals(123, $this->fixture->id);
	}
	//-----------------------------------------------------------------------------

	/**
	 * Проверяем isNew
	 *
	 */
	public function testIsNew()
	{
		$this->assertTrue($this->fixture->isNew());
	}
	//-----------------------------------------------------------------------------

	/* */
}

/**
 * @package GoodsCatalog
 * @subpackage Tests
 */
class GoodsCatalogAbstractActiveRecord_Stub extends GoodsCatalogAbstractActiveRecord
{
	/**
	 * Метод возвращает имя таблицы БД
	 *
	 * @return string  Имя таблицы БД
	 */
	protected function getTableName()
	{
		return 'brands';
	}
	//-----------------------------------------------------------------------------

	/**
	 * Метод возвращает список полей записи и их атрибуты
	 *
	 * @return array
	 */
	protected function getFieldAttrs()
	{
		return array(
			'id' => array(
				'type' => 'int',
			),
			'active' => array(
				'type' => 'bool',
			),
			'description' => array(
				'type' => 'string'
			),
			'ext' => array(
				'type' => 'string',
				'maxlength' => 4,
			),
		);
	}
	//-----------------------------------------------------------------------------
}



/**
 * @package GoodsCatalog
 * @subpackage Tests
 */
class GoodsCatalog
{
}

/**
 * @package GoodsCatalog
 * @subpackage Tests
 */
class EresusPropertyNotExistsException extends Exception
{
	function __construct($property = null, $class = null, $description = null, $previous = null)
	{
		;
	}
	//-----------------------------------------------------------------------------
}
