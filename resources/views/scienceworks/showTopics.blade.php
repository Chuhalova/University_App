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
                        <th scope="col"></th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($sws as $sw)
                        <tr>
                        <th scope="row">{{$sw->topic}}</th>
                        <td>{{$sw->type}}</td>
                        <td>
                            <form style='display:inline-block' action="{{url('/teacher/editTopic/'.$sw->id) }}" method='GET' >
                                 {{method_field('GET')}}
                                 @csrf
                                 <button type="submit" class="btn btn-warning" >edittopic</button>
                             </form>
                        </td>
                        <td>
                            <form style='display:inline-block' action="{{ url('/teacher/deleteTopic/'.$sw->id) }}" method="POST">
                                {{method_field('DELETE')}}
                                @csrf
                                <button type="submit" class="btn btn-danger" >deletetopic</button>
                            </form>
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

