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
        /** Расходы по дням */
        var data = google.visualization.arrayToDataTable([
          ['Дата', 'Расходы'],
<?php foreach ( $days as $day ) { ?>
          ['<?php echo HTML::entities($day->created_at); ?>', <?php echo $day->summ; ?>],
<?php } ?>
        ]);

        var chart = new google.visualization.ColumnChart(document.getElementById('days_div'));

        chart.draw(data, {title: 'Расходы по дням'});

        /** Разделы */
        var data = google.visualization.arrayToDataTable([
          ['Секция', 'Расходы'],
<?php foreach ( $sections as $section ) { ?>
          ['<?php echo HTML::entities($section->section); ?>', <?php echo $section->summ; ?>],
<?php } ?>
        ]);

        var chart = new google.visualization.PieChart(document.getElementById('sections_div'));

        chart.draw(data, {title: 'Расходы по разделам'});

        /** Расходы на еду */
        var data = google.visualization.arrayToDataTable([
          ['Категория', 'Расходы'],
<?php foreach ( $food as $row ) { ?>
          ['<?php echo HTML::entities($row->category); ?>', <?php echo $row->summ; ?>],
<?php } ?>
        ]);

        var chart = new google.visualization.PieChart(document.getElementById('food_div'));

        chart.draw(data, {title: 'Расходы на еду'});

        /** Магазины */
        var chart_shops = new google.visualization.PieChart(document.getElementById('shops_div'));

        chart_shops.draw(google.visualization.arrayToDataTable([
            ['Компания', 'Расходы'],
            <?php foreach ( $shops as $row ) { ?>
            ['<?php echo HTML::entities($row->company); ?>', <?php echo $row->summ; ?>],
            <?php } ?>
        ]), {title: 'Расходы по магазинам'});

        /** Расходы по месяцам */
        var chart_months = new google.visualization.LineChart(document.getElementById('months_div'));

        chart_months.draw(
            google.visualization.arrayToDataTable([
                ['Месяц', 'Расходы'],
                <?php foreach ( $months as $row ) { ?>
                ['<?php echo HTML::entities($row->month); ?>', <?php echo $row->summ; ?>],
                <?php } ?>
            ]),
            { title: 'Расходы по месяцам', curveType: 'function', legend: { position: 'bottom' } }
        );


        /** Расходы по месяцам на еду */
        var chart_months_food = new google.visualization.LineChart(document.getElementById('months_food_div'));

        chart_months_food.draw(
                google.visualization.arrayToDataTable([
                    ['Месяц', 'Расходы'],
                    <?php foreach ( $months_food as $row ) { ?>
                    ['<?php echo HTML::entities($row->month); ?>', <?php echo $row->summ; ?>],
                    <?php } ?>
                ]),
                { title: 'Расходы по месяцам на еду', curveType: 'function', legend: { position: 'bottom' } }
        );

        /** Расходы по месяцам на еду */
        var chart_months_clothing = new google.visualization.LineChart(document.getElementById('months_clothing_div'));

        chart_months_clothing.draw(
                google.visualization.arrayToDataTable([
                    ['Месяц', 'Расходы'],
                    <?php foreach ( $months_clothing as $row ) { ?>
                    ['<?php echo HTML::entities($row->month); ?>', <?php echo $row->summ; ?>],
                    <?php } ?>
                ]),
                { title: 'Расходы по месяцам на одежду', curveType: 'function', legend: { position: 'bottom' } }
        );

        /** Расходы по месяцам на квартиру */
        var chart_months_apartment = new google.visualization.LineChart(document.getElementById('months_apartment_div'));

        chart_months_apartment.draw(
                google.visualization.arrayToDataTable([
                    ['Месяц', 'Расходы'],
                    <?php foreach ( $months_apartment as $row ) { ?>
                    ['<?php echo HTML::entities($row->month); ?>', <?php echo $row->summ; ?>],
                    <?php } ?>
                ]),
                { title: 'Расходы по месяцам на квартиру', curveType: 'function', legend: { position: 'bottom' } }
        );
      }
    </script>
@section('main')

<h1>Панель управления</h1>

<p>Добрый день, <b>{{{ Auth::user()->username }}}</b></p>
<div id="days_div" style="width: 900px; height: 500px;"></div>

<b>Расходов всего: </b>
<span><?php echo number_format( $total, 2, '.', ' ' ); ?> р.</span>

<div id="sections_div" style="width: 900px; height: 500px;"></div>
<div id="food_div" style="width: 900px; height: 500px;"></div>
<div id="shops_div" style="width: 900px; height: 500px;"></div>
<div id="months_div" style="width: 900px; height: 500px;"></div>
<div id="months_food_div" style="width: 900px; height: 500px;"></div>
<div id="months_clothing_div" style="width: 900px; height: 500px;"></div>
<div id="months_apartment_div" style="width: 900px; height: 500px;"></div>


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