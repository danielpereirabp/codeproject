<?php

namespace CodeProject\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ProjectValidator extends LaravelValidator
{
	protected $rules = [
		ValidatorInterface::RULE_CREATE => [
			'owner_id'  => 'required',
			'client_id' => 'required',
			'name'      => 'required|max:255',
			'progress'  => 'required',
			'status'    => 'required',
			'due_date'  => 'required'
		],
		ValidatorInterface::RULE_UPDATE => [
			'owner_id'  => 'sometimes|required',
			'client_id' => 'sometimes|required',
			'name'      => 'sometimes|required|max:255',
			'progress'  => 'sometimes|required',
			'status'    => 'sometimes|required',
			'due_date'  => 'sometimes|required',
        ]
	];
}