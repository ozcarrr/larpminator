<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Services\GroqAnalyzerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InterviewController extends Controller
{
    public function index(): View
    {
        $interviews = Interview::latest()->get();
        $totalCount = $interviews->count();
        $avgScore = (int) round($interviews->avg('depth_score') ?? 0);
        $highRiskCount = $interviews->where('depth_score', '<', 45)->count();

        return view('interviews.index', compact('interviews', 'totalCount', 'avgScore', 'highRiskCount'));
    }

    public function create(Request $request): View
    {
        $template = Interview::find($request->query('clone_from'));

        return view('interviews.create', compact('template'));
    }

    public function store(Request $request, GroqAnalyzerService $analyzer): RedirectResponse
    {
        $validated = $request->validate([
            'candidate_name' => 'required|string',
            'role' => 'required|string',
            'tech_stack' => 'required|string',
            'question_text' => 'required|string',
            'answer_text' => 'required|string',
        ]);

        $analysis = $analyzer->analyze(
            $validated['role'],
            $validated['tech_stack'],
            $validated['question_text'],
            $validated['answer_text']
        );

        $interview = Interview::create(array_merge($validated, $analysis));

        return redirect()->route('interviews.show', $interview);
    }

    public function show(Interview $interview): View
    {
        return view('interviews.show', compact('interview'));
    }

    public function drillDown(Interview $interview): View
    {
        return view('interviews.drilldown', compact('interview'));
    }

    public function destroy(Interview $interview): RedirectResponse
    {
        $interview->delete();

        return redirect()->route('interviews.index');
    }
}
