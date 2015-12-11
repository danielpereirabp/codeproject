<?php

namespace CodeProject\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ProjectFileValidator extends LaravelValidator
{
	protected $rules = [
		'project_id' => 'required|integer',
        'file'=> 'required',
        'name'=> 'required'
	];
}