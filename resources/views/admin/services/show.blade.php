@extends('admin.master')
@section('title'){{ __('keywords.show') }}@endsection
@section('content')
<div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <h2 class="h5 page-title right-align">{{ __('keywords.show') }}</h2>
              </div>
                    <!-- simple table -->
                    <div class="col-md-6 my-4">
                  <div class="card shadow">
                    <div class="card-body">
                            <div class="form-group">
                                    <label for="description">{{ __('keywords.description') }} </label>
                                    <p name="description" id="description" class="form-control" required>{{ $service->description }}  </p>

                                    <label for="icon">{{ __('keywords.icon') }}</label>
                                    <input type="text" name="icon" id="icon" class="form-control" value="{{ $service->icon }}" readonly>


                                    <label for="title">{{ __('keywords.title') }}</label>
                                    <input type="text" name="title" id="title" class="form-control" value="{{ $service->title }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- .container-fluid -->
@endsection 
