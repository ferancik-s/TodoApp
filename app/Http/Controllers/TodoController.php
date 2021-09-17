<?php

namespace App\Http\Controllers;

use App\Models\SharedTodo;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Int_;


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
    public function index()
    {
        $todos = TodoList::all();

        $users = User::all();

        $shared_ids = DB::table('shared_todos')
            ->select('item_id')
            ->where('user_id','=', auth()->user()->id)
            ->get();


        return view('todo.index', [
            'todos' => $todos,
            'users' => $users,
            'shared' => $shared_ids
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

    public function share_with(Request $request)
    {
        dd($request->all());
        $shared_todos = SharedTodo::create([
            'user_id' => $request->input('user'),
            'item_id' => $request->input('')
        ]);

        return redirect('/todo');
    }

    public function store(Request $request)
    {
        //dd(gettype($request->input('category')));

        $todo_item = TodoList::create([
            'text' => $request->input('text'),
            'category_id' => $request->input('category'),
            'user_id' => auth()->user()->id,
            'done' => 0,
        ]);

        return redirect('/todo');
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
        //
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
