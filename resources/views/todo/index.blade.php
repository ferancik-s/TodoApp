@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card m-2">
                    <div class="card-header">
                        {{ __('List of your ToDo items') }}
                        <p>@sortablelink('text', 'Alphabetically')</p>
                        <p>@sortablelink('category_id', 'By category')</p>
                        <p>@sortablelink('done', 'Done')</p>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @foreach($users_todos as $users_todo)
                            <div class="container-lg">

                                <div class="row align-items-center justify-content-between">
                                    <form action="/todo/{{ $users_todo->id }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        @if($users_todo->done == 0)
                                            <input name="done" hidden value=1>
                                            <button type="submit" class="button-checkbox unset"></button>
                                        @else
                                            <input name="done" hidden value=0>
                                            <button type="submit" class="button-checkbox set"></button>
                                        @endif
                                    </form>
                                        <p class="todo-thing">{{ $users_todo->text }}</p>
                                        @foreach($categories as $category)
                                            @if($category->id == $users_todo->category_id)
                                                <p>{{ $category->name }}</p>
                                            @endif
                                        @endforeach

                                </div>
                                <form action="{{ url('share') }}" method="POST">
                                    @csrf
                                        <div class="row align-items-center justify-content-start">
                                            <select name="user" class="form-control-sm" required>
                                                <option value="">Choose....</option>
                                                @foreach($users as $user)
                                                    @unless(Auth::user()->id == $user->id)
                                                        <option value="{{ $user->id }}" {{ $user->name == 'home' ? 'selected' : ''}}>{{ $user->name }}</option>
                                                    @endunless
                                                @endforeach
                                            </select>
                                            <input name="item" type="text" hidden value="{{ $users_todo->id }}">
                                            <button type="submit">Share</button>

                                            <p class="">
                                                Shared with:
                                                @foreach($users as $user)
                                                    @foreach($shared as $shared_item)
                                                        @if(($user->id == $shared_item->user_id) && ($shared_item->item_id == $users_todo->id))
                                                            {{ $user->name }}
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </p>
                                        </div>


                                </form>
                            </div>
                        @endforeach
                        <div>
                            <a href="{{ url('/todo/create') }}">
                                Add new todo item
                            </a>
                        </div>
                    </div>


                </div>
                <div class="col-md-8 m-auto">
                    {!! $users_todos->appends(Request::except('page'))->render() !!}
                    <p class="text-center">Displaying {{$users_todos->count()}} of {{ $users_todos->total() }} item(s).</p>
                </div>

                <div class="card m-2">
                    <div class="card-header">{{ __('List of ToDo items shared with you') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @foreach($shared_todos as $shared_todo)
                            <div class="w-5/6 py-10 flex-column">
                                <input type="checkbox">
                                <div class="flex-fill">
                                    <p class="">
                                        {{ $shared_todo->text }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
