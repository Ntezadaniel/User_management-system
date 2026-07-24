@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Member Dashboard</h2>
        <a href="{{ route('members.create') }}" class="btn btn-primary">+ Add New Member</a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted">Members</div>
                    <div class="display-6 fw-semibold">{{ $totalMembers }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted">Quick Action</div>
                    <a href="{{ route('members.index') }}" class="btn btn-outline-primary mt-3">Browse Members</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted">Export</div>
                    <a href="{{ route('members.export') }}" class="btn btn-success mt-3">Download CSV</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="h5 mb-0">Recent Members</h3>
                <a href="{{ route('members.index') }}" class="btn btn-sm btn-link">Open member list</a>
            </div>

            @if ($recentMembers->isEmpty())
                <p class="mb-0 text-muted">No members yet. Add your first record to get started.</p>
            @else
                <div class="list-group">
                    @foreach ($recentMembers as $member)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">{{ $member->name }}</div>
                                <div class="text-muted small">{{ $member->email }}</div>
                            </div>
                            <div class="text-muted small">{{ $member->created_at->diffForHumans() }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
