@extends('layouts.app')
@section('content')
<div class="has_role_for_icon">
    <h5 class="pre_icon_text">{{$baseinfo->surname . ' ' . $name_f_l . '. ' . $fathername_f_l . '.'}}</h5>
    @if(\Illuminate\Support\Facades\Auth::user()->hasRole('superadmin'))
    <div class="admin_icon"></div>
    @else
    <div class="user_icon"></div>
    @endif
</div>
<div id='profile_avatar_container' class="d-flex align-items-center justify-items-center flex-column">
    <div class="text-center">
        @if(($url)==null)
        <div class="profile_avatar_displaying col-12">
            <img src="{{ asset('empty-avatar.png')}}" width="100" height="100">
        </div>
        <div class="form-group profile_avatar_displaying col-12">
            @if(count($errors))
            <div class="alert alert-danger" role="alert">
                <ul class="error_container">
                    @foreach($errors->all() as $key => $value)
                    <li class="error_li">{{ $value }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form enctype='multipart/form-data' action="{{url('/profile/avatar/') }}" method="post">
                {{method_field('PUT')}}
                {{ csrf_field() }}
                <input type="file" class="input_change_avatar" name="avatar" />
                <button type="submit" style="margin:auto;width:150px" class="btn btn-primary">Додати фото</button>
            </form>
        </div>
        @else
        <div class="profile_avatar_displaying col-12">

            <img src="{{ URL::to($url)}}" class="rounded-circle" width="100" height="100" />
        </div>
        <div class="form-group profile_avatar_displaying col-12">
            @if(count($errors))
            <div class="alert alert-danger" role="alert">
                <ul class="error_container">
                    @foreach($errors->all() as $key => $value)
                    <li class="error_li">{{ $value }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form enctype='multipart/form-data' action="{{url('/profile/avatar/') }}" method="post">
                {{method_field('PUT')}}
                {{ csrf_field() }}
                <input type="file" class="input_change_avatar" name="avatar" />
                <button type="submit" style="margin:auto;width:150px" class="btn btn-primary">Змінити фото</button>
            </form>
            <form style="margin-top:10px !important;" action="{{url('/profile/avatar-del/') }}" method="post">
                {{method_field('PUT')}}
                {{ csrf_field() }}
                <button type="submit" style="margin:auto;width:150px" class="btn btn-primary">Видалити фото</button>
            </form>
        </div>
        @endif
    </div>
</div>
<div class="card-body">


    <div style="padding-top:30px!important;" id='profile-table' class="table-wrapper">
        <h2 class="title text-center">Основна інформація</h2>
        <table class="prof-table">
            <thead>
                <tr>
                    <th>{{$baseinfo->surname . ' ' . $name_f_l . '. ' . $fathername_f_l . '.'}}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="col-md-6">Email</td>
                    <td class="col-md-6">{{$user->email}}</td>
                </tr>
                @role('student')
                @if($student->studnumber!=null)
                <tr>
                    <td class="col-md-6">Номер студентського</td>
                    <td class="col-md-6">{{$student->studnumber}}</td>
                </tr>
                @endif
                @if($student->entry_date!=null)
                <tr>
                    <td class="col-md-6">Дата вступу</td>
                    <td class="col-md-6">{{$student->entry_date}}</td>
                </tr>
                @endif
                @if($student->real_grad_date!=null)
                <tr>
                    <td class="col-md-6">Дата випуску</td>
                    <td class="col-md-6">{{$student->real_grad_date}}</td>
                </tr>
                @endif
                @if($student->degree!=null)
                <tr>
                    <td class="col-md-6">Ступінь</td>
                    <td class="col-md-6">{{$student->degree}}</td>
                </tr>
                @endif
                @if($student->specialty!=null&&$student->specialty_abbr!=null&&$student->year!=null&&$student->group!=null)
                <tr>
                    <td class="col-md-6">Спеціальність, спеціальність + група</td>
                    <td class="col-md-6">{{$student->specialty . ', ' . $student->specialty_abbr. '-' . $student->year . '' . $student->group}}</td>
                </tr>
                @endif
                @endrole
                @role('teacher')
                @if($teacher->workbooknumber!=null)
                <tr>
                    <td class="col-md-6">Номер трудової книжки</td>
                    <td class="col-md-6">{{$teacher->workbooknumber}}</td>
                </tr>
                @endif
                @if($teacher->science_degree!=null)
                <tr>
                    <td class="col-md-6">Науковий ступінь</td>
                    <td class="col-md-6">{{$teacher->science_degree}}</td>
                </tr>
                @endif
                @if($teacher->scientific_rank!=null)
                <tr>
                    <td class="col-md-6">Наукове звання</td>
                    <td class="col-md-6">{{$teacher->scientific_rank}}</td>
                </tr>
                @endif
                @if($teacher->position!=null)
                <tr>
                    <td class="col-md-6">Посада</td>
                    <td class="col-md-6">{{$teacher->position}}</td>
                </tr>
                @endif
                @if($teacher->start_date!=null)
                <tr>
                    <td class="col-md-6">Дата початку роботи</td>
                    <td class="col-md-6">{{$teacher->start_date}}</td>
                </tr>
                @endif
                @if($teacher->end_of_work_date!=null)
                <tr>
                    <td class="col-md-6">Дата закічення роботи</td>
                    <td class="col-md-6">{{$teacher->end_of_work_date}}</td>
                </tr>
                @endif
                @endrole
            </tbody>
        </table>
    </div>

</div>
@endsection