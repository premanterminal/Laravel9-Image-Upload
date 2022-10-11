<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class ImageUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('imageUpload');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();

        $request->image->move(public_path('images'), $imageName);

        // $path = $request->image->move(public_path('images'), $imageName);
        // $path = $request->file('image')->store('public/images');
        $path = 'public/images/'.$imageName;

        //save record data to db;
        $save = new Photo;

        $save->name = $imageName;
        $save->path = $path;

        $save->save();

        /*
            Write Code Here for
            Store $imageName name in DATABASE from HERE
        */

        return back()
            ->with('success','You have successfully upload image.')
            ->with('image',$imageName);
    }
}
