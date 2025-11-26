@extends('admin.master')
@section('title'){{ __('keywords.messages') }}
@endsection
@section('content')
<div class="container-fluid"> <!-- Container Fluid -->
          <div class="row justify-content-center">
            <div class="col-12">
              <h2 class="h5 page-title right-align">{{ __('keywords.messages') }}</h2>
              <div class="right-align">
              </div>
                    <!-- simple table -->
                    <div class="col-md-6 my-4">
                  <div class="card shadow">
                    <div class="card-body">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th style="width: 5%;"> #</th>
                            <th style="width: 10%;">{{ __('keywords.name') }}</th>
                            <th style="width: 10%;">{{ __('keywords.email') }}</th>
                            <th style="width: 10%;">{{ __('keywords.subject') }}</th>
                            <th style="width: 10%;">{{ __('keywords.message') }}</th>
                            <th style="width: 15%;">{{ __('keywords.actions') }}</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if ($messages->count() > 0)
                            @foreach ($messages as $message)    
                          <tr>
                            <td> {{ $message->id }}</td>
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{ $message->subject }}</td>
                            <td>{{ $message->message }}</td>
                            <td>
                              <!-- Show Button Component -->
                                <x-action-button href="{{ route('admin.messages.show', ['message' => $message]) }}" type="show" />
                                <!-- Delete Button Component -->
                                <x-delete-button href="{{ route('admin.messages.destroy', ['message' => $message]) }}" id="{{ $message->id }}" />
                            </td>
                          </tr>
                          @endforeach 
                          @else
                          <!-- Empty Alert Component -->
                          <x-empty-alert />
                          @endif
                          <!-- Success Message Component -->
                          <x-sucess-message />
                            @if (session('something_went_wrong'))
                                <div class="alert alert-danger">
                                    {{ session('something_went_wrong') }}
                                </div>
                            @endif

                        </tbody>
                      </table>
                      {{ $messages->links('pagination::bootstrap-4') }}
                    </div>
                  </div>
                </div> <!-- simple table -->  
        </div> <!-- .container-fluid -->
@endsection 