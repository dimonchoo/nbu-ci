<?php 

namespace Dimonchoo;
/**
* Правила, что должно быть в модуле консультации
*/
interface NbuInterface
{
	
	//Текущий курс, на текущую дату в json и xml
	const CUR_DATE_JSON = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json';
	const CUR_DATE_XML = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?xml';

	//Взять данные из ресурса Json
	/**
	 * @return string
	 */
	public function getResourceJson();

	//Взять данные из ресурса Xml
	/**
	 * @return string
	 */
	public function getResourceXml();

	// переводим json в масив объектов
	/**
	 * @return array( [objects] )
	 */
	public function toArray();
	
	// Возвращаем массив данных с указанной валютой
	// !!!! Требует указание необходимых валют в массиве !!!! 
	/**
	 * @return array
	 */
	public function currency($cur);

	/**
	 * Показать все курсы валют в формате "Кирилическое название" => "валюта"
	 * Например : "Донг" => "VND" 
	 * @return [string]
	 */
	public function showAllCurrencies();

	/**
	 * Что бы не посылать запрос каждый раз при перезагрузке страницы(так как довольно таки долгий интервал).
	 * Я запихал json в файл. И если файл с сегодняшним днем существует в директории, то читаем его, иначе 
	 * если дата меняется, посылается запрос к джсон данным которые пихаються в файл с названием 
	 * сегодняшней даты. Если у вас нету папки "nbu" то она создасться.    
	 * @return [type] [description]
	 */
	public function checkFile();
}