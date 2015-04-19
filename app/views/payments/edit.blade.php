@extends('layouts.scaffold')
{{ HTML::script('//code.jquery.com/jquery-2.1.3.min.js') }}
{{ HTML::script('/js/moment.min.js') }}
{{ HTML::script('/js/daterangepicker.js') }}
{{ HTML::style('/css/daterangepicker-bs3.css') }}
<script type="text/javascript">$(document).ready(function() {$('#calendar').daterangepicker({
                    timePicker: true,
                    timePickerIncrement: 10,
                    format: "YYYY-MM-DD HH:mm:ss",
                    timePicker12Hour: false,
                    singleDatePicker: true,
                    locale: {
                applyLabel: "Выбрать",
                cancelLabel: "Отменить",
                fromLabel: "От",
                toLabel: "До",
                weekLabel: "Н",
                customRangeLabel: "Настраиваемый диапазон",
                daysOfWeek: moment.weekdaysMin(),
                monthNames: moment.monthsShort(),
                firstDay: 1
            }
                  });} );</script>
@section('main')

<h1>Обновить платеж</h1>
{{ Form::model($payment, array('method' => 'PATCH', 'route' => array('payments.update', $payment->id))) }}
	<ul>
        <li>
            {{ Form::label('created_at', 'Дата:') }}
            {{ Form::text('created_at', null, array('type' => 'text', 'class' => 'form-control datepicker','placeholder' => 'Pick the date this task should be completed', 'id' => 'calendar')) }}
        </li>

        <li>
            {{ Form::label('name', 'Название:') }}
            {{ Form::text('name') }}
        </li>

        <li>
            {{ Form::label('section', 'Раздел:') }}
            {{ Form::text('section') }}
        </li>

        <li>
            {{ Form::label('category', 'Категория:') }}
            {{ Form::text('category') }}
        </li>

        <li>
            {{ Form::label('company', 'Компания:') }}
            {{ Form::text('company') }}
        </li>

        <li>
            {{ Form::label('summ', 'Сумма:') }}
            {{ Form::text('summ') }}
        </li>

		<li>
			{{ Form::submit('Обновить', array('class' => 'btn btn-info')) }}
			{{ link_to_route('payments.show', 'Отменить', $payment->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
