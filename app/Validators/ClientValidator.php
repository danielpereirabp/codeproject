<?php

namespace CodeProject\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ClientValidator extends LaravelValidator
{
	protected $rules = [
		ValidatorInterface::RULE_CREATE => [
			'name'        => 'required|max:255',
			'responsible' => 'required|max:255',
			'email'       => 'required|email',
			'phone'       => 'required',
			'address'     => 'required'
		],
		ValidatorInterface::RULE_UPDATE => [
			'name'        => 'sometimes|required|max:255',
			'responsible' => 'sometimes|required|max:255',
			'email'       => 'sometimes|required|email',
			'phone'       => 'sometimes|required',
			'address'     => 'sometimes|required'
        ]
	];
}