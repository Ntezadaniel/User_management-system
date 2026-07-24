<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MemberController extends Controller
{
    public function dashboard()
    {
        $totalMembers = Member::count();
        $recentMembers = Member::latest()->take(5)->get();

        return view('dashboard', compact('totalMembers', 'recentMembers'));
    }

    public function export(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="members.csv"',
        ];

        $callback = function () {
            $handle = fopen('php://output', 'wb');
            fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Address']);

            Member::query()->orderBy('id')->chunkById(100, function ($members) use ($handle) {
                foreach ($members as $member) {
                    fputcsv($handle, [
                        $member->id,
                        $member->name,
                        $member->email,
                        $member->phone,
                        $member->address,
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Show list of all members
    public function index(Request $request)
{
    $query = Member::query();

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    $members = $query->latest()->paginate(10)->withQueryString();

    return view('members.index', compact('members'));
}

    // Show the form to create a new member
    public function create()
    {
        return view('members.create');
    }

    // Save a new member to the database
   public function store(Request $request)
{
    $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|unique:members,email',
        'phone'   => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'photo'   => 'nullable|image|max:2048',
    ]);

    $data = $request->all();

    if ($request->hasFile('photo')) {
        $data['photo'] = $request->file('photo')->store('members', 'public');
    }

    Member::create($data);

    return redirect()->route('members.index')
        ->with('success', 'Member created successfully.');
}
    // Show a single member's details
    public function show(Member $member)
    {
        return view('members.show', compact('member'));
    }

    // Show the form to edit an existing member
    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    // Update an existing member
    public function update(Request $request, Member $member)
{
    $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|unique:members,email,' . $member->id,
        'phone'   => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'photo'   => 'nullable|image|max:2048',
    ]);

    $data = $request->all();

    if ($request->hasFile('photo')) {
        // Delete old photo if it exists
        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }
        $data['photo'] = $request->file('photo')->store('members', 'public');
    }

    $member->update($data);

    return redirect()->route('members.index')
        ->with('success', 'Member updated successfully.');
}

    // Delete a member
    public function destroy(Member $member)
{
    if ($member->photo) {
        Storage::disk('public')->delete($member->photo);
    }

    $member->delete();

    return redirect()->route('members.index')
        ->with('success', 'Member deleted successfully.');
}
}
