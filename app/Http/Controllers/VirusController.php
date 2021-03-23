<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVirusRequest;
use App\Models\Virus;
use App\Repositories\Interfaces\VirusInterface;
use Illuminate\Http\Request;

class VirusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $virus;

    public function __construct(VirusInterface $virus)
    {
        $this->virus = $virus;
    }

    public function index(Request $request)
    {
        if ($request->ajax())
            return $this->virus->get();
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVirusRequest $request)
    {
        $this->virus->store($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Virus $virus
     * @return \Illuminate\Http\Response
     */
    public function show(Virus $virus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Virus $virus
     * @return \Illuminate\Http\Response
     */
    public function edit(Virus $virus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Virus $virus
     * @return \Illuminate\Http\Response
     */
    public function update(StoreVirusRequest $request, $virus)
    {
        return $this->virus->update($virus,$request->only('name', 'tmp_tags'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Virus $virus
     * @return \Illuminate\Http\Response
     */
    public function destroy($virus)
    {
        $this->virus->delete($virus);
    }
}
