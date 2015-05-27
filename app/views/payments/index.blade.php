@extends('layouts.scaffold')

@section('main')

<?php

?>

<h1>Все платежи</h1>

<p>{{ link_to_route('payments.create', 'Добавить платеж') }}</p>

<div class="daterangepicker dropdown-menu opensright summFilter">
	<div class="row">
		<div class="col-lg-6">
			<div class="input-group">
      <span class="input-group-addon">
        От
      </span>
				<input type="text" class="form-control" aria-label="...">
			</div><!-- /input-group -->
		</div><!-- /.col-lg-6 -->
		<div class="col-lg-6">
			<div class="input-group">
      <span class="input-group-addon">
        До
      </span>
				<input type="text" class="form-control" aria-label="...">
			</div><!-- /input-group -->
		</div><!-- /.col-lg-6 -->
	</div>
</div>

@if ($payments->count())
	<form class="payments" method="GET" action="/payments">
	<table class="table table-striped table-bordered payments">
		<thead>
			<tr>
				<th>Дата</th>
				<th>Название</th>
				<th>Раздел</th>
				<th>Категория</th>
				<th>Компания</th>
				<th>Сумма</th>
				<th colspan="2"></th>
			</tr>
			<tr>
				<th><input type="text" name="created_at" class="form-control" value="" style="width: 120px;" /></th>
				<th><input type="text" name="name" class="form-control" value="" /></th>
				<th><input type="text" name="section" class="form-control" value="" /></th>
				<th><input type="text" name="category" class="form-control" value="" /></th>
				<th><input type="text" name="company" class="form-control" value="" style="width: 100px;" /></th>
				<th><input type="text" name="summ" class="form-control" value="" style="width: 100px;" /></th>
				<th colspan="2"></th>
			</tr>
		</thead>

		<tbody>
			@foreach ($payments as $payment)
				<tr>
					<td>{{{ $payment->created_at }}}</td>
					<td>{{{ $payment->name }}}</td>
					<td>{{{ $payment->section }}}</td>
					<td>{{{ $payment->category }}}</td>
					<td><?php if ( $payment->company_image != '' ) { ?><img src="<?php echo $payment->company_image; ?>" style="width: 20px;"/><?php } ?> {{{ $payment->company }}}</td>
					<td>{{{ $payment->summ }}} р.</td>
                    <td>{{ link_to_route('payments.edit', 'Обновить', array($payment->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('payments.destroy', $payment->id))) }}
                            {{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
	</form>
@else
	Еще нет платежей
@endif

    {{ HTML::script('//code.jquery.com/jquery-2.1.3.min.js') }}
	<script type="text/javascript">
	</script>

{{ HTML::script('/js/moment.min.js') }}
{{ HTML::script('/js/daterangepicker.js') }}
{{ HTML::style('/css/daterangepicker-bs3.css') }}
{{ HTML::style('http://css-spinners.com/css/spinner/whirly.css') }}
<script type="text/javascript">
	$(document).ready(function() {
		/** Загружаем данные о платежах */
		function loadPaymentsData() {
			$('form.payments input[name=_method]').val('GET');
			$('table.payments tbody').html('<tr class="loading"><td colspan="8"><div class="whirly">Загрузка...</div></td></tr>');
			$.getJSON("/payments", 'format=json&' + $('form.payments').serialize()).done(function(data){
				$('table.payments tbody').html('');
				for ( var i = 0; i < data.length; i++ ) {
					var company_image = '';

					if ( data[i].company_image !== '' ) { company_image = '<img src="' + data[i].company_image + '" style="width: 16px;" /> '; }

					$('table.payments tbody').append(
							'<tr>' +
						    	'<td>' + data[i].created_at + '</td>' +
							    '<td>' + data[i].name + '</td>' +
							    '<td>' + data[i].section + '</td>' +
							    '<td>' + data[i].category + '</td>' +
							    '<td>' + company_image + ' ' + data[i].company + '</td>' +
							    '<td>' + data[i].summ + '</td>' +
							    '<td><a href="/payments/' + data[i].id + '/edit" class="btn btn-info">Обновить</a></td>' +
							    '<td>' +
							        '<form method="POST" action="/payments/' + data[i].id + '" accept-charset="UTF-8"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="l9fPTNjckl5PXbHR2ufbdECo7jbu56EaUYHOAVwC">' +
							            '<input class="btn btn-danger" type="submit" value="Удалить">' +
							        '</form>' +
							    '</td>' +
							'</tr>'
					);
				}
			});
		}

		$('input[name=created_at]').daterangepicker({
		    timePicker: true,
		    timePickerIncrement: 10,
		    format: "YYYY-MM-DD HH:mm:ss",
		    timePicker12Hour: false,
		    singleDatePicker: false,
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
	    }, function(){ loadPaymentsData(); });

		$('table.payments input[type=text]').on('keyup', function(){ loadPaymentsData(); });
		$('table.payments input[type=text]').on('change', function(){ loadPaymentsData(); });

		$('table.payments input[name=summ]').click(function(){
			$('div.summFilter').css({top: $(this).offset().top+30, left:$(this).offset().left}).show();
		});

		var _outsideClickProxy2 = $.proxy(function (e) { outsideClick2(e); }, this);

		$(document)
				.on('mousedown.summFilter', _outsideClickProxy2)
				.on('click.summFilter', '[data-toggle=dropdown]', _outsideClickProxy2)
				.on('focusin.summFilter', _outsideClickProxy2);


		function outsideClick2(e) {
			var target = $(e.target);
			// if the page is clicked anywhere except within the daterangerpicker/button
			// itself then call this.hide()
			if (
					target.closest(this.element).length ||
					target.closest(this.container).length ||
					target.closest('.calendar-date').length ||
					target.hasClass('summFilter')
			) return;
			$('div.summFilter').hide();
		};
	});</script>
	<style type="text/css">
		.daterangepicker {
			width: 500px;
		}
		.daterangepicker .ranges {
			width: 100%;
			text-align: center;
		}
		.daterangepicker .ranges .range_inputs>div {
			width: 49%;
		}
		.daterangepicker .ranges .input-mini {
			width: 110px;
		}
		.daterangepicker .daterangepicker_start_input label, .daterangepicker .daterangepicker_end_input label {
			display: inline;
		}
		.daterangepicker .ranges .input-mini {
			display: inline;
			text-align: center;
			margin-left: 10px;
			margin-right: 10px;
		}
		.daterangepicker_start_input {
			text-align: right;
		}
		.daterangepicker_end_input {
			text-align: left;
		}
		.summFilter {
			width: 200px;
		}
		tr.loading td {
			text-align: center;
			height: 100px;
			padding-top: 35px!important;
		}
	</style>
@stop
