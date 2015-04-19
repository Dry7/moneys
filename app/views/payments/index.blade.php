@extends('layouts.scaffold')

@section('main')

<h1>Все платежи</h1>

<p>{{ link_to_route('payments.create', 'Добавить платеж') }}</p>

@if ($payments->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Дата</th>
				<th>Название</th>
				<th>Раздел</th>
				<th>Категория</th>
				<th>Компания</th>
				<th>Сумма</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($payments as $payment)
				<tr>
					<td>{{{ $payment->created_at }}}</td>
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
			@endforeach
		</tbody>
	</table>
@else
	Еще нет платежей
@endif

@stop
