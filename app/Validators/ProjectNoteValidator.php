<?php

namespace CodeProject\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ProjectNoteValidator extends LaravelValidator
{
	protected $rules = [
		ValidatorInterface::RULE_CREATE => [
			'project_id' => 'required',
			'title' => 'required|max:255',
			'note' => 'required'
		],
		ValidatorInterface::RULE_UPDATE => [
			'project_id' => 'sometimes|required',
			'title' => 'sometimes|required',
			'note' => 'sometimes|required'
        ]
	];
}