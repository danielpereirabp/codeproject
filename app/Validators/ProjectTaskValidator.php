<?php

namespace CodeProject\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ProjectTaskValidator extends LaravelValidator
{
	protected $rules = [
		ValidatorInterface::RULE_CREATE => [
			'project_id' => 'required',
			'name'       => 'required|max:255',
			'status'     => 'required'
		],
		ValidatorInterface::RULE_UPDATE => [
			'project_id' => 'sometimes|required',
			'name'       => 'sometimes|required|max:255',
			'start_date' => 'sometimes|required',
			'due_date'   => 'sometimes|required',
			'status'     => 'sometimes|required'
        ]
	];
}