<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\Csv\Writer;
use League\Csv\CannotInsertRecord;
use League\Csv\CharsetConverter;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|numeric|digits:10|unique:users,mobile',
            'profile_pic' => 'nullable|image|mimes:jpeg,jpg,png',
            'password' => 'required|min:6',
        ]);     

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;

        if ($request->hasFile('profile_pic')) {
            $profilePic = $request->file('profile_pic');
            $filename = time() . '.' . $profilePic->getClientOriginalExtension();
            $profilePic->move(public_path('uploads'), $filename);
            $user->profile_pic = $filename;
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'required|numeric|unique:users,mobile,' . $user->id,
            'profile_pic' => 'nullable|image|mimes:jpeg,jpg,png',
            'password' => 'nullable|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;

        if ($request->hasFile('profile_pic')) {
            $profilePic = $request->file('profile_pic');
            $filename = time() . '.' . $profilePic->getClientOriginalExtension();
            $profilePic->move(public_path('uploads'), $filename);
            $user->profile_pic = $filename;
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function exportCsv()
    {
        $users = User::all();

        $filename = 'users_' . date('YmdHis') . '.csv';
        $filePath = public_path('exports/' . $filename);

        $csv = Writer::createFromPath($filePath, 'w+');
        $csv->insertOne(['Name', 'Email', 'Mobile']);

        foreach ($users as $user) {
            $csv->insertOne([$user->name, $user->email, $user->mobile]);
        }

        $csv->output($filename);
        exit;
    }
       
}
