@extends('layouts.app')

@section('title', 'Member Details')

@section('content')

    <h2>Member Details</h2>

    <table class="table table-bordered w-50">
        <tr>
            <th>ID</th>
            <td>{{ $member->id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $member->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $member->email }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $member->phone }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $member->address }}</td>
        </tr>
        <tr>
            <th>Joined</th>
            <td>{{ $member->created_at->format('d M Y, h:i A') }}</td>
        </tr>
        <tr>
    <th>Photo</th>
    <td>
        @if ($member->photo)
            <img src="{{ Storage::url($member->photo) }}" width="150" class="rounded">
        @else
            <span class="text-muted">No photo</span>
        @endif
    </td>
</tr>
    </table>

    <a href="{{ route('members.edit', $member->id) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('members.index') }}" class="btn btn-secondary">Back to List</a>

@endsection
