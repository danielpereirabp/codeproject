<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

use CodeProject\Entities\User;
use CodeProject\Presenters\UserPresenter;

class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
	protected $fieldSearchable = [
		'name'
	];

	public function model()
	{
		return User::class;
	}

	public function presenter()
    {
        return UserPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria( app(RequestCriteria::class) );
    }
}