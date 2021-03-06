@extends('code.base')

@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update project code</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('code.update', ['id' => $code->id]) }}" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group{{ $errors->has('project_code') ? ' has-error' : '' }}">
                            <label for="project_code" class="col-md-4 control-label">Project Code</label>

                            <div class="col-md-6">
                                <input id="project_code" type="text" class="form-control" name="project_code" value="{{ $code->project_code }}" required autofocus>

                                @if ($errors->has('project_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('project_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('project_name') ? ' has-error' : '' }}">
                            <label for="project_name" class="col-md-4 control-label">Project Name</label>

                            <div class="col-md-6">
                                <input id="project_name" type="text" class="form-control" name="project_name" value="{{ $code->project_name }}" required>

                                @if ($errors->has('project_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('project_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Department</label>
                            <div class="col-md-6">
                                <select class="form-control" name="department_id">
                                    @foreach ($departments as $department)
                                        <option {{$code->department_id == $department->id ? 'selected' : ''}} value="{{$department->id}}">{{$department->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('task') ? ' has-error' : '' }}">
                            <label for="task" class="col-md-4 control-label">Task</label>

                            <div class="col-md-6">
                                <input id="task" type="text" class="form-control" name="task" value="{{ $code->task }}" required>

                                @if ($errors->has('task'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('task') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description" value="{{ $code->description }}" required>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
