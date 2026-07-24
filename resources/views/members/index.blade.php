@extends('layouts.app')

@section('title', 'All Members')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All Members</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('members.export') }}" class="btn btn-success">Export CSV</a>
            <a href="{{ route('members.create') }}" class="btn btn-primary">+ Add New Member</a>
        </div>
    </div>

    <form action="{{ route('members.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-primary">Search</button>
            @if(request('search'))
                <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">Clear</a>
            @endif
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th style="width: 220px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($members as $member)
                <tr>
                    <td>{{ $member->id }}</td>
                    <td>
                        @if ($member->photo)
                            <img src="{{ Storage::url($member->photo) }}" width="50" class="rounded">
                        @else
                            <span class="text-muted">No photo</span>
                        @endif
                    </td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->phone }}</td>
                    <td>{{ $member->address }}</td>
                    <td>
                        <a href="{{ route('members.show', $member->id) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('members.edit', $member->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this member?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No members found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $members->links() }}

@endsection
