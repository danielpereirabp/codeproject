<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;

use CodeProject\Services\ProjectFileService;

class ProjectFileController extends Controller
{
    /**
    * @var ProjectService
    */
    private $service;

    public function __construct(ProjectFileService $service)
    {
        $this->service = $service;

        $this->middleware('check-project-owner');
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

        return $this->service->create($data);
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
