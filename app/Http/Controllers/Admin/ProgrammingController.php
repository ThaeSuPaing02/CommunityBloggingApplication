<?php

namespace App\Http\Controllers\Admin;

use App\Models\Programming;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgrammingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Programming::orderBy('id','desc')->paginate(2);
        return view('admin.programming.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.programming.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>"required | unique:programmings,slug"
        ],[
            'name.required' => 'Programming Language ရဲ့ အမည်ထည့်ပေးပါ',
            'name.unique' => 'Programming Language ရဲ့ အမည်ရှိပီးသားပါ'
        ]);
        Programming::create([
            'slug' => Str::slug($request->name),
            'name' => $request->name,
        ]);
        return redirect()->back()->with('success','Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Programming::where('slug',$id)->first();
        return view('admin.programming.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $updatedSlug = Str::slug($request->name);
        Programming::where('slug',$id)->update([
            'slug' => Str::slug($request->name),
            'name' => $request->name,
        ]);
        return redirect()->route('admin.programming.edit',$updatedSlug)->with('success','Edition Success!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Programming::where('slug',$id)->delete();
        return redirect()->back()->with('success','Deletion Success!');
    }
}
