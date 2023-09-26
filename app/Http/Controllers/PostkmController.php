<?php

namespace App\Http\Controllers;

use App\Models\Postkm;
use Illuminate\Http\Request;

class PostkmController extends Controller
{
    public function index()
    {

        // return Postkm::all();
        $postkms = Postkm::orderBy('id', 'desc')->paginate(5);
        return response()->json($postkms);
    }
    public function show($id)
    {
        // ดึงข้อมูลผู้ใช้จากฐานข้อมูลตาม $id
        return Postkm::find($id);
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'titlename' => 'required|string',
            'creatorname' => 'required|string',
            'yearcreated' => 'required|integer',
            'content' => 'required',
        ]);

        // เพิ่มการตรวจสอบฟิลด์อื่น ๆ ตามความเหมาะสม

        // สร้างรายการ Postkm
        $post = Postkm::create([
            'titlename' => $request->input('titlename'),
            'creatorname' => $request->input('creatorname'),
            'yearcreated' => $request->input('yearcreated'),
            'content' => $request->input('content'),
            // 'creatorimg' => $request->input('content'),
            // เพิ่มฟิลด์อื่น ๆ ตามความเหมาะสม
        ]);

        if (!empty($creatorimg = $request->file('file'))) {
            $destinationPath = public_path('/image/avatar');
            $file_name = "creatorimg" . time() . "." . $creatorimg->getClientOriginalExtension();
            $creatorimg->move($destinationPath, $file_name);
            $post['creatorimg'] = url('/') . '/image/avatar/' . $file_name;
            $post->save();
        } else {
            $post['creatorimg'] = url('/') . '/image/avatar/no_img.png';
            $post->save();
        }
        if (!empty($titleimg = $request->file('titleimg'))) {
            $destinationPath = public_path('/image/avatar');
            $file_name = "titleimg" . time() . "." . $titleimg->getClientOriginalExtension();
            $titleimg->move($destinationPath, $file_name);
            $post['titleimg'] = url('/') . '/image/avatar/' . $file_name;
            $post->save();
        } else {
            $post['titleimg'] = url('/') . '/image/avatar/no_img.png';
            $post->save();
        }

        return response($request, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titlename' => 'required|string',
            'creatorname' => 'required|string',
            'yearcreated' => 'required|integer',
            'content' => 'required',
        ]);

        $post = Postkm::find($id);

        if ($post) {
            $post->update([
                'titlename' => $request->input('titlename'),
                'creatorname' => $request->input('creatorname'),
                'yearcreated' => $request->input('yearcreated'),
                'content' => $request->input('content'),
            ]);
            if (!empty($creatorimg = $request->file('file'))) {
                $destinationPath = public_path('/image/avatar');
                $file_name = "creatorimg" . time() . "." . $creatorimg->getClientOriginalExtension();
                $creatorimg->move($destinationPath, $file_name);
                $post['creatorimg'] = url('/') . '/image/avatar/' . $file_name;
                $post->save();
            } 
            // else {
            //     $post['creatorimg'] = url('/') . '/image/avatar/no_img.png';
            //     $post->save();
            // }
            if (!empty($titleimg = $request->file('titleimg'))) {
                $destinationPath = public_path('/image/avatar');
                $file_name = "titleimg" . time() . "." . $titleimg->getClientOriginalExtension();
                $titleimg->move($destinationPath, $file_name);
                $post['titleimg'] = url('/') . '/image/avatar/' . $file_name;
                $post->save();
            } 
            // else {
            //     $post['titleimg'] = url('/') . '/image/avatar/no_img.png';
            //     $post->save();
            // }

            return response($request, 201);
        } else {
            return response(['message' => 'การอัพเดตผิดพลาด !!!'], 404);
        }
        
    }
    public function destroy($id)
    {
        return Postkm::destroy($id);
    }
}
