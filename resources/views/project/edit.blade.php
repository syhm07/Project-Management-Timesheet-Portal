@extends('project.base')

@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update project</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('project.update', ['id' => $project->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Category</label>
                            <div class="col-md-6">
                                <select class="form-control" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" {{$category->id == $project->category_id ? 'selected' : ''}}>{{$category->type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Project Code</label>
                            <div class="col-md-6">
                                <select class="form-control" name="codes_id">
                                    @foreach ($codes as $codes)
                                        <option value="{{$codes->id}}" {{$codes->id == $project->codes_id ? 'selected' : ''}}>{{$codes->project_code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Country</label>
                            <div class="col-md-6">
                                <select class="form-control" name="country_id">
                                    @foreach ($countries as $country)
                                        <option value="{{$country->id}}" {{$country->id == $project->country_id ? 'selected' : ''}}>{{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('client') ? ' has-error' : '' }}">
                            <label for="client" class="col-md-4 control-label">Client</label>

                            <div class="col-md-6">
                                <input id="client" type="text" class="form-control" name="client" value="{{ $project->client }}" required autofocus>

                                @if ($errors->has('client'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('client') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('project_manager') ? ' has-error' : '' }}">
                            <label for="project_manager" class="col-md-4 control-label">Project Manager</label>

                            <div class="col-md-6">
                                <input id="project_manager" type="text" class="form-control" name="project_manager" value="{{ $project->project_manager }}" required autofocus>

                                @if ($errors->has('project_manager'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('project_manager') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('project_status') ? ' has-error' : '' }}">
                            <label for="project_status" class="col-md-4 control-label">Project Status</label>

                            <div class="col-md-6">
                                <input id="project_status" type="text" class="form-control" name="project_status" value="{{ $project->project_status }}" required autofocus>

                                @if ($errors->has('project_status'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('project_status') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('budget') ? ' has-error' : '' }}">
                            <label for="budget" class="col-md-4 control-label">Budget</label>

                            <div class="col-md-6">
                                <input id="budget" type="text" class="form-control" name="budget" value="{{ $project->budget }}" required autofocus>

                                @if ($errors->has('budget'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('budget') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Start Date</label>
                            <div class="col-md-6">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" value="{{ $project->start }}" name="start" class="form-control pull-right" id="start" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">End Date</label>
                            <div class="col-md-6">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" value="{{ $project->end }}" name="end" class="form-control pull-right" id="end" required>
                                </div>
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
