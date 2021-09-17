@extends('layouts.app')

@section('content')
    <div>
        <h1>Create new todo item</h1>

    </div>

    <div class="container">
        <div class="form-group">
            <form action="{{ url('todo') }}" method="POST">
                @csrf

                <label class="col-md-2">Select Category:</label>
                    <div class="col-md-6">
                        <select name="category" class="form-control" required>
                            <option value="">Choose....</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->name == 'home' ? 'selected' : ''}}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>



                <input type="text" name="text" placeholder="Write text of your ToDo item">
                <button type="submit"> CREATE</button>

            </form>
        </div>
    </div>
@endsection
