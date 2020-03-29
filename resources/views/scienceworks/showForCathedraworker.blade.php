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
                        @if($sw->status=="approved_by_teacher")
                        <td>
                            <form style='display:inline-block' action="{{url('/cathedraworker/change-status/'.$sw->id) }}" method='POST' >
                                {{method_field('PATCH')}}
                                @csrf
                                <button type="submit" class="btn btn-warning" >activate</button>
                            </form>
                        </td>
                        <td>
                            <form style='display:inline-block' action="{{url('/cathedraworker/edit/'.$sw->id) }}" method='GET' >
                                {{method_field('GET')}}
                                @csrf
                                <button type="submit" class="btn btn-warning" >edit</button>
                            </form>
                        </td>
                        <td>
                            <form style='display:inline-block' action="{{url('/cathedraworker/disapprove/'.$sw->id) }}" method='POST' >
                                {{method_field('PATCH')}}
                                @csrf
                                <select required='required' name="who" id="who">
                                <option value="">For who?</option>
                                    <option value="student">for student</option>
                                    <option value="teacher">for teacher</option>
                                </select>
                                <input placeholder="comment" id="comment" type="text"  name="comment" value="{{ old('comment') }}" required autocomplete="comment" autofocus>                     
                                <button type="submit" class="btn btn-warning" >disapproveForStudent</button>
                            </form>
                        </td>
                        @elseif($sw->status=="active")
                        <td>
                            <form style='display:inline-block' action="{{url('/cathedraworker/change-status/'.$sw->id) }}" method='POST' >
                                {{method_field('PATCH')}}
                                @csrf
                                <button type="submit" class="btn btn-warning" >unactivate</button>
                            </form>
                        </td>
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

