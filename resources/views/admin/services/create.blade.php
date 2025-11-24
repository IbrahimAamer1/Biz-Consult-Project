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
                            <form action="{{ route('admin.services.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="title">{{ __('keywords.title') }}</label>
                                    <input type="text" name="title" id="title" class="form-control" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="icon">{{ __('keywords.icon') }}</label>
                                    <input type="text" name="icon" id="icon" class="form-control" required>
                                    @error('icon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">{{ __('keywords.description') }}</label>
                                    <textarea name="description" id="description" class="form-control" required></textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('keywords.save') }}</button>
                            </form>
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- .container-fluid -->
@endsection
