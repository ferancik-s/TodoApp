@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card m-2">
                    <div class="card-header">{{ __('List of your ToDo items') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @foreach($todos as $todo)
                            <div class="w-5/6 py-10 p-3">
                                <form action="{{ url('share') }}" method="POST">
                                    @csrf
                                    @if( isset(Auth::user()->id) && Auth::user()->id == $todo->user_id)
                                    <input type="checkbox">
                                    <div class="">
                                        <p class="">
                                            {{ $todo->text }}
                                        </p>
                                    </div>
                                    <select name="user" class="form-control" required>
                                        <option value="">Choose....</option>

                                        @foreach($users as $user)
                                            @unless(Auth::user()->id == $user->id)
                                            <option value="{{ $user->id }}" {{ $user->name == 'home' ? 'selected' : ''}}>{{ $user->name }}</option>
                                            @endunless
                                        @endforeach
                                    </select>
                                        <input name="item" type="text" hidden value="{{ $todo->id }}">
                                    <button type="submit">
                                        Share
                                    </button>
                                    <div class="flex-fill">
                                        <p class="">
                                            Shared with:
                                        </p>
                                    </div>
                                    @endif
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

                <div class="card m-2">
                    <div class="card-header">{{ __('List of ToDo items shared with you') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @foreach($todos as $todo)
                            @foreach($shared as $shared_item)
                                @if($todo->id == $shared_item->item_id)
                                    <div class="w-5/6 py-10 flex-column">
                                        <input type="checkbox">
                                        <div class="flex-fill">
                                            <p class="">
                                                {{ $todo->text }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
