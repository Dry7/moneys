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
{{ HTML::script('https://www.google.com/jsapi') }}
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Дата', 'Расходы'],
<?php foreach ( $days as $day ) { ?>
          ['<?php echo $day->created_at; ?>', <?php echo $day->summ; ?>],
<?php } ?>
        ]);

        var options = {
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('days_div'));

        chart.draw(data, options);

        var data = google.visualization.arrayToDataTable([
          ['Секция', 'Расходы'],
<?php foreach ( $sections as $section ) { ?>
          ['<?php echo $section->section; ?>', <?php echo $section->summ; ?>],
<?php } ?>
        ]);

        var options = {
        };

        var chart = new google.visualization.PieChart(document.getElementById('sections_div'));

        chart.draw(data, options);

        var data = google.visualization.arrayToDataTable([
          ['Категория', 'Расходы'],
<?php foreach ( $food as $row ) { ?>
          ['<?php echo $row->category; ?>', <?php echo $row->summ; ?>],
<?php } ?>
        ]);

        var options = {
        };

        var chart = new google.visualization.PieChart(document.getElementById('food_div'));

        chart.draw(data, options);
      }
    </script>
@section('main')

<h1>Панель управления</h1>

<p>Добрый день, <b>{{{ Auth::user()->username }}}</b></p>
<div id="days_div" style="width: 900px; height: 500px;"></div>
<?php var_dump( $total ); ?>
<div id="sections_div" style="width: 900px; height: 500px;"></div>
<div id="food_div" style="width: 900px; height: 500px;"></div>

<h1>Добавить платеж</h1>

{{ Form::open(array('route' => 'payments.store')) }}

    {{ Form::label('created_at', 'Дата:') }}
    {{ Form::text('created_at', date('Y-m-d H:i:s'), array('type' => 'text', 'class' => 'form-control datepicker', 'id' => 'calendar')) }}

    {{ Form::label('company', 'Компания:') }}
    {{ Form::text('company', '') }}

<table class="table">
  <tr>
    <th>Название</th>
    <th>Раздел</th>
    <th>Категория</th>
    <th>Сумма</th>
  </tr>
@for ( $i = 0; $i < 10; $i++ )
  <tr>
    <td><input type="text" name="name[{{ $i }}]" value="" /></td>
    <td><input type="text" name="section[{{ $i }}]" value="" /></td>
    <td><input type="text" name="category[{{ $i }}]" value="" /></td>
    <td><input type="text" name="summ[{{ $i }}]" value="" /></td>
  </tr>
@endfor
</table>
    {{ Form::submit('Добавить', array('class' => 'btn btn-info')) }}
{{ Form::close() }}

@stop