@extends('admin.master')
@section('title'){{ __('keywords.add_new') }}@endsection    
@section('content')
<div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <h2 class="h5 page-title right-align">{{ __('keywords.add_new') }}</h2>
              </div>
                    <!-- simple table -->
                    <div class="col-md-6 my-4">
                  <div class="card shadow">
                    <div class="card-body">
                            <form action="{{ route('admin.features.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <x-form-label for="title" />
                                    <input type="text" name="title" id="title" class="form-control" required>
                                        <x-validation-error field="title" />
                                </div>
                                <div class="form-group">
                                    <x-form-label for="icon" />
                                    <input type="text" name="icon" id="icon" class="form-control" required>
                                    <x-validation-error field="icon" />
                                </div>
                                <div class="form-group">
                                    <x-form-label for="description" />
                                    <textarea name="description" id="description" class="form-control" required></textarea>
                                    <x-validation-error field="description" />
                                </div>
                                <!-- Submit Button Component -->
                                <x-submit-button />
                            </form>
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- .container-fluid -->
@endsection
