<?php

namespace App\Http\Controllers;

use App\Language;
use Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

class LanguageController extends Controller
{
//    public function langManage($lang = false)
//    {
//        if (Auth::guard('admin')->user()->can('langManage', Auth::guard('admin')->user())) {
//            $page_title = 'Language Manager';
//            $social = Language::all();
//            return view('admin.lang.lang', compact('page_title', 'social'));
//        }else{
//            $redirect = authorize_admin(Auth::guard('admin')->user()->access);
//            return $redirect;
//        }
//
//
//    }



    public function langManage($lang = false)
    {
        $page_title = 'Language Manager';
        $social = Language::all();
        return view('admin.lang.lang', compact( 'page_title', 'social'));
    }


    public function langStore(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'icon' => 'mimes:png,jpg,jpeg'
        ]);

        if ($request->code == 'en' || $request->code == 'EN' || $request->code == 'En' || $request->code == 'eN') {
            return back()->with('alert', 'Ngôn ngữ mặc định');
        }

        $data = file_get_contents(resource_path('lang/') . 'default.json');
        $json_file = trim(strtolower($request->code)) . '.json';
        $path = resource_path('lang/') . $json_file;

        File::put($path, $data);

        if ($request->hasFile('icon')) {
            $image = $request->file('icon');
            $filename = trim(strtolower($request->code)) . '.' . $image->getClientOriginalExtension();
            $location = 'assets/image/lang/' . $filename;
            Image::make($image)->resize(20, 10)->save($location);
            $in['icon'] = $filename;
        }

        $in['name'] = $request->name;
        $in['code'] = $request->code;
        Language::create($in);

        return back()->with('success', 'Tạo thành công');
    }
}
