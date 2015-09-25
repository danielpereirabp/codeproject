<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectFileController extends Controller
{
    /**
    * @var ProjectRepository
    */
    private $repository;

    /**
    * @var ProjectService
    */
    private $service;

    public function __construct(ProjectRepository $repository, ProjectService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->service->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = [
            'file' => $request->file('file'),
            'extension' => $request->file('file')->getClientOriginalExtension(),
            'name' => $request->name,
            'description' => $request->description,
            'project_id' => $request->project_id
        ];

        return $this->service->createFile($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        if ($this->checkProjectPermissions($id) == false) {
            return ['error' => 'Access Forbidden'];
        }

        return $this->service->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if ($this->checkProjectOwner($id) == false) {
            return ['error' => 'Access Forbidden'];
        }

        return $this->service->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
