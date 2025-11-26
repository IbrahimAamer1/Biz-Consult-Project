@extends('admin.master')
@section('title'){{ __('keywords.features') }}
@endsection
@section('content')
<div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <h2 class="h5 page-title right-align">{{ __('keywords.features') }}</h2>
              <div class="right-align">
                <x-action-button href="{{ route('admin.features.create') }}" type="create" />
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
                            @if ($features->count() > 0)
                            @foreach ($features as $feature)    
                          <tr>
                            <td> {{ $feature->id }}</td>
                            <td>{{ $feature->title }}</td>
                            <td> <i class="{{ $feature->icon }} fa-2x"></i></td>
                            <td>
                                <x-action-button href="{{ route('admin.features.edit', ['feature' => $feature]) }}" type="edit" />
                                 <!-- Show Button Component -->
                                <x-action-button href="{{ route('admin.features.show', ['feature' => $feature]) }}" type="show" />
                                
                                <!-- Delete Button Component -->
                                <x-delete-button href="{{ route('admin.features.destroy', ['feature' => $feature]) }}" id="{{ $feature->id }}" />
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
                      {{ $features->links('pagination::bootstrap-4') }}
                    </div>
                  </div>
                </div> <!-- simple table -->  
        </div> <!-- .container-fluid -->
        
@endsection 