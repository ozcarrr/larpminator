@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Ingest Technical Interview Session</h1>
            <p class="text-xs text-slate-500 mt-1">Submit interview transcript to evaluate authentic engineering depth versus superficial buzzwords.</p>
        </div>
        <a href="{{ route('interviews.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">Back to Dashboard</a>
    </div>

    <form action="{{ route('interviews.store') }}" method="POST" onsubmit="const btn = document.getElementById('submit-btn'); btn.disabled = true; btn.innerText = 'Analyzing via Groq...'; btn.classList.add('opacity-75');" class="bg-white p-6 rounded-lg border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Candidate Name</label>
                <input type="text" name="candidate_name" value="{{ old('candidate_name') }}" required placeholder="e.g. Alex Rivera" class="w-full text-sm px-3.5 py-2 rounded-md border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00A3E0] focus:border-transparent">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Role Title</label>
                <input type="text" name="role" value="{{ old('role', $template->role ?? '') }}" required placeholder="e.g. Senior Backend Engineer" class="w-full text-sm px-3.5 py-2 rounded-md border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00A3E0] focus:border-transparent">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Tech Stack</label>
                <input type="text" name="tech_stack" value="{{ old('tech_stack', $template->tech_stack ?? '') }}" required placeholder="e.g. Laravel, PostgreSQL, Redis" class="w-full text-sm px-3.5 py-2 rounded-md border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00A3E0] focus:border-transparent">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Technical Question Context (Reusable per Role)</label>
                <textarea name="question_text" rows="8" required placeholder="Paste the technical interview question or problem scenario..." class="w-full text-sm p-3 rounded-md border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00A3E0] focus:border-transparent">{{ old('question_text', $template->question_text ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Candidate Raw Transcript / Response</label>
                <textarea name="answer_text" rows="8" required placeholder="Paste the candidate's exact verbal or written explanation..." class="w-full text-sm p-3 rounded-md border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00A3E0] focus:border-transparent">{{ old('answer_text') }}</textarea>
            </div>
        </div>

        <div class="pt-2 flex justify-end">
            <button type="submit" id="submit-btn" class="px-6 py-2.5 rounded-md bg-[#00A3E0] hover:bg-[#008bc0] text-white text-sm font-semibold transition shadow-sm">
                Run Larpminator Analysis (Groq AI)
            </button>
        </div>
    </form>
</div>
@endsection
