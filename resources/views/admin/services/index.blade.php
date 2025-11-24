@extends('admin.master')
@section('title'){{ __('keywords.services') }}
@endsection
@section('content')
<div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <h2 class="h5 page-title right-align">{{ __('keywords.services') }}</h2>
              <div class="right-align">
                <a href="{{ route('admin.services.create') }}" class="btn btn-primary">{{ __('keywords.add_new') }}</a>   
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
                                <a href="{{ route('admin.services.edit', ['service' => $service]) }}" class="btn btn-primary btn-sm">
                                    <i class="fe fe-edit"></i>
                                </a>
                                <form action="{{ route('admin.services.destroy', ['service' => $service]) }}" method="POST" class="d-inline-block"
                                 id="delete-form-{{ $service->id }}">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick= "confirmdelete('{{ $service->id }}')">
                                        <i class="fe fe-trash" ></i>  
                                    </button>
                                </form>
                                <a href="{{ route('admin.services.show', ['service' => $service]) }}" class="btn btn-info btn-sm">
                                    <i class="fe fe-eye"></i>
                                </a> 
                            </td>
                          </tr>
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
                          @endforeach
                          @else
                          <tr>
                            <td colspan="5" class="text-center text-danger">{{ __('keywords.no_records_found') }}</td>
                          </tr>
                          @endif
                          @if (session('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
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
        <script>
            function confirmdelete(id) {
                if (confirm('Are you sure you want to delete this service?')) {
                    $('#delete-form-'+id).submit();
                }
            }
        </script>
@endsection 