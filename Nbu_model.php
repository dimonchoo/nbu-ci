<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Interfaces/NbuInterface.php';
use Dimonchoo\NbuInterface as NBU;

class Nbu_model extends CI_Model implements NBU {

	public function __construct()
	{
			parent::__construct();
			// $this->output->enable_profiler(TRUE);
		}
	
	public function getJsonFromFile($file){
		return file_get_contents($file);
	}

	public function getResourceJson()
	{
		return file_get_contents(self::CUR_DATE_JSON);
	}

	public function getResourceXml()
	{
		return file_get_contents(self::CUR_DATE_XML);
	}
	
	public function checkFile()
	{
		if (!file_exists('./nbu'))
			mkdir('./nbu');

		$file = './nbu/'. date('d.m.Y') . '.json';
		if (file_exists($file))
			return $this->getJsonFromFile($file);
		else{
			$getREs = $this->getResourceJson();
				if (!empty($getREs) && file_put_contents($file, $getREs) !== false ){
					return $this->getJsonFromFile($file);
				}
				else{
					return $this->getResourceJson();
				}
			}		
	}

	public function toArray()
	{
		return json_decode($this->checkFile());
	}

	public function currency($cur){
		foreach ($this->toArray() as $value) {
			if (in_array($value->cc, $cur)) {
				$currencies[$value->cc] = array(
						'currency_ua_name' => $value->txt, 
						'currency_num' => (float) preg_replace('/[^0-9.]/', '', mb_substr($value->rate, 0, 5), ), 
						'currency_full_num' => (float) preg_replace('/[^0-9.]/', '', $value->rate), 
						'currency_name' => $value->cc,
						'currency_date' => $value->exchangedate
					);
			}
		}
		if (!is_null($currencies) && !empty($currencies)) {
			$this->insertCurrency($currencies['USD']['currency_num'], $currencies['EUR']['currency_num']);
			return $currencies;
		}else{
			return null;
		}
	}

	public function selectDbLastDay()
	{
		$last_day = date("d", time() - 60 * 60 * 24);
		$query = $this->db->select('*')
		->where('currency_date', date($last_day.'.m.Y'))
		->get('currency');

		foreach ($query->result_array() as $value) {
			if ($query->num_rows()	 == 0)
				return false;
			else
				return $query->result_array();
		}
	}

	public function selectDb()
	{
		$query = $this->db->select('*')
		->where('currency_date', date('d.m.Y'))
		->get('currency');

		foreach ($query->result_array() as $value) {
			if ($query->num_rows()	 == 0)
				return false;
			else
				return $query->result_array();
		}
	}

	public function showAllCurrencies()
	{
		foreach ($this->toArray() as $value) {
			echo $value->txt. ' => ' . $value->cc . '</br>'. "\n\r";
		}
	}

	public function selectCurrency()
	{
		$query = $this->db->select('*')
		->where('currency_date', date('d.m.Y'))
		->get('currency');

		return $query->result_array();
	}

	public function currencyHistory()
	{
		$query = $this->db->select('*')
		->limit(30)
		->order_by('id', 'DESC')
		->get('currency');

		return $query->result_array();
	}

	public function insertCurrency($usd, $euro)
	{
		$query = $this->db->insert('currency', array(
			'currency_num_USD'  => $usd, 
			'currency_num_EURO' => $euro,
			'currency_date' => date('d.m.Y')
			));
	}
	
	// public function updateCurrency()
	// {
	// 	$query = $this->db->update('currency', array(
	// 		'currency_num_USD'  => $this->input->post('currency_num_USD'), 
	// 		'currency_num_EURO' => $this->input->post('currency_num_EURO'),
	// 		'currency_date' => date('d.m.Y')
	// 		), 'id=1');
	// }

}
