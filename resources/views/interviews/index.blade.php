@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-sm">
            <p class="text-xs font-semibold uppercase text-slate-500 tracking-wider">Total Candidates Screened</p>
            <p class="text-3xl font-bold mt-2 text-slate-900">{{ $totalCount }}</p>
        </div>
        <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-sm">
            <p class="text-xs font-semibold uppercase text-slate-500 tracking-wider">Average Depth Score</p>
            <p class="text-3xl font-bold mt-2 text-[#00965E]">{{ $avgScore }}%</p>
        </div>
        <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-sm">
            <p class="text-xs font-semibold uppercase text-slate-500 tracking-wider">High LARP Risk Sessions</p>
            <p class="text-3xl font-bold mt-2 text-rose-600">{{ $highRiskCount }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center">
            <h2 class="text-base font-semibold text-slate-900">Evaluated Candidates</h2>
            <a href="{{ route('interviews.create') }}" class="text-xs font-semibold px-3 py-1.5 rounded bg-[#00A3E0] hover:bg-[#008bc0] text-white">Add Candidate</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3">Candidate</th>
                        <th class="px-6 py-3">Role & Stack</th>
                        <th class="px-6 py-3">Depth Score & Verdict</th>
                        <th class="px-6 py-3">Flags</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($interviews as $interview)
                    <tr class="hover:bg-slate-50/75 transition">
                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $interview->candidate_name }}</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-800">{{ $interview->role }}</div>
                            <div class="text-xs text-slate-500">{{ $interview->tech_stack }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold
                                {{ $interview->depth_score >= 75 ? 'bg-emerald-50 text-[#00965E] border border-emerald-200' : ($interview->depth_score >= 45 ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-rose-50 text-rose-700 border border-rose-200') }}">
                                <span class="font-bold">{{ $interview->depth_score }}</span> - {{ $interview->verdict }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs font-medium text-slate-600">
                            {{ count($interview->analysis_data['flags'] ?? []) }} flags
                        </td>
                        <td class="px-6 py-4 text-right space-x-2 text-xs font-medium">
                            <a href="{{ route('interviews.show', $interview) }}" class="text-[#00A3E0] hover:underline">View Report</a>
                            <a href="{{ route('interviews.drilldown', $interview) }}" class="text-slate-600 hover:text-slate-900">Drill-Down</a>
                            <a href="{{ route('interviews.create', ['clone_from' => $interview->id]) }}" class="text-slate-400 hover:text-slate-700">Clone Role Q&A</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">
                            No candidate interviews analyzed yet. <a href="{{ route('interviews.create') }}" class="text-[#00A3E0] underline font-medium">Start a new session</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
