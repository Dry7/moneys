@extends('layouts.scaffold')

@section('main')

<h1>Показать платеж</h1>

<p>{{ link_to_route('payments.index', 'Все платежи') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Название</th>
				<th>Раздел</th>
				<th>Категория</th>
				<th>Компания</th>
				<th>Сумма</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $payment->name }}}</td>
					<td>{{{ $payment->section }}}</td>
					<td>{{{ $payment->category }}}</td>
					<td>{{{ $payment->company }}}</td>
					<td>{{{ $payment->summ }}}</td>
                    <td>{{ link_to_route('payments.edit', 'Обновить', array($payment->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('payments.destroy', $payment->id))) }}
                            {{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
