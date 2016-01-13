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

        $this->middleware('check-project-permissions', ['except' => ['show', 'index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($projectId)
    {
        return $this->service->getFiles($projectId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $projectId)
    {
        $data = [
            'file' => $request->file('file'),
            'extension' => $request->file('file')->getClientOriginalExtension(),
            'name' => $request->name,
            'description' => $request->description,
            'project_id' => $projectId
        ];

        return $this->service->create($data);
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
        $data = [
            'name' => $request->name,
            'description' => $request->description
        ];

        return $this->service->update($data, $id);
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

    public function showFile($projectId, $id)
    {
        $filePath = $this->service->getFilePath($id);
        $fileContent = file_get_contents($filePath);
        $file64 = base64_encode($fileContent);

        return [
            'file' => $file64,
            'size' => filesize($filePath),
            'name' => basename($filePath)
            // 'name' => $this->service->getFileName($id)
        ];
    }
}
