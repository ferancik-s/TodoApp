<?php

namespace App\Http\Controllers;

use App\Models\SharedTodo;
use App\Models\TodoList;
use App\Models\User;
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
        $users_todos = TodoList::sortable()
            ->where('user_id', '=', auth()->user()->id)
            ->paginate(4);

        // all categories
        $categories = DB::table('categories')->get();

        // all users
        $users = User::all();

        // ids of items that are shared with logged user
        $shared_ids = DB::table('shared_todos')
            ->select('item_id')
            ->where('user_id','=', auth()->user()->id)
            ->get();

        // creates collection of shared items with logged user
        $shared_todos = [];
        foreach($shared_ids as $id) {
            $shared_todos = collect(DB::table('todo_lists')
                ->where('id', '=', $id->item_id)
                ->get()
            );
        }

        $shared = SharedTodo::all();


        return view('todo.index', [
            'users_todos' => $users_todos,
            'shared_todos' => $shared_todos,
            'users' => $users,
            'shared' => $shared,
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

        $todo_item = TodoList::create([
            'text' => $request->input('text'),
            'category_id' => $request->input('category'),
            'user_id' => auth()->user()->id,
            'done' => 0,
        ]);

        return redirect('/todo');
    }

    public function share(Request $request)
    {

        $shared_todos = SharedTodo::firstOrCreate([
            'user_id' => $request->input('user'),
            'item_id' => $request->input('item')
        ]);

        return redirect('todo');
    }

    public function done(Request $request)
    {
        ////
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
        $todo = TodoList::where('id', $id)
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
