@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>
                <div class="card-body">
                @if($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li >{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif 
                <form style='display:inline-block' action="{{url('/student/update/'.$sw->id) }}" method='POST' >
                                    {{method_field('PATCH')}}
                                    @csrf
                        <div class="form-group row">
                            <label for="topic" class="col-md-4 col-form-label text-md-right">{{ __('Topic') }}</label>
                            <div class="col-md-6">
                                <input id="topic" type="text"  name="topic" value="{{ $sw->topic }}"  required autocomplete="topic" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">                        
                                 <label for="type" class="col-md-4 col-form-label text-md-right">{{ __("type") }}</label>
                                     <div class="col-md-6">
                                          <select class='type' id="type" name="type">
                                        @if($sw->type=='bachaelor coursework')
                                            <option selected="selected" value='bachaelor coursework'>bachaelor coursework</option>
                                            <option value='bachaelor dyploma'>bachaelor dyploma</option>
                                            <option value='major coursework'>major coursework</option>
                                            <option value='major dyploma'>major dyploma</option>
                                        @elseif($sw->type=='bachaelor dyploma')
                                            <option value='bachaelor coursework'>bachaelor coursework</option>
                                            <option selected="selected" value='bachaelor dyploma'>bachaelor dyploma</option>
                                            <option value='major coursework'>major coursework</option>
                                            <option value='major dyploma'>major dyploma</option>
                                        @elseif($sw->type=='major coursework')
                                            <option value='bachaelor coursework'>bachaelor coursework</option>
                                            <option value='bachaelor dyploma'>bachaelor dyploma</option>
                                            <option selected="selected" value='major coursework'>major coursework</option>
                                            <option value='major dyploma'>major dyploma</option>
                                        @elseif($sw->type=='major dyploma')
                                            <option value='bachaelor coursework'>bachaelor coursework</option>
                                            <option value='bachaelor dyploma'>bachaelor dyploma</option>
                                            <option value='major coursework'>major coursework</option>
                                            <option selected="selected" value='major dyploma'>major dyploma</option>
                                        @else
                                            <option value='bachaelor coursework'>bachaelor coursework</option>
                                            <option value='bachaelor dyploma'>bachaelor dyploma</option>
                                            <option value='major coursework'>major coursework</option>
                                            <option value='major dyploma'>major dyploma</option>
                                        @endif
                                         </select>
                                    </div>
                            </div>
                        <div class="form-group row">
                            <label for="presenting_date" class="col-md-4 col-form-label text-md-right">{{ __('presenting_date') }}</label>
                            <div class="col-md-6">
                            <input type="date" id="presenting_date" name="presenting_date" value="{{ $sw->presenting_date }}" min="1990-01-01" max="2040-12-31">
                            </div>
                        </div>   
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button  type="submit" class="btn btn-primary" >
                                    {{ __('edit') }}
                                </button>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
