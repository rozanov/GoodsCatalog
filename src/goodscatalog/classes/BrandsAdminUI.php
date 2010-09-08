<?php
/**
 * Каталог товаров
 *
 * Интерфейс управления брендами
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
 *
 * $Id$
 */


/**
 * Интерфейс управления брендами
 *
 * @package GoodsCatalog
 */
class GoodsCatalogBrandsAdminUI
{
	/**
	 * Объект плагина
	 *
	 * @var GoodsCatalog
	 */
	private $plugin;

	/**
	 * Конструктор
	 *
	 * @param GoodsCatalog $plugin
	 *
	 * @return GoodsCatalogBrandsAI
	 */
	public function __construct(GoodsCatalog $plugin)
	{
		$this->plugin = $plugin;
	}
	//-----------------------------------------------------------------------------

	/**
	 * Возвращает HTML интерфейса управления брендами
	 *
	 * @return string
	 */
	public function getHTML()
	{
		switch (true)
		{
			case arg('action') == 'add':
				$html = $this->renderAddDialog();
			break;

			case arg('action') == 'insert':
				$this->addItem();
			break;

			default:
				$html = $this->renderList();
			break;
		}

		// Дополнительные стили
		$GLOBALS['page']->linkStyles($this->plugin->getCodeURL() . 'admin.css');

		return $html;
	}
	//-----------------------------------------------------------------------------

	/**
	 * Возвращает разметку интерфейса списка брендов
	 *
	 * @return string  HTML
	 *
	 * @since 1.00
	 */
	private function renderList()
	{
		// Данные для подстановки в шаблон
		$data = $this->plugin->getHelper()->prepareTmplData();

		// Создаём экземпляр шаблона
		$tmpl = $this->plugin->getHelper()->getAdminTemplate('brands-list.html');

		// Компилируем шаблон и данные
		$html = $tmpl->compile($data);

		return $html;
	}
	//-----------------------------------------------------------------------------

	/**
	 * Возвращает разметку диалога добавления бренда
	 *
	 * @return string  HTML
	 *
	 * @since 1.00
	 */
	private function renderAddDialog()
	{
		/*
		 * Имитируем использование старых форм на основе массивов.
		 * Это требуется для правильного подключения WYSIWYG.
		 */
		$wysiwyg = $GLOBALS['Eresus']->extensions->load('forms', 'html');
		$fakeForm = array('values' => array());
		$fakeField = array(
			'name' => 'description',
			'value' => '',
			'label' => '',
			'height' => null,
		);
		$wysiwyg->forms_html($fakeForm, $fakeField);

		// Данные для подстановки в шаблон
		$data = $this->plugin->getHelper()->prepareTmplData();

		// Создаём экземпляр шаблона
		$tmpl = $this->plugin->getHelper()->getAdminTemplate('brands-add.html');

		// Компилируем шаблон и данные
		$html = $tmpl->compile($data);

		return $html;
	}
	//-----------------------------------------------------------------------------

	/**
	 * Добавляет бренд
	 *
	 * @return void
	 *
	 * @since 1.00
	 * @uses HTTP::redirect
	 */
	private function addItem()
	{
		$brand = new GoodsCatalogBrand($this->plugin);
		$brand->title = arg('title');
		$brand->active = true;
		$brand->description = arg('description');
		$brand->save();
		HTTP::redirect('admin.php?mod=ext-' . $this->plugin->name . '&ref=brands');
	}
	//-----------------------------------------------------------------------------
}