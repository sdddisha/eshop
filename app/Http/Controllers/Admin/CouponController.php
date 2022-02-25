<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    //
    public function add()
    {
        return view('admin.coupon.add');
    }

    public function insert(Request $request)
    {
        $coupon=new Coupon();
        $coupon->code=$request->input('code');
        $coupon->amount=$request->input('amount');
        $coupon->type=$request->input('type');
        $coupon->save();
      return back()->with('message','Coupon added');
    }
    public function show()

    {
        $coupon=Coupon::all();
        return view('admin.coupon.show',compact('coupon'));
    }

    public function destroy($id)
{
  // delete task
  $task=Coupon::find($id);
  $task->delete();
  return redirect('/show-coupon')->with('success','Coupon deleted successfully');
}
}
