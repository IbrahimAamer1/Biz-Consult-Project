@extends('admin.master')
@section('title'){{ __('keywords.services') }}
@endsection
@section('content')
<div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <h2 class="h5 page-title right-align">{{ __('keywords.services') }}</h2>
              <div class="right-align">
                <x-action-button href="{{ route('admin.services.create') }}" type="create" />
              </div>
                    <!-- simple table -->
                    <div class="col-md-6 my-4">
                  <div class="card shadow">
                    <div class="card-body">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th style="width: 5%;"> #</th>
                            <th style="width: 10%;">{{ __('keywords.title') }}</th>
                            <th>{{ __('keywords.icon') }}</th>
                            <th style="width: 15%;">{{ __('keywords.actions') }}</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if ($services->count() > 0)
                            @foreach ($services as $service)    
                          <tr>
                            <td> {{ $service->id }}</td>
                            <td>{{ $service->title }}</td>
                            <td> <i class="{{ $service->icon }} fa-2x"></i></td>
                            <td>
                                <x-action-button href="{{ route('admin.services.edit', ['service' => $service]) }}" type="edit" />
                                 <!-- Show Button Component -->
                                <x-action-button href="{{ route('admin.services.show', ['service' => $service]) }}" type="show" />
                                
                                <!-- Delete Button Component -->
                                <x-delete-button href="{{ route('admin.services.destroy', ['service' => $service]) }}" id="{{ $service->id }}" />
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
                      {{ $services->links('pagination::bootstrap-4') }}
                    </div>
                  </div>
                </div> <!-- simple table -->  
        </div> <!-- .container-fluid -->
        
@endsection 