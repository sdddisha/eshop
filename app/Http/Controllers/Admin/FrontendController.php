<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Aboutus;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    //
    public function index()
    {
        return view('admin.dashboard');

    }
    public function perform(Request $request)
    {
        //dd('gg');
        Session::flush();
        return redirect('/');
    }

    public function show_page(){

        return view('admin.page');
    }

    public function add_pages(Request $request)
    {
        $menu=new Page();
        $menu->name=$request->input('name');
        $menu->des=$request->input('des');    
        $menu->link=$request->input('link');  
        $menu->save();
        return back()->with('message','Data added');
    }
    public function show_all_pages(){
        $sub=Page::all();
        return view('admin.showpage',compact('sub'));
    }
    public function delete_page($id){
      //  dd($id);    
        Page::destroy(array('id',$id));
        return redirect('page');

    }
    public function add_details(Request $request, $id){
        
        if($id=2){
            return view('admin.about');
        }
    
    }
    public function insert_about(Request $request){
        $request->validate([
             'h1' => 'required',
            'h2' => 'required',
            'h3' => 'required',
            'h4' => 'required',
                   
                ]); 
            $data = new Aboutus([
                    "h1" => $request->get('h1'),
                    "h2" => $request->get('h2'),
                    "h3" => $request->get('h3'),
                    "h4" => $request->get('h4'),
                    
            ]);
                
                $data->save();
                return back()->with('message','Data added');
    }
}
