<?php

namespace App\Http\Controllers;

use App\Models\Postkm;
use App\Models\PostProjact;
use Illuminate\Http\Request;

class PostProjactController extends Controller
{
    public function index()
    {
        // return PostProjact::all();
        $post_projacts = PostProjact::orderBy('id', 'desc')->paginate(4);
        return response()->json($post_projacts);
    }

    public function show($id)
    {
        // ดึงข้อมูลผู้ใช้จากฐานข้อมูลตาม $id
        return PostProjact::find($id);
    }
    public function store(Request $request)
    {

        $request->validate([
            'titlenameprojact' => 'required|string',
            'creatornameprojact' => 'required|string',
            'yearcreatedprojact' => 'required|integer',
            'contentprojact' => 'required'
        ]);

        $projact = PostProjact::create([
            'titlenameprojact' => $request->input('titlenameprojact'),
            'creatornameprojact' => $request->input('creatornameprojact'),
            'yearcreatedprojact' => $request->input('yearcreatedprojact'),
            'contentprojact' => $request->input('contentprojact')
        ]);

        if (!empty($titleimgprojact = $request->file('titleimgprojact'))) {
            $destinationPath = public_path('/image/avatar');
            $file_name = "projact_creator" . time() . "." . $titleimgprojact->getClientOriginalExtension();
            $titleimgprojact->move($destinationPath, $file_name);
            $projact['titleimgprojact'] = url('/') . '/image/avatar/' . $file_name;
            $projact->save();
        } else {
            $projact['titleimgprojact'] = url('/') . '/image/avatar/no_img.png';
            $projact->save();
        }
        if (!empty($creatorimgprojact = $request->file('creatorimgprojact'))) {
            $destinationPath = public_path('/image/avatar');
            $file_name = "projact_title" . time() . "." . $creatorimgprojact->getClientOriginalExtension();
            $creatorimgprojact->move($destinationPath, $file_name);
            $projact['creatorimgprojact'] = url('/') . '/image/avatar/' . $file_name;
            $projact->save();
        } else {
            $projact['creatorimgprojact'] = url('/') . '/image/avatar/no_img.png';
            $projact->save();
        }


        return response($request, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titlenameprojact' => 'required|string',
            'creatornameprojact' => 'required|string',
            'yearcreatedprojact' => 'required|integer',
            'contentprojact' => 'required'
        ]);

        $projact = PostProjact::find($id);

        if ($projact) {
            $projact->update([
                'titlenameprojact' => $request->input('titlenameprojact'),
                'creatornameprojact' => $request->input('creatornameprojact'),
                'yearcreatedprojact' => $request->input('yearcreatedprojact'),
                'contentprojact' => $request->input('contentprojact')
            ]);
            if (!empty($titleimgprojact = $request->file('titleimgprojact'))) {
                $destinationPath = public_path('/image/avatar');
                $file_name = "projact_creator" . time() . "." . $titleimgprojact->getClientOriginalExtension();
                $titleimgprojact->move($destinationPath, $file_name);
                $projact['titleimgprojact'] = url('/') . '/image/avatar/' . $file_name;
                $projact->save();
            }
            if (!empty($creatorimgprojact = $request->file('creatorimgprojact'))) {
                $destinationPath = public_path('/image/avatar');
                $file_name = "projact_title" . time() . "." . $creatorimgprojact->getClientOriginalExtension();
                $creatorimgprojact->move($destinationPath, $file_name);
                $projact['creatorimgprojact'] = url('/') . '/image/avatar/' . $file_name;
                $projact->save();
            }
        } else {
            return response(['message' => 'การอัพเดตผิดพลาด !!!'], 404);
        }
    }

    public function destroy($id)
    {
        return PostProjact::destroy($id);
    }

    public function countProjact()
    {
        $projact = PostProjact::query()->count();
        return response()->json(['count' => $projact]);
    }

    public function showpostprojact()
    {
        // return Postkm::all();
         $projact = PostProjact::orderBy('id', 'desc')->paginate(4);
        return response()->json($projact);
    }

    public function showproviews()
    {
        // return Postkm::all();
        $projact = PostProjact::all();
        return response()->json($projact);
    }
}
