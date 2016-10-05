В процессе улучшения. Пока не доведено до ума!!!
# nbu-ci
## Позже объясню =)
### База, таблица с названием "currency"

	id	int(11) unsigned Автоматическое приращение	 
	currency_date	varchar(10)	 
	currency_num_USD	varchar(10)	 
	currency_num_EURO	varchar(10)

Для новых курсов придется допиливать вам, если хотите сохранение в базу. 

### Код контролера, определяем глобально.
Много шаманства происходит оттого что что НБУ после 00.00 отдает пустой json/xml и через это вылетают ошибки, так как даных нет. Поэтому если он пустой, будет выбираться данные из базы за предыдущий день. Иначе, данные записываються в файл, и запрашиваються уже с файла, для меньшего времени токлика и уменьшения доп. запрос к дб. 
Все берется с вашей бд, поэтому нужно что-бы там уже дежали данные.

		#### nbu_model->currencyHistory() - вывод предыщих дней курса.
		#### nbu_model->currency(array('USD', 'EUR')) - в масив вписываем все курсы которые нам нужны
		#### nbu_model->showAllCurrencies() - вывести все доступные курсы и их названия, это для ввода в предыдущ. метод.
		#### nbu_model->selectDbLastDay() - данные за предыдущий день

		
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
