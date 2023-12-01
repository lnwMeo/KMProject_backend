<?php

namespace App\Http\Controllers;

use App\Models\Postkm;
use Illuminate\Http\Request;


class PostkmController extends Controller
{
    public function index()
    {
        // return Postkm::all();
        $postkms = Postkm::orderBy('id', 'desc')->paginate(4);
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
        // $cleanedContent = $this->clean_quill_content($request->input('content'));
        // สร้างรายการ Postkm
        $post = Postkm::create([
            'titlename' => $request->input('titlename'),
            'creatorname' => $request->input('creatorname'),
            'yearcreated' => $request->input('yearcreated'),
            // 'content' => $cleanedContent,
            'content' => $request->input('content'),
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
    // function clean_quill_content($content)
    // {
    //     $cleanedContent = strip_tags($content);
    //     return $cleanedContent;
    // }
    

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
            if (!empty($titleimg = $request->file('titleimg'))) {
                $destinationPath = public_path('/image/avatar');
                $file_name = "titleimg" . time() . "." . $titleimg->getClientOriginalExtension();
                $titleimg->move($destinationPath, $file_name);
                $post['titleimg'] = url('/') . '/image/avatar/' . $file_name;
                $post->save();
            }
            return response($request, 201);
        } else {
            return response(['message' => 'การอัพเดตผิดพลาด !!!'], 404);
        }
    }
    public function destroy($id)
    {
        return Postkm::destroy($id);
    }

    // fronend
    public function countPostkms()
    {
        // นับจำนวน users
        $postkms = Postkm::query()->count();
        return response()->json(['count' => $postkms]);
    }
    // show หน้า HOME
    public function showfronend()
    {
        // return Postkm::all();
        $postkms = Postkm::orderBy('id', 'desc')->paginate(4);
        return response()->json($postkms);
    }
    // แสดงเนื้อหา
    public function showcontent($id)
    {
        // return Postkm::all();
        $postkms = Postkm::find($id);
        return response()->json($postkms);
    }
    // show หน้า KM
    public function showkmviews()
    {
        // return Postkm::all();
        $postkms = Postkm::orderBy('id', 'desc')->paginate(15);
        return response()->json($postkms);
    }
    // ค้นหาหน้า KM
    public function search($keyword)
    {
        return Postkm::where(function ($query) use ($keyword) {
            $query->where('titlename', 'like', '%' . $keyword . '%')
                ->orWhere('creatorname', 'like', '%' . $keyword . '%')
                ->orWhere('yearcreated', 'like', '%' . $keyword . '%');
        })
            ->orderBy('id', 'desc')
            ->paginate(15);
        // return Postkm::where('titlename', 'like', '%' . $keyword . '%')
        //     ->orderBy('id', 'desc')
        //     ->paginate(15);
    }
}
