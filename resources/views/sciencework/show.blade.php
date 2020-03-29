@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>
                    @if($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li >{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif 
                    <table class="table">
                    <thead class="thead-light">
                        <tr>
                        <th scope="col">topic</th>
                        <th scope="col">type</th>
                        <th scope="col">presenting_date</th>
                        <th scope="col">status</th>
                        <th scope="col">teacher's surname + name</th>
                        <th scope="col">comment</th>
                        <th scope="col">edit if inactive</th>
                        <th scope="col">delete if inactive</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $d)
                        <tr>
                        <th scope="row">{{$d->topic}}</th>
                        <td>{{$d->type}}</td>
                        <td>{{$d->presenting_date}}</td>
                        <td>{{$d->status}}</td>
                        <td>{{$d->teachersname}} {{$d->teacherssurname}}</td>
                        @if($d->status=="disapproved_by_teacher")
                        <td>{{$d->comment}}</td>
                        @endif
                        @if($d->status=='inactive')
                        <td>
                            <form style='display:inline-block' action="{{url('/student/edit/'.$d->id) }}" method='GET' >
                                 {{method_field('GET')}}
                                 @csrf
                                 <button type="submit" class="btn btn-warning" >edit</button>
                             </form>
                        </td>
                        <td>
                            <form style='display:inline-block' action="{{ url('/student/delete/'.$d->id) }}" method="POST">
                                {{method_field('DELETE')}}
                                @csrf
                                <button type="submit" class="btn btn-danger" >delete</button>
                            </form>
                        </td>
                        @elseif($d->status=='disapproved_by_teacher')
                        <td>
                            <form style='display:inline-block' action="{{url('/student/edit/'.$d->id) }}" method='GET' >
                                 {{method_field('GET')}}
                                 @csrf
                                 <button type="submit" class="btn btn-warning" >edit</button>
                             </form>
                        </td>
                        @endif
                     @endforeach
                    </tbody>
                    </table>
                    <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;margin: auto;">
                      {!! $data ->links()!!}
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection

