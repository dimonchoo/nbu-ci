# nbu-ci

		$data['currency_history'] = $this->CI->nbu_model->currencyHistory();
		$selectDb = $this->CI->nbu_model->selectDb();
		$data['currency_file'] = $this->CI->nbu_model->currency(array('USD', 'EUR'));
		
		if (!empty($data['currency_file'])) {
			$data['currency_file'] = $data['currency_file'];
		}
		elseif (is_null($selectDb)) {
			$data['currency_db'] = $this->CI->nbu_model->selectDbLastDay();
		}
		else{
			$data['currency_db'] = $selectDb;
		}
