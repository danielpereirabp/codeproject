<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;

use CodeProject\Services\ProjectMemberService;

class ProjectMemberController extends Controller
{
    /**
    * @var ProjectMemberService
    */
    private $service;

    public function __construct(ProjectMemberService $service)
    {
        $this->service = $service;

        $this->middleware('check-project-owner', ['except' => ['show', 'index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($projectId)
    {
        return $this->service->getMembers($projectId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $projectId)
    {
        $data = $request->all();
        $data['project_id'] = $projectId;

        return $this->service->addMember($data);
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
        return $this->service->getMember($projectId, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($projectId, $id)
    {
        return $this->service->removeMember($projectId, $id);
    }
}
