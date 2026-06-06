@extends('layouts.backend')

@section('title', 'Moderate Threads | NomadThread Admin')
@section('admin_section_title', 'Thread Moderation')

@section('content')
<div class="rounded-xl table-glass p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-base font-bold text-slate-200">Active & Archived Discussions</h3>
            <p class="text-xs text-slate-400 mt-1">Review the content of discussions and moderate or delete threads violating rules.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-400">
            <thead class="text-xs uppercase text-slate-500 border-b border-slate-800">
                <tr>
                    <th class="py-3.5 px-4">Thread ID</th>
                    <th class="py-3.5 px-4">Title</th>
                    <th class="py-3.5 px-4">Author</th>
                    <th class="py-3.5 px-4">Location</th>
                    <th class="py-3.5 px-4">Created At</th>
                    <th class="py-3.5 px-4">Status</th>
                    <th class="py-3.5 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60">
                @forelse($threads as $thread)
                    <tr class="hover:bg-slate-800/25 transition-colors">
                        <td class="py-3.5 px-4 font-mono text-xs text-slate-500">#{{ $thread->id }}</td>
                        <td class="py-3.5 px-4">
                            <div class="font-medium text-slate-200 max-w-sm truncate">{{ $thread->title }}</div>
                            <div class="text-xs text-slate-500 mt-1 line-clamp-1 max-w-sm">{{ $thread->content }}</div>
                        </td>
                        <td class="py-3.5 px-4 text-xs">{{ $thread->user->name }}</td>
                        <td class="py-3.5 px-4 text-xs font-semibold text-slate-300">{{ $thread->location }}</td>
                        <td class="py-3.5 px-4 text-xs text-slate-500">{{ $thread->created_at->format('M d, Y') }}</td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1 rounded-md px-2 py-0.5 text-xs font-medium {{ $thread->status === 'active' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-slate-800 text-slate-400' }}">
                                {{ ucfirst($thread->status) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <form action="{{ route('backend.threads.destroy', $thread->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this thread? This cannot be undone.');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" id="btn-delete-thread-{{ $thread->id }}" class="inline-flex items-center gap-1 rounded-lg bg-red-500/10 px-2.5 py-1.5 text-xs font-semibold text-red-400 border border-red-500/20 hover:bg-red-500 hover:text-white transition-all duration-300">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.34 9m-4.72 0L9 9m5 12.42V19.5a2.25 2.25 0 00-2.25-2.25h-3A2.25 2.25 0 006.5 19.5v1.92m11 0V7.5a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 7.5v12.84M2.25 6h19.5M9.75 3h4.5a.75.75 0 01.75.75v1.5a.75.75 0 01-.75.75h-4.5a.75.75 0 01-.75-.75v-1.5a.75.75 0 01.75-.75z" />
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-500">No threads found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
