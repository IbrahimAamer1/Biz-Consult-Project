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
                                    <label for="name">{{ __('keywords.name') }} </label>
                                    <p name="name" id="name" class="form-control" required>{{ $message->name }}  </p>
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ __('keywords.email') }} </label>
                                    <p name="email" id="email" class="form-control" required>{{ $message->email }}  </p>
                                </div>
                                <div class="form-group">
                                    <label for="subject">{{ __('keywords.subject') }} </label>
                                    <p name="subject" id="subject" class="form-control" required>{{ $message->subject }}  </p>
                                </div>
                                <div class="form-group">
                                    <label for="message">{{ __('keywords.message') }} </label>
                                    <p name="message" id="message" class="form-control" required>{{ $message->message }}  </p>
                                </div>
                                <a href="{{ route('admin.messages.index') }}" class="btn btn-primary">{{ __('keywords.back') }}</a>
                            </div>
                        </div> <!-- .card-body -->
                    </div> <!-- .card -->
                </div> <!-- .col-md-6 -->
            </div> <!-- .row -->
        </div> <!-- .container-fluid -->
@endsection 
