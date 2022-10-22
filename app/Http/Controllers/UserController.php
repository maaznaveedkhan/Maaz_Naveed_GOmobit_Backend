<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function all_users(){
        // return 'checking';
        $users = User::all();
        return response()->json($users);
    }

    public function new_user(Request $request)
    {
    $request->validate([
        'name' => 'required|max:255',
        'email' => 'required',
        'cell_no' => 'required',
        'age' => 'required',
    ]);

    $user = new User([
        'name' => $request->get('name'),
        'email' => $request->get('email'),
        'cell_no' => $request->get('cell_no'),
        'age' => $request->get('age'),
    ]);

    $user->save();

    return response()->json('user added successfully!');
    }

    public function search(Request $request){
        // $users = User::where('name', 'LIKE', $request->user.'%')
        //         ->paginate(15);

        if($request->ajax()) {
            if($request->user == ''){
                return '';
            }
            $data = User::where('name', 'LIKE', $request->user.'%')
                ->get();

            $output = '';

            if (count($data)>0) {

                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';

                foreach ($data as $row){
                    // $url = route('user_detail',$row->id);
                    $output .= '<li class="list-group-item">'.$row->name.'s</li>';
                }

                $output .= '</ul>';
            }
            else {

                $output .= '<li class="list-group-item">'.'No results'.'</li>';
            }

            return $output;
        }
        // return view('frontend.search_results', compact('users'));
    }
}
