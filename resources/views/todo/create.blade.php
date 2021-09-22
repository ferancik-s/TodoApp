@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="container col-md-8 card-header d-flex justify-content-between">
            <h1>Create new todo item</h1>
        </div>
        <div class="form-control-lg card-body col-md-4" style="margin: auto">
            <form action="{{ url('todo') }}" method="POST">
                @csrf

                <div class="d-flex m-5">
                    <label class="col-md-8">Select Category:</label>
                    <div class="col-md-8">
                        <select name="category" class="form-control" required>
                            <option value="">Choose....</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->name == 'home' ? 'selected' : ''}}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <input type="text" name="text" placeholder="Write text of your ToDo item">
                    <button type="submit"> CREATE</button>
                </div>


            </form>
        </div>
    </div>
@endsection
