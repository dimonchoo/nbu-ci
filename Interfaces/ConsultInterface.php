<?php 

/**
* Правила, что должно быть в модуле консультации
*/
interface ConsultInterface
{
	const FB_TOKEN = '';
	
	const WRONG_DATA = 'Не корректно заполнено поле';
	const EMPTY_FIELD = 'Заполните пустое поле';
	const REQUIRED_FIELD = 'Поле обязательное к заполнению';
	const OK = 'Спасибо за обращение, в течении рабочего дня, мы свяжемся с Вами';
	const CB = 'Вы не прошли капчу на бота';

	//check for bad data
	public function validate();

	//send to email office@,.
	public function sendMail();

	//after succesfully sending sms to mail, we sent sms to FB too 
	public function sendToFb();

	//save to Database
	public function save();

	//check for capcha from google
	public function reCapcha($res);
}