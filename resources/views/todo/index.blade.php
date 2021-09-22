@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card m-2">
                    <div class="card-header d-flex justify-content-between">
                        {{ __('List of your ToDo items') }}
                        <div class="">
                            {{ __('Order:') }}
                            <li class="d-inline-block">@sortablelink('text', 'Alphabetically'),</li>
                            <li class="d-inline-block">@sortablelink('category.name', 'By category'),</li>
                            <li class="d-inline-block">@sortablelink('done', 'Done')</li>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @foreach($users_todos as $users_todo)
                            <div class="d-flex justify-content-between border-dark">
                                <p class="">Category: {{ $users_todo->category->name }}</p>
                            </div>

                            <div class="container-lg p-3 border-bottom d-inline-flex align-items-center">
                                <div class="d-inline-block m-3">
                                    <form action="/todo/{{ $users_todo->id }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        @if($users_todo->done == false)
                                            <input name="done" hidden value=1>
                                            <button type="submit" class="button-checkbox unset"></button>
                                        @else
                                            <input name="done" hidden value=0>
                                            <button type="submit" class="button-checkbox set"></button>
                                        @endif
                                    </form>
                                </div>

                                    <div class="w-50">
                                        <p class="todo-thing">{{ $users_todo->text }}</p>

                                    </div>
                                <div class="w-50">
                                    <div class="d-flex ">
                                        <div>
                                            <p class="m-lg-1">Shared with: </p>
                                        </div>
                                        <div>
                                            @foreach($users_todo->users as $user)
                                                @if($user->pivot->shared == true)
                                                    <li class="d-block m-lg-1">
                                                        @if($user->id == auth()->user()->id)
                                                            Me
                                                        @elseif($user->id != auth()->user()->id)
                                                            {{ $user->name }}
                                                        @endif
                                                    </li>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="d-flex ">
                                        <div>
                                            <p class="m-lg-1">Shared by: </p>
                                        </div>
                                        <div>
                                            @foreach($users_todo->users as $user)
                                                @if($user->pivot->shared == false)
                                                    <li class="d-block m-lg-1">
                                                        @if($user->id == auth()->user()->id)
                                                            Me
                                                        @else
                                                            {{ $user->name }}
                                                        @endif
                                                        </li>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="">
                                        <form action="{{ url('share') }}" method="POST">
                                            @csrf

                                                <select name="user" class="form-control-sm" required>
                                                    <option value="">Choose....</option>
                                                    @foreach($users as $user)
                                                        @unless(Auth::user()->id == $user->id)
                                                            <option value="{{ $user->id }}" {{ $user->name == 'home' ? 'selected' : ''}}>{{ $user->name }}</option>
                                                        @endunless
                                                    @endforeach
                                                </select>
                                                <input name="item" type="text" hidden value="{{ $users_todo->id }}">
                                                <button class="btn-primary" type="submit">Share</button>
                                        </form>
                                    </div>
                                </div>


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
            </div>
        </div>
    </div>
@endsection
