<?php

namespace App\Http\Controllers;

use App\Models\PostIT;
use Illuminate\Http\Request;

class PostITController extends Controller
{
    public function index()
    {
        // return PostIT::all();
        $postits = PostIT::orderBy('id', 'desc')->paginate(4);
        return response()->json($postits);
    }
    public function show($id)
    {
        // ดึงข้อมูลผู้ใช้จากฐานข้อมูลตาม $id
        return PostIT::find($id);
    }
    public function store(Request $request)
    {
        $request->validate([
            'titlenameit' => 'required|string',
            'sourceit' => 'required|string',
            'contentit' => 'required',
            'titleimgit' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $postits = PostIT::create([
            'titlenameit' => $request->input('titlenameit'),
            'sourceit' => $request->input('sourceit'),
            'contentit' => $request->input('contentit'),
        ]);

        if (!empty($titleimgit = $request->file('titleimgit'))) {
            $destinationPath = public_path('/image/avatar');
            $file_name = "titleimg_it" . time() . "." . $titleimgit->getClientOriginalExtension();
            $titleimgit->move($destinationPath, $file_name);
            $postits['titleimgit'] = url('/') . '/image/avatar/' . $file_name;
            $postits->save();
        } else {
            $postits['titleimgit'] = url('/') . '/image/avatar/no_img.png';
            $postits->save();
        }

        return response($request, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titlenameit' => 'required|string',
            'sourceit' => 'required|string',
            'contentit' => 'required',
            'titleimgit' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $postits = PostIT::find($id);
        if($postits){
            $postits = PostIT::create([
                'titlenameit' => $request->input('titlenameit'),
                'sourceit' => $request->input('sourceit'),
                'contentit' => $request->input('contentit'),
            ]);
    
            if (!empty($titleimgit = $request->file('titleimgit'))) {
                $destinationPath = public_path('/image/avatar');
                $file_name = "titleimg_it" . time() . "." . $titleimgit->getClientOriginalExtension();
                $titleimgit->move($destinationPath, $file_name);
                $postits['titleimgit'] = url('/') . '/image/avatar/' . $file_name;
                $postits->save();
            } 
            // else {
            //     $postits['titleimgit'] = url('/') . '/image/avatar/no_img.png';
            //     $postits->save();
            // }
    
            return response($request, 201);
        }else{
            return response(['message' => 'การอัพเดตผิดพลาด !!!'], 404);
        }
    }

    public function destroy($id)
    {
        return PostIT::destroy($id);
    }

    public function countPostits()
    {
        // นับจำนวน users
        $postits = PostIT::query()->count();
        return response()->json(['count' => $postits]);
    }

    public function showpostprojact()
    {
        // return Postkm::all();
        $postits = PostIT::orderBy('id', 'desc')->paginate(4);
        return response()->json($postits);
    }


    public function showitviews()
    {
        // return Postkm::all();
        $postits = PostIT::all();
        return response()->json($postits);
    }
}
