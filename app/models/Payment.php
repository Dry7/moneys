<?php

class Payment extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'name' => 'required',
		'section' => 'required',
		'category' => 'required',
		'company' => 'required',
		'summ' => 'required'
	);
}
