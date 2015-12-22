<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;

use CodeProject\Services\ProjectNoteService;

class ProjectNoteController extends Controller
{
    /**
    * @var ProjectNoteService
    */
    private $service;

    public function __construct(ProjectNoteService $service)
    {
        $this->service = $service;

        $this->middleware('check-project-permissions', ['except' => ['show', 'index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($projectId)
    {
        return $this->service->all($projectId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $projectId
     * @param  int  $id
     * @return Response
     */
    public function show($projectId, $id)
    {
        return $this->service->find($projectId, $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $projectId, $id)
    {
        return $this->service->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($projectId, $id)
    {
        return $this->service->delete($projectId, $id);
    }
}
