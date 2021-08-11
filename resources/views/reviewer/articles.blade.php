
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="mt-5 mb-3">Articles  </h1>
            <div class="card green-border-top  pt-3">
                <!-- <div class="card-header">My Submitted Articles</div> -->

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Abstract</th>
                                <th>Last Updated</th>
                                <th>Status</th>
                                <th width="120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data) && $data->count())
                                @foreach($data as $key => $value)
                                    <tr>
                                        <td>{{ $value->title }}</td>
                                        <td>{{ $value->abstract }}</td>
                                        <td>{{ $value->updated_at }}</td>
                                        <td>{{ $value->status }}</td>
                                        <td style="text-align:center;">
                                            <a href="{{ route('reviewer.article',[$value->id,$value->reviewer_id]) }}">
                                            <button class="btn btn-primary"><i class="fas fa-eye"></i> View</button></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10">There are no data.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {!! $data->links(\Request::except('page')) !!}
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
