<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Session;
use DB;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }  
      
    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('Signed in');
        }
  
        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function registration()
    {
        return view('auth.registration');
    }
      
    public function customRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }    
    
    public function dashboard()
    {
        if(Auth::check()){
            $UserID = Auth::user()->id;
            $data=Product::paginate($perPage = 3, $columns = ['*'], $pageName = 'product_page');
            $data2=Product::all();
            $favorshow = Favorite::where('id', '=', $UserID)->paginate($perPage = 3, $columns = ['*'], $pageName = 'favorite_page');
            $favors = DB::table('favorites')->where('id', '=', $UserID)->get();
            return view('dashboard', ['products'=>$data, 'favors'=>$favors, 'favorshow'=>$favorshow, 'vars'=>$data2]);
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }

    public function insert(Request $request){
        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);
        $Name = $request->input('name');
        $Price = $request->input('price');
        $UserID = Auth::user()->id;
        $data=array('Name'=>$Name,"Price"=>$Price,"UserID"=>$UserID);
        DB::table('products')->insert($data);
        return redirect()->intended('dashboard');
    } 
    public function edit($id){           
        $product=DB::table('products')->where('ProductID','=',$id)->first();
        return view('edit')->with('product', $product);    
    }
    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);
        DB::table('products')->where('ProductID', $id)->update([
            'Name' => $request->input('name'),
            'Price' => $request->input('price')
        ]);
        return redirect("dashboard")->withSuccess('Product updated');
    } 
    public function delete(Request $request, $id){
        DB::table('favorites')->where('ProductID', $id)->delete();
        DB::table('products')->where('ProductID', $id)->delete();
        return redirect("dashboard")->withSuccess('Product deleted');
    }
    public function fav($id){
        $data=array('id'=>Auth::user()->id,"ProductID"=>$id);
        if (Favorite::where($data)->exists()) {
            return redirect("dashboard")->withSuccess('Already exist');
        }else{
            DB::table('favorites')->insert($data);
            return redirect("dashboard")->withSuccess('Product to favorites');
        }   
    } 

    public function deletefav($id){
        DB::table('favorites')->where('FavID', $id)->delete();
        return redirect("dashboard")->withSuccess('Product to favorites');
    } 
    
}