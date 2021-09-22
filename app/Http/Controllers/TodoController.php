<?php

namespace App\Http\Controllers;

use App\Models\SharedTodo;
use App\Models\Todo;
use App\Models\User;
use App\Models\UserTodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Int_;
use Ramsey\Collection\Collection;


class TodoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // todos for logged in user
        $users_todos = Todo::sortable()
            ->whereHas('users', function ($query) {
                return $query->where('user_id', '=', auth()->user()->id);
            })
            ->paginate(4);

        // all categories
        $categories = DB::table('categories')->get();

        // all users
        $users = User::all();



        return view('todo.index', [
            'users_todos' => $users_todos,
            'users' => $users,
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DB::table('categories')->get();

        return view('todo.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        //dd(gettype($request->input('category')));
        //TODO: update only if first successful

        $todo_item = Todo::create([
            'text' => $request->input('text'),
            'category_id' => $request->input('category'),
            //'user_id' => auth()->user()->id,
            'done' => false,
        ]);


        $user_todo = UserTodo::create([
            'todo_id' => $todo_item->id,
            'user_id' => auth()->user()->id,

            'shared' => false,
        ]);

        return redirect('/todo');
    }

    public function share(Request $request)
    {

        $shared_todos = UserTodo::firstOrCreate([
            'user_id' => $request->input('user'),
            'todo_id' => $request->input('item'),
            'shared' => true,
        ]);

        return redirect('todo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $todo = Todo::where('id', $id)
            ->update([
                'done' => $request->input('done'),
        ]);


        return redirect('/todo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
