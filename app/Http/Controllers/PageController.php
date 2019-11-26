<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;
use App\Product;
use App\ProductType;
use App\Cart;
use App\Customer;
use App\Bill;
use App\BillDetail;
use App\User;
use Session;
use Hash;
use Auth;


class PageController extends Controller
{
    public function getIndex(){
        $slide = Slide::all();
        // return view('pages.trangchu',['slide'=>$slide]);
        $new_product = Product::where('new',1)->paginate(4);
        $sanphamkhuyenmai = Product::where('promotion_price','<>',0)->paginate(8);
        return view('pages.trangchu', compact('slide','new_product', 'sanphamkhuyenmai'));
    }

    public function getLoaiSp($type){
        $sp_theoloai = Product::where('id_type',$type)->get();
        $sp_khac = Product::where('id_type','<>',$type)->paginate(3);
        $loai = ProductType::all();
        $loai_sp = ProductType::where('id',$type)->first();
        return view('pages.loai_sanpham', compact('sp_theoloai','sp_khac','loai','loai_sp'));
    }

    public function getchiTiet(Request $req){
        $sanpham = Product::where('id',$req->id)->first();
        $sp_tuongtu = Product::where('id_type',$sanpham->id_type)->paginate(6);
        return view('pages.chitiet_sanpham',compact('sanpham','sp_tuongtu'));
    }

    public function getLienhe(){
        return view('pages.lien_he');
    }

    public function getGioithieu(){
        return view('pages.gioi_thieu');
    }

    //them gio hang
    public function getAddtoCart(Request $req, $id){
        $product = Product::find($id);
        $oldCart = Session('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->add($product, $id);
        $req->session()->put('cart',$cart);
        return redirect()->back();
    }

    //xoa gio hang
    public function getDelitemCart($id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if(count($cart->items) > 0){
            Session::put('cart', $cart);
        }
        else{
            Session::forget('cart');
        }
        return redirect()->back();
    }
    
    public function getDatHang(){
        // $oldCart = Session::has('cart') ? Session::get('cart') : null;
        // $cart = new Cart($oldCart);
        return view('pages.dathang');
    }

    //dat hang
    public function postDatHang(Request $req){
        $cart = Session::get('cart');

        $customer = new Customer;
        $customer->name = $req->name;
        $customer->gender = $req->gender;
        $customer->email = $req->email;
        $customer->address = $req->address;
        $customer->phone_number = $req->phone;
        $customer->note = $req->note;
        $customer->save();

        $bill = new Bill;
        $bill->id_customer = $customer->id;
        $bill->date_order = date('Y-m-d');
        $bill->total = $cart->totalPrice;
        $bill->payment = $req->payment_method;
        $bill->note = $req->note;
        $bill->save();

        foreach($cart->items as $key=>$value ){
            $billDetail = new BillDetail;
            $billDetail->id_bill = $bill->id;
            $billDetail->id_product = $key;
            $billDetail->quantity = $value['qty'];
            $billDetail->unit_price = $value['price']/$value['qty'];
            $billDetail->save();
        }

        Session::forget('cart');
        return redirect()->back()->with('thongbao', 'Đặt hàng thành công!');
    }

    public function getdangNhap(){
        return view('pages.dangnhap');
    }

    public function getdangKy(){
        return view('pages.dangky');
    }

    public function postdangKy(Request $req){
        $this->validate($req,
            [
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:6|max:50',
                'fullname'=>'required',
                're_password'=>'required|same:password'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Không đúng định dạng email',
                'email.unique'=>'Email đã có người sử dụng',
                'password.required'=>'Vui lòng nhập mật khẩu',
                're_password.same'=>'Mật khẩu không trùng khớp',
                'password.min'=>'Mật khẩu không hợp lệ (ít nhất 6 ký tự, nhiều nhất 50 ký tự',
                'password.max'=>'Mật khẩu không hợp lệ (ít nhất 6 ký tự, nhiều nhất 50 ký tự'
            ]
        );
        $user = new User();
        $user->full_name = $req->fullname;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->phone = $req->phone;
        $user->address = $req->address;
        $user->save();
        return redirect()->back()->with('thanhcong','Đã tạo tài khoản thành công!');
    }

    public function postdangNhap(Request $req){
        $this->validate($req,
            [
                'email'=>'required|email',
                'password'=>'required|min:6|max:50'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Email không đúng định dạng',
                'password.required'=>'Vui lòng nhập mật khẩu',
                'password.min'=>'Mật khẩu không hợp lệ (ít nhất 6 ký tự, nhiều nhất 50 ký tự',
                'password.max'=>'Mật khẩu không hợp lệ (ít nhất 6 ký tự, nhiều nhất 50 ký tự'
            ]
        );
        $user = new User();
        $credentials = array('email'=>$req->email,'password'=>$req->password);
        if(Auth::attempt($credentials)){
            return redirect()->route('trang-chu');
        }
        else{
            return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập không thành công!']);
        }
    }

    public function getdangXuat(){
        Auth::logout();
        return redirect()->route('trang-chu');
    }

    public function getSearch(Request $req){
        $key = $req->key;
        $product = Product::where('name','like','%'.$key.'%')->orWhere('unit_price', $req->key)->get();
        return view('pages.search', compact(['product','key']));
    }
}
