@extends('admin.master')
@section('title'){{ __('keywords.subscribers') }}
@endsection
@section('content')
<div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <h2 class="h5 page-title right-align" style="margin-bottom: 20px; margin-top: 20px;">{{ __('keywords.subscribers') }}</h2>
              <div class="right-align">
              </div>
                    <!-- simple table -->
                    <div class="col-md-6 my-4">
                  <div class="card shadow">
                    <div class="card-body">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th style="width: 10%;">{{ __('keywords.email') }}</th>
                            <th>{{ __('keywords.created_at') }}</th>
                            <th style="width: 15%;">{{ __('keywords.actions') }}</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if ($subscribers->count() > 0)
                            @foreach ($subscribers as $subscriber)    
                          <tr>
                            <td>{{ $subscriber->email }}</td>
                            <td>{{ $subscriber->created_at->format('d-m-Y') }}</td>
                            <td>
                                <x-delete-button href="{{ route('admin.subscribers.destroy', ['subscriber' => $subscriber]) }}" id="{{ $subscriber->id }}" />
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
                      {{ $subscribers->links('pagination::bootstrap-4') }}
                    </div>
                  </div>
                </div> <!-- simple table -->  
        </div> <!-- .container-fluid -->
        
@endsection 