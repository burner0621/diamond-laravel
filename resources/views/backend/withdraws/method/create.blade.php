@extends('backend.layouts.app', ['activePage' => 'withdraws', 'title' => "Withdaw Methods", 'navName' => 'method', 'activeButton' => 'laravel']) 
@section('content')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-end">
            <h1 class="page-header-title">Create Payment Method</h1>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Page Header -->

    <div class="row">
        <div class="col-md-12">
            <div class="card col-md-12">
                <div class="card-body">
                    @include('includes.validation-form')

                    <form method="POST" action="{{ route('backend.withdraws.method.add_post') }}">
                        @csrf
                        @method('POST')

                        <!-- Name -->
                        <div class="col-md-12 mb-2">
                            <label for="name">Name:</label>
                            <input type="text" name="name" value='{{ old("name") }}' id="name"
                                class="form-control">
                        </div>

                        <div class="col-md-12 mb-2">
                            <label for="question_1">Question 1</label>
                            <input type="text" name="question_1" value='{{ old("question_1") }}' id="question_1" class="form-control">
                        </div>

                        <div class="col-md-12 mb-2">
                          <label for="question_2">Question 2</label>
                          <input type="text" name="question_2" value='{{ old("question_2") }}' id="question_2" class="form-control">
                        </div>

                        <div class="col-md-12 mb-2">
                            <label for="question_3">Question 3</label>
                            <input type="text" name="question_3" value='{{ old("question_3") }}' id="question_3" class="form-control">
                        </div>

                        <div class="col-md-12 mb-2">
                            <label for="question_4">Question 4</label>
                            <input type="text" name="question_4" value='{{ old("question_4") }}' id="question_4" class="form-control">
                        </div>

                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-lg btn-primary">Create method</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
