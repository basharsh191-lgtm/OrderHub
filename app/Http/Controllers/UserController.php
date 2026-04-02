<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
   function index(){
    $users=[
        ['ID'=> 1 ,'name'=>"Bashar"],
        ['ID'=> 2 ,'name'=>"ali"],
        ['ID'=> 33 ,'name'=>"Omar"],
    ];
    // foreach($users as $user)
    // {
    //     echo $user['ID'].",". $user['name']."\n";
    // }
    //return response()->json($users);
    return response()->json(["name"=>"Aliii"]);
   }
   public function CheckUser( $id){
if($id >10){
    return response()->json(['Massage'=> 'Sorry, the id biger with 10'],403);
}
else{
      return response()->json(['Massage'=> 'Welcome , the id valed']);
}

}
}
//  public function store(Request $request)
//   {
//     User::create([
// 'Titale'=>$request->Title,
// 'Description'=>$request->Discription,
// 'Priority'=>$request->Priority,
//     ]);
//   }

// }
