@extends('layouts.login')

@push('styles')
{!! HTML::style('vendor/AdminLTE/plugins/iCheck/square/blue.css') !!}
@endpush

{{-- Web site Title --}}
@section('title')
    @lang('auth.login')
@endsection

{{-- Content --}}
@section('content')
    <!-- start: LOGIN BOX -->
    <p class="login-box-msg">@lang('auth.sign_title')</p>

    {!! Form::open(array('url' => '/login')) !!}
    <div class="form-group has-feedback">
        {!! Form::text('username', null, array(
                    'class' => 'form-control',
                    'placeholder' => trans('auth.username'),
                    'required' => 'required',
                    'autofocus' => 'autofocus'
                    )) !!}
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        {!! Form::password('password', array(
                    'class' => 'form-control password',
                    'placeholder' => trans('auth.password'),
                    'required' => 'required'
                    )) !!}
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
        <div class="col-xs-8">
            <div class="checkbox icheck">
                <label>
                    {!! Form::checkbox('remember', '1', false) !!}
                    @lang('auth.remember_me')
                </label>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
            {!! Form::button(trans('auth.login'), ['type' => 'submit', 'class' => 'btn btn-primary btn-block btn-flat', 'id' => 'submit']) !!}
        </div>
        <!-- /.col -->
    </div>
    {!! Form::close() !!}
    {{--
    <a href="{{ url('/password/reset') }}">
        {{ trans('auth.forgot_password') }}
    </a><br>
    <a href="{{ url('auth/register') }}" class="text-center">
        {{ trans('auth.create_account') }}
    </a>
    --}}
    <!-- end: LOGIN BOX -->
@endsection

@push('scripts')
{!! HTML::script('vendor/AdminLTE/plugins/iCheck/icheck.min.js') !!}
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });
    });
</script>
@endpush
