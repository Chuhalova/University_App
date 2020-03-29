@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$status}}</div>

                    <table class="table">
                    <thead class="thead-light">
                        <tr>
                        <th scope="col">topic</th>
                        <th scope="col">type</th>
                        <th scope="col">presenting_date</th>
                        <th scope="col">student surname + name</th>
                        <th scope="col">student speciality</th>
                        <th scope="col">student degree</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($sws as $sw)
                        <tr>
                        <th scope="row">{{$sw->topic}}</th>
                        <td>{{$sw->type}}</td>
                        <td>{{$sw->presenting_date}}</td>
                        <td>{{$sw->studentsurname}} {{$sw->studentname}}</td>
                        <td>{{$sw->specialty}}</td>
                        <td>{{$sw->degree}}</td>
                        <td>
                            @if($status=='active')
                                <form style='display:inline-block' action="{{ url('/cathedraworker/delete/'.$sw->id) }}" method="POST">
                                    {{method_field('DELETE')}}
                                    @csrf
                                    <button type="submit" class="btn btn-danger" >Скасувати заявку</button>
                                </form>
                            @elseif($status=='approved_by_teacher')
                                <form style='display:inline-block' action="{{url('/cathedraworker/change-status/'.$sw->id) }}" method='POST' >
                                    {{method_field('PATCH')}}
                                    @csrf
                                    <button type="submit" class="btn btn-warning" >Деактивувати</button>
                                </form>
                            @endif
                        </td>
                        <td>
                            @if($status=='inactive')
                                <form style='display:inline-block' action="{{url('/cathedraworker/change-status/'.$sw->id) }}" method='POST' >
                                    {{method_field('PATCH')}}
                                    @csrf
                                    <button type="submit" class="btn btn-warning" >Активувати</button>
                                </form>
                            @elseif($status=='approved_by_teacher')
                                <form style='display:inline-block' action="{{ url('/cathedraworker/delete/'.$sw->id) }}" method="POST">
                                        {{method_field('DELETE')}}
                                        @csrf
                                        <button type="submit" class="btn btn-danger" >Скасувати заявку</button>
                                </form>
                            @endif
                        </td>   
                        </tr>
                    @endforeach
                    </tbody>
                    </table>
                    <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;margin: auto;">
                      {!! $sws->links()!!}
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

