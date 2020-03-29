@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>

                    <table class="table">
                    <thead class="thead-light">
                        <tr>
                        <th scope="col">topic</th>
                        <th scope="col">type</th>
                        <th scope="col">presenting_date</th>
                        <th scope="col">status</th>
                        <th scope="col">comment</th>
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
                        <td>{{$sw->status}}</td>
                        <td>{{$sw->comment}}</td>
                        @if($sw->status == 'disapproved_for_teacher')
                        <td>
                            <form style='display:inline-block' action="{{url('/teacher/edit/'.$sw->id) }}" method='GET' >
                                {{method_field('GET')}}
                                @csrf
                                <button type="submit" class="btn btn-warning" >edit</button>
                            </form>
                        </td>
                        @elseif($sw->status == 'inactive')
                        <td>
                            <form style='display:inline-block' action="{{url('/teacher/edit/'.$sw->id) }}" method='GET' >
                                {{method_field('GET')}}
                                @csrf
                                <button type="submit" class="btn btn-warning" >edit</button>
                            </form>
                        </td>
                        <td>
                            <form style='display:inline-block' action="{{url('/teacher/change-status/'.$sw->id) }}" method='POST' >
                                {{method_field('PATCH')}}
                                @csrf
                                <button type="submit" class="btn btn-warning" >activate</button>
                            </form>
                        </td>
                        @elseif($sw->status == 'approved_by_teacher')
                        <td>
                            <form style='display:inline-block' action="{{url('/teacher/change-status/'.$sw->id) }}" method='POST' >
                                {{method_field('PATCH')}}
                                @csrf
                                <button type="submit" class="btn btn-warning" >inactivate</button>
                            </form>
                        </td>
                        @elseif($sw->status == 'active')
                        @endif
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

