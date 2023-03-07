<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrioritiesAnswerStoreRequest;
use App\Http\Requests\PrioritiesAnswerUpdateRequest;
use App\Models\PrioritiesAnswers;
use Illuminate\Http\Request;

class PrioritiesAnswersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $prioritiesAnswers = PrioritiesAnswers::all();

        return view('PrioritiesAnswers.index', compact('PrioritiesAnswers'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('PrioritiesAnswers.create');
    }

    /**
     * @param \App\Http\Requests\PrioritiesAnswersStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrioritiesAnswerStoreRequest $request)
    {
        $prioritiesAnswer = PrioritiesAnswers::create($request->validated());

        return redirect()->route('PrioritiesAnswers.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PrioritiesAnswers $prioritiesAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PrioritiesAnswers $prioritiesAnswer)
    {
        return view('PrioritiesAnswers.show', compact('PrioritiesAnswer'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PrioritiesAnswers $prioritiesAnswer
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PrioritiesAnswers $prioritiesAnswer)
    {
        return view('PrioritiesAnswers.edit', compact('PrioritiesAnswer'));
    }

    /**
     * @param \App\Http\Requests\PrioritiesAnswersUpdateRequest $request
     * @param \App\Models\PrioritiesAnswers $prioritiesAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(PrioritiesAnswerUpdateRequest $request, PrioritiesAnswers $prioritiesAnswer)
    {
        $prioritiesAnswer->update($request->validated());

        return redirect()->route('PrioritiesAnswers.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PrioritiesAnswers $prioritiesAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PrioritiesAnswers $prioritiesAnswer)
    {
        $prioritiesAnswer->delete();

        return redirect()->route('PrioritiesAnswers.index');
    }
}
