@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-sm flex flex-wrap justify-between items-center gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">{{ $interview->candidate_name }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">{{ $interview->role }} &bull; {{ $interview->tech_stack }}</p>
        </div>
        <div class="flex items-center gap-2.5 text-xs font-semibold">
            <a href="{{ route('interviews.drilldown', $interview) }}" class="px-3.5 py-2 rounded-md bg-[#00A3E0] hover:bg-[#008bc0] text-white">View Tactical Drill-Downs</a>
            <a href="{{ route('interviews.create', ['clone_from' => $interview->id]) }}" class="px-3.5 py-2 rounded-md border border-slate-300 text-slate-700 hover:bg-slate-50">Clone Role for Next Candidate</a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg border border-slate-200 shadow-sm grid grid-cols-1 md:grid-cols-5 gap-6">
        <div class="md:col-span-2 border-b md:border-b-0 md:border-r border-slate-200 pb-4 md:pb-0 md:pr-6 flex flex-col justify-center">
            <span class="text-xs font-semibold uppercase text-slate-500 tracking-wider">Overall Depth Score</span>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-4xl font-extrabold {{ $interview->depth_score >= 75 ? 'text-[#00965E]' : ($interview->depth_score >= 45 ? 'text-amber-600' : 'text-rose-600') }}">{{ $interview->depth_score }}/100</span>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $interview->depth_score >= 75 ? 'bg-emerald-50 text-[#00965E]' : ($interview->depth_score >= 45 ? 'bg-amber-50 text-amber-700' : 'bg-rose-50 text-rose-700') }}">{{ $interview->verdict }}</span>
            </div>
        </div>
        <div class="md:col-span-3 space-y-3">
            @php $subScores = $interview->analysis_data['sub_scores'] ?? []; @endphp
            @foreach(['operational_depth' => 'Operational Depth', 'friction_handling' => 'Friction Handling', 'ownership' => 'Technical Ownership', 'logical_consistency' => 'Logical Consistency'] as $key => $label)
            <div>
                <div class="flex justify-between text-xs font-medium text-slate-700 mb-1">
                    <span>{{ $label }}</span>
                    <span>{{ $subScores[$key] ?? 0 }}%</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                    <div class="h-2 rounded-full {{ ($subScores[$key] ?? 0) >= 75 ? 'bg-[#00965E]' : (($subScores[$key] ?? 0) >= 45 ? 'bg-amber-500' : 'bg-rose-500') }}" style="width: {{ $subScores[$key] ?? 0 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg border border-slate-200 shadow-sm space-y-4">
            <h2 class="text-sm font-semibold text-slate-900 uppercase tracking-wider">Question & Raw Candidate Transcript</h2>
            <div class="bg-slate-50 p-3.5 rounded border border-slate-200 text-xs text-slate-700 font-medium">
                {{ $interview->question_text }}
            </div>
            <div class="text-xs text-slate-600 whitespace-pre-line leading-relaxed">
                {{ $interview->answer_text }}
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg border border-slate-200 shadow-sm space-y-4">
            <h2 class="text-sm font-semibold text-slate-900 uppercase tracking-wider">Detected LARP Flags & Inconsistencies</h2>
            <div class="space-y-3">
                @forelse($interview->analysis_data['flags'] ?? [] as $flag)
                <div class="p-3.5 rounded-r text-xs {{ ($flag['severity'] ?? '') === 'red' ? 'border-l-4 border-rose-500 bg-rose-50/50' : 'border-l-4 border-amber-500 bg-amber-50/50' }}">
                    <p class="font-semibold text-slate-800">"{{ $flag['quote'] ?? '' }}"</p>
                    <p class="text-slate-600 mt-1">{{ $flag['reason'] ?? '' }}</p>
                </div>
                @empty
                <p class="text-xs text-slate-500">No flags detected. Analysis indicates authentic operational depth.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
