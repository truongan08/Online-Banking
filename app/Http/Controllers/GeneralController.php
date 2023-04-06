<?php

namespace App\Http\Controllers;



use App\Bank;
use App\Blog;
use App\Branch;
use App\Contact;
use App\Faq;
use App\Service;
use App\Setting;
use App\Slider;
use App\SocialIcon;
use App\Subscribe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class GeneralController extends Controller
{


    public function sliders()
    {
        $sliders = Slider::all();
        return view('admin.InterfaceControl.slider', compact('sliders'));
    }

    public function otherBank()
    {
        $banks = Bank::all();
        return view('admin.OtherBank', compact('banks'));
    }

    public function otherBankCreate(Request $request)
    {


        $this->validate($request,[
            'name'=>  'required|max:191',
            'processing_time'=>  'required',
            'min_amount'=>  'numeric',
            'max_amount'=>  'numeric',
            'fixed_charge'=>  'numeric',
            'percent_charge'=>  'numeric',


        ]);

        $banks = new Bank();
        $banks->name = $request->name;
        $banks->min_amount = $request->min_amount;
        $banks->max_amount = $request->max_amount;
        $banks->fixed_charge = $request->fixed_charge;
        $banks->fixed_charge = $request->fixed_charge;
        $banks->percent_charge = $request->percent_charge;
        $banks->status = $request->status;
        $banks->save();

        return redirect()->back()->with('success', 'Thêm thành công');
    }

 public function otherBankUpdate(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>  'required|max:191',
            'processing_time'=>  'required',
            'min_amount'=>  'numeric',
            'max_amount'=>  'numeric',
            'fixed_charge'=>  'numeric',
            'percent_charge'=>  'numeric',

        ]);

        $banks = Bank::findOrfail($id);
        $banks->name = $request->name;
        $banks->min_amount = $request->min_amount;
        $banks->max_amount = $request->max_amount;
        $banks->fixed_charge = $request->fixed_charge;
        $banks->fixed_charge = $request->fixed_charge;
        $banks->percent_charge = $request->percent_charge;
        $banks->status = $request->status;
        $banks->update();
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }


    public function branch()
    {
          $branches = Branch::all();

        return view('admin.branchAll', compact('branches'));
    }

    public function branchAdd()
    {
        return view('admin.branchAdd');
    }

    public function branchStore(Request $request)
    {
        $this->validate($request,[
            'name'=>  'required|max:191',
            'description'=>  'required',

        ]);

        $branch = new Branch();
        $branch->name = $request->name;
        $branch->description = $request->description;
        $branch->save();
        return redirect()->back()->with('success', 'Thêm thành công');

    }

    public function branchEdit ($id)
    {
        $branch = Branch::findOrfail($id);
        return view('admin.branchEdit', compact('branch'));

    }

     public function branchUpdate(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>  'required|max:191',
            'description'=>  'required',
            'status'=>  'required',

        ]);

        $branch =  Branch::findOrfail($id);
        $branch->name = $request->name;
        $branch->status = $request->status;
        $branch->description = $request->description;
        $branch->update();
        return redirect()->back()->with('success', 'Cập nhật thành công');

    }

    public function branchDelete($id)
    {

        $branch =  Branch::findOrfail($id);
        $branch->delete();
        return redirect()->back()->with('success', 'Xóa thành công');

    }

    public function blog()
    {
        $blog = Blog::latest()->paginate(10);
        return view('admin.blog.blogIndex', compact('blog'));
    }

    public function blogAdd()
    {
        $blogCategories = Blog::latest()->paginate(10);
        return view('admin.blog.blogAdd', compact('blogCategories'));
    }

    public function blogStore(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|max:191',
            'image' => 'required|mimes:jpg,jpeg,gif,png|max:2048',
        ]);

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->description = $request->description;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->hashName();
            $location = 'assets/image/blog/' . $filename;
            $thumbnail = 'assets/image/blog/thumbnail/' . $filename;
            Image::make($image)->fit(800, 600)->save($location);
            Image::make($image)->fit(400, 250)->save($thumbnail);
            $blog->image = $filename;
        }

        $blog->save();

        return redirect()->back()->with('success', 'Thêm thành công');

    }

    public function blogEdit($id)
    {
        $blog = Blog::findORfail($id);
        $blogCategories = Blog::latest()->paginate(10);
        return view('admin.blog.blogEdit', compact('blog', 'blogCategories'));
    }


    public function blogUpdate(Request $request, $id)
    {


        $this->validate($request,[
            'title' => 'required|max:191',
            'image' => 'mimes:jpg,jpeg,gif,png|max:2048',
        ]);

        $blog = Blog::findORfail($id);
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->status = $request->status;
        if ($request->hasFile('image')) {
            @unlink('assets/image/blog/thumbnail/' . $blog->image);
            @unlink('assets/image/blog/' . $blog->image);
            $image = $request->file('image');
            $filename = $image->hashName();
            $location = 'assets/image/blog/' . $filename;
            $thumbnail = 'assets/image/blog/thumbnail/' . $filename;
            Image::make($image)->fit(800, 600)->save($location);
            Image::make($image)->fit(400, 250)->save($thumbnail);
            $blog->image = $filename;
        }

        $blog->save();

        return redirect()->back()->with('success', 'Cập nhật thành công');

    }

    protected function blogDelete(Request $request)
    {

        $blog = Blog::findOrfail($request->blog);
        @unlink('assets/image/blog/thumbnail/' . $blog->image);
        @unlink('assets/image/blog/' . $blog->image);
        $blog->delete();
        return redirect()->back()->with('success', 'Xóa thành công');

    }

    public function BreadcrumbIndex()
    {
        $breadcrumb = Setting::first();

        return view('admin.InterfaceControl.breadcrumb' , compact('breadcrumb'));
    }

    public function breadcrumb(Request $request)
    {
        $this->validate($request, [
            'breadcrumb' => 'mimes:jpg,jpeg,gif,png|max:2024',

        ]);

        $thumbnail = Setting::first();
        if ($request->hasFile('breadcrumb')) {
            @unlink('assets/image/' . $thumbnail->breadcrumb);
            $image = $request->file('breadcrumb');
            $filename = 'breadcrumb.jpg';
            $location = 'assets/image/' . $filename;
            Image::make($image)->save($location);
        }

        return redirect()->back()->with('success', 'Cập nhật thành công');
    }

    public function subscribe()
    {
        $subscribe = Subscribe::orderBy('id', 'DESC')->paginate(10);

        return view('admin.subscribe.index', compact('subscribe'));
    }

    public function subscribeDelete($id)
    {
        $subscribe = Subscribe::findOrFail($id);
        $subscribe->delete();

        return redirect()->back()->with('success','Xóa thành công');
    }



    public function subscribeMailSendForm()
    {
        $subscribe = Subscribe::all();
        $mail = count($subscribe);
        if ($mail >= 1 ){
            return view('admin.subscribe.emailToAllSubscribe');
        }
        return redirect()->back()->withErrors(['Không tìm thấy người đăng kí']);
    }



        public function subscribeMailSendAll(Request $request)
    {
        $this->validate($request,[
            'subject'=>'required',
            'message'=>'required',
        ]);
        $subscribe = Subscribe::all();

        $mail = count($subscribe);
        if ($mail >= 1){
            foreach ($subscribe as $data) {
                $to = $data->email;
                $name = substr($data->email, 0, strpos($data->email, "@"));
                $subject = $request->subject;
                $message = $request->message;
            }
            return redirect()->back()->with('success','Gửi thành công');
        }else {
            return redirect()->back()->withErrors(['Không tìm thấy nười đăng kí']);
        }



    }

}
